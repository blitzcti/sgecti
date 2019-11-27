<?php

namespace App\Http\Controllers\API;

use App\APIUtils;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExternalAPISController extends Controller
{
    public function getUFS(Request $request)
    {
        $url = APIUtils::parseURL('apis.ufs.url');
        $column = config('apis.ufs.column');
        $json = APIUtils::getData($url);
        $json = array_column($json, $column);
        APIUtils::sort($json);

        if (!empty($request->q)) {
            $json = APIUtils::search($json, $request->q);
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

        $url = APIUtils::parseURL('apis.ufs.url');
        $column = config('apis.ufs.column');
        $json = APIUtils::getData($url);
        $json = array_column($json, 'id', $column);

        $ufId = 0;
        foreach ($json as $data => $id) {
            if (strtoupper($data) === strtoupper($uf)) {
                $ufId = $id;
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

        $url = APIUtils::parseURL('apis.cities.url', $ufId);
        $column = config('apis.cities.column');
        $json = APIUtils::getData($url);
        $json = array_column($json, $column);
        APIUtils::sort($json);

        if (!empty($request->q)) {
            $json = APIUtils::search($json, $request->q);
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

        $url = APIUtils::parseURL('apis.cep.url', $cep);
        $json = APIUtils::getData($url);

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

        $url = APIUtils::parseURL('apis.cnpj.url', $cnpj);
        $json = APIUtils::getData($url);

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
