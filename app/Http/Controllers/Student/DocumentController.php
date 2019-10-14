<?php

namespace App\Http\Controllers\Student;

use App\Auth;
use App\Http\Controllers\Controller;
use App\Models\NSac\Student;
use App\Models\SystemConfiguration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('student');
        $this->middleware('permission:documents-list');
        $this->middleware('intern', ['only' => ['generateCertificate', 'generateEvaluation', 'generatePresentation', 'generateContent', 'generateQuestionnaire', 'generateReport', 'generateAditive']]);
        $this->middleware('non_intern', ['only' => ['generatePlan', 'generateTerm', 'generateAgreement']]);
        $this->middleware('never_intern', ['only' => ['generateSituation']]);
    }

    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        return view('student.document.index')->with(['student' => $student]);
    }

    public function getManual()
    {
        return response()->file(storage_path('app/public/docs/manual.pdf'), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline;',
        ]);
    }

    private function download(TemplateProcessor $template, $fileName)
    {
        $temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
        $template->saveAs($temp_file);

        $format = Session::get('format') ?? 'docx';
        if ($format == 'odt') {
            $phpWord = IOFactory::load($temp_file);
            $objWriter = IOFactory::createWriter($phpWord, 'ODText');
            $objWriter->save($temp_file);
        }

        return response()->download($temp_file, "{$fileName}.{$format}")->deleteFileAfterSend(true);
    }

    // FILE GENERATION

    public function generateProtocol(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;
        $sysConfig = SystemConfiguration::getCurrent();

        $fileName = "";

        if ($student->internship == null) {
            $folder = "new";
            $fileName = "Protocolo de inicio (1 via)";
        } else {
            $folder = "end";
            $fileName = "Protocolo de finalizacao (1 via)";
        }

        $template = new TemplateProcessor(storage_path("app/public/docs/templates/$folder/protocol.docx"));

        $template->setValue('course_upper', mb_strtoupper($student->course->name));
        $template->setValue('course', $student->course->name);
        $template->setValue('coordinator', $student->course->coordinator->user->name);
        $template->setValue('student', $student->nome);
        $template->setValue('class', $student->turma);
        $template->setValue('period', ($student->turma_periodo == Student::MORNING) ? 'Diurno' : 'Noturno');
        $template->setValue('ra', $student->matricula);
        $template->setValue('email', $student->email);

        $template->setValue('city', $sysConfig->city);

        return $this->download($template, $fileName);
    }

    // New Internship

    public function generatePlan()
    {
        $user = Auth::user();
        $student = $user->student;
        $sysConfig = SystemConfiguration::getCurrent();

        $fileName = "Plano de estagio (1 via)";

        $template = new TemplateProcessor(storage_path("app/public/docs/templates/new/plan.docx"));

        $template->setValue('ra', $student->matricula);
        $template->setValue('student', $student->nome);
        $template->setValue('birth', $student->data_de_nascimento->format("d/m/Y"));
        $template->setValue('course', $student->course->name);
        $template->setValue('class', $student->turma);
        $template->setValue('year', $student->turma_ano);

        $template->setValue('city', $sysConfig->city);

        return $this->download($template, $fileName);
    }

    public function generateTerm()
    {
        $user = Auth::user();
        $student = $user->student;
        $sysConfig = SystemConfiguration::getCurrent();

        $fileName = "Termo de Compromisso (3 vias)";

        $template = new TemplateProcessor(storage_path("app/public/docs/templates/new/engagement.docx"));

        $template->setValue('student', $student->nome);
        $template->setValue('ra', $student->matricula);
        $template->setValue('grade', $student->grade);
        $template->setValue('course', $student->course->name);
        $template->setValue('birth', $student->data_de_nascimento->format("d/m/Y"));
        $template->setValue('coordinator', $student->course->coordinator->user->name);

        $template->setValue('college', $sysConfig->name);
        $template->setValue('city', $sysConfig->city);

        return $this->download($template, $fileName);
    }

    public function generateAgreement()
    {
        $sysConfig = SystemConfiguration::getCurrent();

        $fileName = "convenio de Estágio (2 vias)";

        $template = new TemplateProcessor(storage_path("app/public/docs/templates/new/agreement.docx"));

        $template->setValue('city', $sysConfig->city);

        return $this->download($template, $fileName);
    }

    // Finish Internship

    public function generateCertificate()
    {
        $user = Auth::user();
        $student = $user->student;
        $sysConfig = SystemConfiguration::getCurrent();
        $internship = $student->internship;

        $fileName = "Certificado de estágio (1 via)";

        $template = new TemplateProcessor(storage_path("app/public/docs/templates/end/certificate.docx"));

        $template->setValue('ra', $student->matricula);
        $template->setValue('student', $student->nome);
        $template->setValue('course', $student->course->name);

        $template->setValue('start_date', $internship->start_date->format("d/m/Y"));
        $template->setValue('end_date', $internship->end_date->format("d/m/Y"));
        $template->setValue('completed_hours', $internship->estimated_hours);
        $template->setValue('activities', $internship->activities);
        $template->setValue('supervisor', $internship->supervisor->name);

        $template->setValue('city', $sysConfig->city);
        $template->setValue('college', $sysConfig->name);

        return $this->download($template, $fileName);
    }

    public function generateEvaluation()
    {
        $user = Auth::user();
        $student = $user->student;
        $sysConfig = SystemConfiguration::getCurrent();
        $internship = $student->internship;

        $fileName = "Avalição do estagiário (1 via)";

        $template = new TemplateProcessor(storage_path("app/public/docs/templates/end/evaluation.docx"));

        $template->setValue('ra', $student->matricula);
        $template->setValue('student', $student->nome);
        $template->setValue('coordinator', $student->course->coordinator->user->name);
        $template->setValue('course', $student->course->name);

        $template->setValue('representative', $internship->company->representative_name);
        $template->setValue('start_date', $internship->start_date->format("d/m/Y"));
        $template->setValue('end_date', $internship->end_date->format("d/m/Y"));

        $template->setValue('city', $sysConfig->city);

        return $this->download($template, $fileName);
    }

    public function generatePresentation()
    {
        $user = Auth::user();
        $student = $user->student;
        $sysConfig = SystemConfiguration::getCurrent();
        $internship = $student->internship;

        $fileName = "1 - Apresentação (1 via)";

        $template = new TemplateProcessor(storage_path("app/public/docs/templates/end/presentation.docx"));

        $template->setValue('ra', $student->matricula);
        $template->setValue('student', $student->nome);
        $template->setValue('course', $student->course->name);
        $template->setValue('grade', $student->grade);
        $template->setValue('coordinator', $student->course->coordinator->user->name);

        $template->setValue('company', $internship->company->name);
        $template->setValue('sector', $internship->sector->name);
        $template->setValue('address', $internship->company->address->formatted_address);
        $template->setValue('company_city', $internship->company->address->city);
        $template->setValue('uf', $internship->company->address->uf);
        $template->setValue('phone', $internship->company->formatted_phone);
        $template->setValue('supervisor', $internship->supervisor->name);
        $template->setValue('representative', $internship->company->representative_name);
        $template->setValue('start_date', $internship->start_date->format("d/m/Y"));
        $template->setValue('end_date', $internship->end_date->format("d/m/Y"));

        $template->setValue('city', $sysConfig->city);

        return $this->download($template, $fileName);
    }

    public function generateContent()
    {
        $fileName = "2 - Conteúdo (1 via)";

        $template = new TemplateProcessor(storage_path("app/public/docs/templates/end/content.docx"));

        return $this->download($template, $fileName);
    }

    public function generateQuestionnaire()
    {
        $user = Auth::user();
        $student = $user->student;
        $sysConfig = SystemConfiguration::getCurrent();

        $fileName = "3 - Questionário (1 via)";

        $template = new TemplateProcessor(storage_path("app/public/docs/templates/end/questionnaire.docx"));

        $template->setValue('student', $student->nome);

        $template->setValue('city', $sysConfig->city);

        return $this->download($template, $fileName);
    }

    //Other files

    public function generateReport()
    {
        $user = Auth::user();
        $student = $user->student;
        $sysConfig = SystemConfiguration::getCurrent();
        $internship = $student->internship;

        $fileName = "Relatório bimestral (1 via)";

        $template = new TemplateProcessor(storage_path("app/public/docs/templates/etc/bimestral.docx"));

        $template->setValue('student', $student->nome);
        $template->setValue('course', $student->course->name);
        $template->setValue('class', $student->turma);
        $template->setValue('coordinator', $student->course->coordinator->user->name);

        $template->setValue('company', $internship->company->name);
        $template->setValue('address', $internship->company->address->formatted_address);
        $template->setValue('company_city', $internship->company->address->city);
        $template->setValue('uf', $internship->company->address->uf);
        $template->setValue('phone', $internship->company->formatted_phone);
        $template->setValue('supervisor', $internship->supervisor->name);

        $template->setValue('city', $sysConfig->city);

        return $this->download($template, $fileName);
    }

    public function generateAditive(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;
        $sysConfig = SystemConfiguration::getCurrent();
        $internship = $student->internship;

        $fileName = "";

        $id = $request->id;

        switch ($id) {
            case 0:
                $file = "aditive_date";
                $fileName = "Aditivo para data (1 via)";
                break;

            case 1:
                $file = "aditive_other";
                $fileName = "Aditivo para outros fins (1 via)";
                break;
        }

        $template = new TemplateProcessor(storage_path("app/public/docs/templates/etc/$file.docx"));

        $template->setValue('ra', $student->matricula);
        $template->setValue('student', $student->nome);
        $template->setValue('grade', $student->grade);
        $template->setValue('course', $student->course->name);
        $template->setValue('coordinator', $student->course->coordinator->user->name);

        $template->setValue('company', $internship->company->name);
        $template->setValue('address', $internship->company->address->formatted_address);
        $template->setValue('company_city', $internship->company->address->city);
        $template->setValue('uf', $internship->company->address->uf);
        $template->setValue('phone', $internship->company->formatted_phone);
        $template->setValue('representative', $internship->company->representative_name);

        $template->setValue('college', $sysConfig->name);
        $template->setValue('city', $sysConfig->city);

        return $this->download($template, $fileName);
    }

    public function generateSituation()
    {
        $user = Auth::user();
        $student = $user->student;
        $sysConfig = SystemConfiguration::getCurrent();

        $fileName = "Declaração de situação funcional (1 via)";

        $template = new TemplateProcessor(storage_path("app/public/docs/templates/etc/job.docx"));

        $template->setValue('student', $student->nome);

        $template->setValue('city', $sysConfig->city);

        return $this->download($template, $fileName);
    }
}
