<?php

namespace App\Http\Requests\API;


use Illuminate\Http\JsonResponse;

class FormRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function response(array $errors)
    {
        return new JsonResponse($errors, 422);
    }
}
