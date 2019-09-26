<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocumentHelpController extends Controller
{
    public function __construct()
    {
        $this->middleware('student');
        $this->middleware('permission:documents-list');
    }

    public function getPlan()
    {
        return response()->file(storage_path('app/public/docs/ajuda/plano_ajuda.pdf'), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline;Manual do Estagiário.pdf',
        ]);
    }

    public function getTerm()
    {
        return response()->file(storage_path('app/public/docs/ajuda/termo_ajuda.pdf'), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline;Manual do Estagiário.pdf',
        ]);
    }

    public function getAgreement()
    {
        return response()->file(storage_path('app/public/docs/ajuda/convenio_ajuda.pdf'), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline;Manual do Estagiário.pdf',
        ]);
    }
}
