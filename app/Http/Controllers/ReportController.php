<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReport;
use App\Models\BimestralReport;
use App\Models\Course;
use App\Models\Internship;
use App\Models\NSac\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use \PDF;

class ReportController extends Controller
{
    public function index()
    {
        return view('coordinator.report.index');
    }

    public function bimestral()
    {
        $internships = Internship::where('state_id', '=', '1')->get();

        return view('coordinator.report.bimestral')->with(['internships' => $internships]);
    }

    public function final()
    {
        $internships = Internship::where('state_id', '=', '1')->get();

        return view('coordinator.report.final')->with(['internships' => $internships]);
    }

    public function storeBimestral(StoreReport $request)
    {
        $bimstreal = new BimestralReport();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Novo relatório bimestral";
        $log .= "\nUsuário: " . Auth::user()->name;

        $bimstreal->created_at = Carbon::now();
        $bimstreal->internship_id = $validatedData->internship_id;
        $bimstreal->date = $validatedData->date;
        $bimstreal->protocol = $validatedData->protocol;
        $saved = $bimstreal->save();

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar relatório bimestral");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.relatorio.index')->with($params);
    }

    public function storeFinal(Request $request)
    {

    }

    public function makePDF()
    {
        ini_set('max_execution_time', 300);

        $courses = Course::all()->sortBy('id');
        if ((new Student())->isConnected()) {
            $student = Student::where('matricula', 'LIKE', '17%')->get()->sortBy('matricula');
        } else {
            $student = [];
        }

        $data = [
            'courses' => $courses,
            'students' => $student,
        ];

        $pdf = PDF::loadView('pdf.index', $data);
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('index.pdf');
    }
}
