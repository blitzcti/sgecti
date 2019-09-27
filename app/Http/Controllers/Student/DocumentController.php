<?php

namespace App\Http\Controllers\Student;

use App\Auth;
use App\Models\NSac\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\TemplateProcessor;

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
            'Content-Disposition' => 'inline;',
        ]);
    }

    public function download($template, $fileName)
    {
        $temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
        $template->saveAs($temp_file);

        return response()->download($temp_file, "$fileName.docx")->deleteFileAfterSend(true);
    }

    //FILE GENERATION

    public function generateProtocol(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;
        $fileName = "";

        $id = $request->id;

        switch ($id) {
            case 0:
                $file = "internship_protocol";
                $fileName = "Protocolo de inicio";
                break;

            case 1:
                $file = "final_protocol";
                $fileName = "Protocolo de finalizacao";
                break;
        }

        $template = new TemplateProcessor(storage_path("app/public/docs/templates/$file.docx"));

        $template->setValue('course_upper', mb_strtoupper($student->course->name));
        $template->setValue('course', $student->course->name);
        $template->setValue('coordinator', $student->course->coordinator()->user->name);
        $template->setValue('name', $student->nome);
        $template->setValue('class', $student->turma);
        $template->setValue('period', ($student->turma_periodo == Student::MORNING) ? 'Diurno' : 'Noturno');
        $template->setValue('ra', $student->matricula);
        $template->setValue('email', $student->email);

        $this->download($template, $fileName);
    }

    //New Internship

    public function generatePlan()
    {
        $user = Auth::user();
        $student = $user->student;
        $fileName = "Plano de estagio (1 via)";

        $template = new TemplateProcessor(storage_path("app/public/docs/templates/new/plan.docx"));

        $template->setValue('ra', $student->matricula);
        $template->setValue('name', $student->nome);
        $template->setValue('birth', $student->data_de_nascimento->format("d/m/Y"));
        $template->setValue('course', $student->course->name);
        $template->setValue('class', $student->turma);
        $template->setValue('date', Carbon::now()->format("d/m/Y"));

        $this->download($template, $fileName);
    }

    public function generateTerm()
    {
        $user = Auth::user();
        $student = $user->student;
        $fileName = "Termo de Compromisso (3 vias)";

        $template = new TemplateProcessor(storage_path("app/public/docs/templates/new/engagement.docx"));

        $template->setValue('name', $student->nome);
        $template->setValue('ra', $student->matricula);
        $template->setValue('class', $student->turma);
        $template->setValue('course', $student->course->name);
        $template->setValue('date', Carbon::now()->formatLocalized("%d de %B de %Y"));
        $template->setValue('birth', $student->data_de_nascimento->format("d/m/Y"));
        $template->setValue('coordinator', $student->course->coordinator()->user->name);

        $this->download($template, $fileName);
    }

    public function generateAgreement()
    {
        $fileName = "Convenio de Estágio (2 vias)";

        $template = new TemplateProcessor(storage_path("app/public/docs/templates/new/agreement.docx"));

        $template->setValue('date', Carbon::now()->formatLocalized("%d de %B de %Y"));

        $this->download($template, $fileName);
    }

    //Finish Internship

    public function generateCertificate()
    {

    }

    public function generateEvaluation()
    {

    }

    public function generatePresentation()
    {

    }

    public function generateContent()
    {

    }

    public function generateQuestionnaire()
    {

    }

    //Other files

    public function generateReport()
    {

    }

    public function generateAditive()
    {

    }

    public function generateSituation()
    {

    }
}
