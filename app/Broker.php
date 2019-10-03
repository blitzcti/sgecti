<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class Broker extends \Jasny\SSO\Broker
{
    public function __construct($cookie_lifetime = 3600)
    {
        $url = config('broker.url');
        $broker = config('broker.name');
        $secret = config('broker.secret');

        parent::__construct($url, $broker, $secret, $cookie_lifetime);
        $this->token = null;

        $this->saveToken();
    }

    public function serverLoginPage()
    {
        $parameters = [
            'return_url' => $this->getCurrentUrl(),
            'broker' => $this->broker,
            'session_id' => $this->getSessionId(),
        ];

        return $this->generateCommandUrl('loginForm', $parameters);
    }

    /**
     * Attach client session to broker session in SSO server.
     *
     * @param null $returnUrl
     * @return void
     */
    public function attach($returnUrl = null)
    {
        $parameters = [
            'return_url' => $this->getCurrentUrl(),
            'broker' => $this->broker,
            'token' => $this->token,
            'checksum' => hash('sha256', 'attach' . $this->token . $this->secret)
        ];

        $attachUrl = $this->generateCommandUrl('attach', $parameters);

        $this->redirect($attachUrl);
    }

    /**
     * Getting user info from SSO based on client session.
     *
     * @return array
     * @throws GuzzleException
     */
    public function getUserInfo()
    {
        if (!isset($this->userinfo) || empty($this->userinfo)) {
            $this->userinfo = $this->makeRequest('GET', 'userInfo');
        }

        return $this->userinfo;
    }

    /**
     * Login client to SSO server with user credentials.
     *
     * @param string $email
     * @param string $password
     * @param bool $remember
     *
     * @return bool
     * @throws GuzzleException
     */
    public function login($email = null, $password = null, $remember = false)
    {
        $this->userinfo = $this->makeRequest('POST', 'login', ["email" => $email, "password" => $password, "remember" => $remember]);

        if (!isset($this->userinfo['error']) && isset($this->userinfo['data']['id'])) {
            $this->guard()->loginUsingId($this->userinfo['data']['id'], $remember);

            return true;
        }

        return false;
    }

    /**
     * Logout client from SSO server.
     *
     * @return void
     * @throws GuzzleException
     */
    public function logout()
    {
        $this->makeRequest('POST', 'logout');
    }

    /**
     * Generate request url.
     *
     * @param string $command
     * @param array $parameters
     *
     * @return string
     */
    protected function generateCommandUrl($command, $parameters = [])
    {
        $query = '';
        if (!empty($parameters)) {
            $query = '?' . http_build_query($parameters);
        }

        if ($command == 'loginForm') {
            return $this->url . '/loginForm' . $query;
        }

        return $this->url . '/api/sso/' . $command . $query;
    }

    /**
     * Generate session key with broker name, broker secret and unique client token.
     *
     * @return string
     */
    protected function getSessionId()
    {
        $checksum = hash('sha256', 'session' . $this->token . $this->secret);
        return "SSO-{$this->broker}-{$this->token}-$checksum";
    }

    /**
     * Save unique client token to cookie.
     *
     * @return void
     */
    protected function saveToken()
    {
        if (isset($this->token) && $this->token) {
            return;
        }

        if ($this->token = Cookie::get($this->getCookieName(), null)) {
            return;
        }

        // If cookie token doesn't exist, we need to create it with unique token...
        $this->token = Str::random(40);
        Cookie::queue(Cookie::make($this->getCookieName(), $this->token, 60));

        // ... and attach it to broker session in SSO server.
        $this->attach();
    }

    /**
     * Delete saved unique client token.
     *
     * @return void
     */
    protected function deleteToken()
    {
        $this->token = null;
        Cookie::forget($this->getCookieName());
    }

    /**
     * Make request to SSO server.
     *
     * @param string $method Request method 'post' or 'get'.
     * @param string $command Request command name.
     * @param array $parameters Parameters for URL query string if GET request and form parameters if it's POST request.
     *
     * @return array
     * @throws GuzzleException
     */
    protected function makeRequest($method, $command, $parameters = [])
    {
        $commandUrl = $this->generateCommandUrl($command);

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getSessionId(),
        ];

        switch ($method) {
            case 'POST':
                $body = ['form_params' => $parameters];
                break;
            case 'GET':
                $body = ['query' => $parameters];
                break;
            default:
                $body = [];
                break;
        }

        $client = new Client;
        $response = $client->request($method, $commandUrl, $body + ['headers' => $headers]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Redirect client to specified url.
     *
     * @param string $url URL to be redirected.
     * @param array $parameters HTTP query string.
     * @param int $httpResponseCode HTTP response code for redirection.
     *
     * @return void
     */
    protected function redirect($url, $parameters = [], $httpResponseCode = 307)
    {
        $query = '';
        // Making URL query string if parameters given.
        if (!empty($parameters)) {
            $query = '?';

            if (parse_url($url, PHP_URL_QUERY)) {
                $query = '&';
            }

            $query .= http_build_query($parameters);
        }

        app()->abort($httpResponseCode, '', ['Location' => $url . $query]);
    }

    /**
     * Getting current url which can be used as return to url.
     *
     * @return string
     */
    protected function getCurrentUrl()
    {
        return url()->full();
    }

    /**
     * Cookie name in which we save unique client token.
     *
     * @return string
     */
    protected function getCookieName()
    {
        // Cookie name based on broker's name because there can be some brokers on same domain
        // and we need to prevent duplications.
        return 'sso_token_' . preg_replace('/[_\W]+/', '_', strtolower($this->broker));
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
