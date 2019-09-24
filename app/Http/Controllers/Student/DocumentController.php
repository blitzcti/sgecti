<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('student');
        $this->middleware('permission:documents-list');
    }

    public function index()
    {
        return view('student.document.index');
    }

    public function getManual()
    {
        return response()->file(storage_path('app/public/docs/manual.pdf'), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline;Manual do Estagiário.pdf',
        ]);
    }
}
