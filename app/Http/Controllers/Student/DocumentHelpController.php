<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

class DocumentHelpController extends Controller
{
    public function __construct()
    {
        $this->middleware('student');
        $this->middleware('permission:documents-list');
        $this->middleware('intern', ['only' => ['getCertificate', 'getEvaluation', 'getPresentation', 'getContent', 'getQuestionnaire']]);
        $this->middleware('non_intern', ['only' => ['getPlan', 'getTerm', 'getAgreement', 'generateSituation']]);
    }

    //New Internhip

    public function getPlan()
    {
        return response()->file(storage_path('app/public/docs/ajuda/plano_ajuda.pdf'), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline;',
        ]);
    }

    public function getTerm()
    {
        return response()->file(storage_path('app/public/docs/ajuda/termo_ajuda.pdf'), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline;',
        ]);
    }

    public function getAgreement()
    {
        return response()->file(storage_path('app/public/docs/ajuda/convenio_ajuda.pdf'), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline;',
        ]);
    }

    //Finish Internship

    public function getCertificate()
    {
        return response()->file(storage_path('app/public/docs/ajuda/certificado_ajuda.pdf'), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline;',
        ]);
    }

    public function getEvaluation()
    {
        return response()->file(storage_path('app/public/docs/ajuda/avaliacao_ajuda.pdf'), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline;',
        ]);
    }

    public function getPresentation()
    {
        return response()->file(storage_path('app/public/docs/ajuda/apresentacao_ajuda.pdf'), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline;',
        ]);
    }

    public function getContent()
    {
        return response()->file(storage_path('app/public/docs/ajuda/conteudo_ajuda.pdf'), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline;',
        ]);
    }

    public function getQuestionnaire()
    {
        return response()->file(storage_path('app/public/docs/ajuda/questionario_ajuda.pdf'), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline;',
        ]);
    }
}
