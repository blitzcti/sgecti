<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ExternalAPISController extends Controller
{
    /**
     * Remove accents from a given string
     * Original implementation from WordPress: https://core.trac.wordpress.org/browser/tags/5.2/src/wp-includes/formatting.php#L1596
     *
     * @param string $string
     * @return string
     */
    function removeAccents($string)
    {
        if (!preg_match('/[\x80-\xff]/', $string))
            return $string;

        $chars = array(
            // Decompositions for Latin-1 Supplement
            chr(195) . chr(128) => 'A', chr(195) . chr(129) => 'A',
            chr(195) . chr(130) => 'A', chr(195) . chr(131) => 'A',
            chr(195) . chr(132) => 'A', chr(195) . chr(133) => 'A',
            chr(195) . chr(135) => 'C', chr(195) . chr(136) => 'E',
            chr(195) . chr(137) => 'E', chr(195) . chr(138) => 'E',
            chr(195) . chr(139) => 'E', chr(195) . chr(140) => 'I',
            chr(195) . chr(141) => 'I', chr(195) . chr(142) => 'I',
            chr(195) . chr(143) => 'I', chr(195) . chr(145) => 'N',
            chr(195) . chr(146) => 'O', chr(195) . chr(147) => 'O',
            chr(195) . chr(148) => 'O', chr(195) . chr(149) => 'O',
            chr(195) . chr(150) => 'O', chr(195) . chr(153) => 'U',
            chr(195) . chr(154) => 'U', chr(195) . chr(155) => 'U',
            chr(195) . chr(156) => 'U', chr(195) . chr(157) => 'Y',
            chr(195) . chr(159) => 's', chr(195) . chr(160) => 'a',
            chr(195) . chr(161) => 'a', chr(195) . chr(162) => 'a',
            chr(195) . chr(163) => 'a', chr(195) . chr(164) => 'a',
            chr(195) . chr(165) => 'a', chr(195) . chr(167) => 'c',
            chr(195) . chr(168) => 'e', chr(195) . chr(169) => 'e',
            chr(195) . chr(170) => 'e', chr(195) . chr(171) => 'e',
            chr(195) . chr(172) => 'i', chr(195) . chr(173) => 'i',
            chr(195) . chr(174) => 'i', chr(195) . chr(175) => 'i',
            chr(195) . chr(177) => 'n', chr(195) . chr(178) => 'o',
            chr(195) . chr(179) => 'o', chr(195) . chr(180) => 'o',
            chr(195) . chr(181) => 'o', chr(195) . chr(182) => 'o',
            chr(195) . chr(182) => 'o', chr(195) . chr(185) => 'u',
            chr(195) . chr(186) => 'u', chr(195) . chr(187) => 'u',
            chr(195) . chr(188) => 'u', chr(195) . chr(189) => 'y',
            chr(195) . chr(191) => 'y',
            // Decompositions for Latin Extended-A
            chr(196) . chr(128) => 'A', chr(196) . chr(129) => 'a',
            chr(196) . chr(130) => 'A', chr(196) . chr(131) => 'a',
            chr(196) . chr(132) => 'A', chr(196) . chr(133) => 'a',
            chr(196) . chr(134) => 'C', chr(196) . chr(135) => 'c',
            chr(196) . chr(136) => 'C', chr(196) . chr(137) => 'c',
            chr(196) . chr(138) => 'C', chr(196) . chr(139) => 'c',
            chr(196) . chr(140) => 'C', chr(196) . chr(141) => 'c',
            chr(196) . chr(142) => 'D', chr(196) . chr(143) => 'd',
            chr(196) . chr(144) => 'D', chr(196) . chr(145) => 'd',
            chr(196) . chr(146) => 'E', chr(196) . chr(147) => 'e',
            chr(196) . chr(148) => 'E', chr(196) . chr(149) => 'e',
            chr(196) . chr(150) => 'E', chr(196) . chr(151) => 'e',
            chr(196) . chr(152) => 'E', chr(196) . chr(153) => 'e',
            chr(196) . chr(154) => 'E', chr(196) . chr(155) => 'e',
            chr(196) . chr(156) => 'G', chr(196) . chr(157) => 'g',
            chr(196) . chr(158) => 'G', chr(196) . chr(159) => 'g',
            chr(196) . chr(160) => 'G', chr(196) . chr(161) => 'g',
            chr(196) . chr(162) => 'G', chr(196) . chr(163) => 'g',
            chr(196) . chr(164) => 'H', chr(196) . chr(165) => 'h',
            chr(196) . chr(166) => 'H', chr(196) . chr(167) => 'h',
            chr(196) . chr(168) => 'I', chr(196) . chr(169) => 'i',
            chr(196) . chr(170) => 'I', chr(196) . chr(171) => 'i',
            chr(196) . chr(172) => 'I', chr(196) . chr(173) => 'i',
            chr(196) . chr(174) => 'I', chr(196) . chr(175) => 'i',
            chr(196) . chr(176) => 'I', chr(196) . chr(177) => 'i',
            chr(196) . chr(178) => 'IJ', chr(196) . chr(179) => 'ij',
            chr(196) . chr(180) => 'J', chr(196) . chr(181) => 'j',
            chr(196) . chr(182) => 'K', chr(196) . chr(183) => 'k',
            chr(196) . chr(184) => 'k', chr(196) . chr(185) => 'L',
            chr(196) . chr(186) => 'l', chr(196) . chr(187) => 'L',
            chr(196) . chr(188) => 'l', chr(196) . chr(189) => 'L',
            chr(196) . chr(190) => 'l', chr(196) . chr(191) => 'L',
            chr(197) . chr(128) => 'l', chr(197) . chr(129) => 'L',
            chr(197) . chr(130) => 'l', chr(197) . chr(131) => 'N',
            chr(197) . chr(132) => 'n', chr(197) . chr(133) => 'N',
            chr(197) . chr(134) => 'n', chr(197) . chr(135) => 'N',
            chr(197) . chr(136) => 'n', chr(197) . chr(137) => 'N',
            chr(197) . chr(138) => 'n', chr(197) . chr(139) => 'N',
            chr(197) . chr(140) => 'O', chr(197) . chr(141) => 'o',
            chr(197) . chr(142) => 'O', chr(197) . chr(143) => 'o',
            chr(197) . chr(144) => 'O', chr(197) . chr(145) => 'o',
            chr(197) . chr(146) => 'OE', chr(197) . chr(147) => 'oe',
            chr(197) . chr(148) => 'R', chr(197) . chr(149) => 'r',
            chr(197) . chr(150) => 'R', chr(197) . chr(151) => 'r',
            chr(197) . chr(152) => 'R', chr(197) . chr(153) => 'r',
            chr(197) . chr(154) => 'S', chr(197) . chr(155) => 's',
            chr(197) . chr(156) => 'S', chr(197) . chr(157) => 's',
            chr(197) . chr(158) => 'S', chr(197) . chr(159) => 's',
            chr(197) . chr(160) => 'S', chr(197) . chr(161) => 's',
            chr(197) . chr(162) => 'T', chr(197) . chr(163) => 't',
            chr(197) . chr(164) => 'T', chr(197) . chr(165) => 't',
            chr(197) . chr(166) => 'T', chr(197) . chr(167) => 't',
            chr(197) . chr(168) => 'U', chr(197) . chr(169) => 'u',
            chr(197) . chr(170) => 'U', chr(197) . chr(171) => 'u',
            chr(197) . chr(172) => 'U', chr(197) . chr(173) => 'u',
            chr(197) . chr(174) => 'U', chr(197) . chr(175) => 'u',
            chr(197) . chr(176) => 'U', chr(197) . chr(177) => 'u',
            chr(197) . chr(178) => 'U', chr(197) . chr(179) => 'u',
            chr(197) . chr(180) => 'W', chr(197) . chr(181) => 'w',
            chr(197) . chr(182) => 'Y', chr(197) . chr(183) => 'y',
            chr(197) . chr(184) => 'Y', chr(197) . chr(185) => 'Z',
            chr(197) . chr(186) => 'z', chr(197) . chr(187) => 'Z',
            chr(197) . chr(188) => 'z', chr(197) . chr(189) => 'Z',
            chr(197) . chr(190) => 'z', chr(197) . chr(191) => 's'
        );

        $string = strtr($string, $chars);

        return $string;
    }

    /**
     * Properly sorts an array
     *
     * @param $array
     * @param string $col
     */
    function sort(&$array, $col)
    {
        usort($array, function ($a, $b) use ($col) {
            $a[$col] = $this->removeAccents($a[$col]);
            $b[$col] = $this->removeAccents($b[$col]);

            return strcoll($a[$col], $b[$col]);
        });
    }

    /**
     * Search for a string in a specific array column
     *
     * @param array $array
     * @param string $q
     * @param string $col
     *
     * @return array
     */
    function search($array, $q, $col)
    {
        $array = array_filter($array, function ($v, $k) use ($q, $col) {
            return (strpos(strtoupper($v[$col]), strtoupper($q)) !== false);
        }, ARRAY_FILTER_USE_BOTH);
        $array = array_values($array);
        return $array;
    }

    /**
     * Parses the URL
     *
     * @param string $config
     * @param null $val
     *
     * @return string
     */
    function parseURL($config, $val = null)
    {
        $url = config($config);
        if ($val !== null) {
            $url = str_replace('{val}', "{$val}", $url);
        }

        return $url;
    }

    /**
     * Get data from external URL
     *
     * @param string $url
     * @param string $method
     * @param array $data
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function getData($url, $method = 'GET', $data = [])
    {
        $client = new Client();
        $response = $client->request($method, $url, $data);
        $json = json_decode($response->getBody(), true);
        return $json;
    }

    public function getUFS(Request $request)
    {
        $url = $this->parseURL('apis.ufs.url');
        $json = $this->getData($url);
        $this->sort($json, config('apis.ufs.column'));

        if (!empty($request->q)) {
            $json = $this->search($json, $request->q, config('apis.ufs.column'));
        }

        return response()->json(
            $json,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE
        );
    }

    public function getCities($uf, Request $request)
    {
        if (strlen($uf) > config('apis.cities.val.max')
            || strlen($uf) < config('apis.cities.val.min')) {
            return response()->json(
                [
                    'error' => true
                ],
                400,
                [
                    'Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'
                ],
                JSON_UNESCAPED_UNICODE
            );
        }

        $url = $this->parseURL('apis.ufs.url');
        $json = $this->getData($url);

        $ufId = 0;
        foreach ($json as $data) {
            if (strtoupper($data[config('apis.ufs.column')]) === strtoupper($uf)) {
                $ufId = $data['id'];
            }
        }

        if ($ufId === 0) {
            return response()->json(
                [
                    'error' => true
                ],
                400,
                [
                    'Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'
                ],
                JSON_UNESCAPED_UNICODE
            );
        }

        $url = $this->parseURL('apis.cities.url', $ufId);
        $json = $this->getData($url);
        $this->sort($json, config('apis.cities.column'));

        if (!empty($request->q)) {
            $json = $this->search($json, $request->q, config('apis.cities.column'));
        }

        return response()->json(
            $json,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE
        );
    }

    public function getAddress($cep)
    {
        if (!ctype_digit($cep)
            || strlen($cep) > config('apis.cep.val.max')
            || strlen($cep) < config('apis.cep.val.min')
            || $cep < config('apis.cep.val.minVal')) {
            return response()->json(
                [
                    'error' => true
                ],
                400,
                [
                    'Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'
                ],
                JSON_UNESCAPED_UNICODE
            );
        }

        $url = $this->parseURL('apis.cep.url', $cep);
        $json = $this->getData($url);

        if (array_key_exists(config('apis.cep.error.name'), $json)
            && $json[config('apis.cep.error.name')] == config('apis.cep.error.val')) {
            $data = ['error' => true];
        } else {
            $data = [
                'uf' => $json[config('apis.cep.uf')],
                'city' => $json[config('apis.cep.city')],
                'street' => $json[config('apis.cep.street')],
                'complement' => $json[config('apis.cep.complement')],
                'district' => $json[config('apis.cep.district')],
            ];
        }

        return response()->json(
            $data,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE
        );
    }

    public function getCompanyInfo($cnpj)
    {
        if (!ctype_digit($cnpj)
            || strlen($cnpj) > config('apis.cnpj.val.max')
            || strlen($cnpj) < config('apis.cnpj.val.min')) {
            return response()->json(
                [
                    'error' => true,
                ],
                400,
                [
                    'Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'
                ],
                JSON_UNESCAPED_UNICODE
            );
        }

        $url = $this->parseURL('apis.cnpj.url', $cnpj);
        $json = $this->getData($url);

        if (array_key_exists(config('apis.cnpj.error.name'), $json)
            && $json[config('apis.cnpj.error.name')] == config('apis.cnpj.error.val')) {
            $data = ['error' => true];
        } else {
            $data = [
                'name' => $json[config('apis.cnpj.name')],
                'fantasyName' => $json[config('apis.cnpj.fantasyName')],
                'email' => $json[config('apis.cnpj.email')],
                'phone' => $json[config('apis.cnpj.phone')],
                'cep' => $json[config('apis.cnpj.cep')],
                'uf' => $json[config('apis.cnpj.uf')],
                'city' => $json[config('apis.cnpj.city')],
                'street' => $json[config('apis.cnpj.street')],
                'number' => $json[config('apis.cnpj.number')],
                'complement' => $json[config('apis.cnpj.complement')],
                'district' => $json[config('apis.cnpj.district')],
            ];
        }

        return response()->json(
            $data,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE
        );
    }
}
