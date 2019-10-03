<?php

namespace App\Http\Controllers\API\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class DocumentController extends Controller
{
    public function getFormat()
    {
        $format = Session::get('format');
        if ($format == 'docx') {
            $format = 'odt';
        } else {
            $format = 'docx';
        }

        //Session::put('format', $format);

        return response()->json(
            ['format' => $format],
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }
}
