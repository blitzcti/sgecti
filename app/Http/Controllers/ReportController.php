<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBimestral;
use App\Models\BimestralReport;
use App\Models\Course;
use App\Models\FinalReport;
use App\Models\NSac\Student;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use PDF;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:report-list');
        $this->middleware('permission:report-create', ['only' => ['createBimestral', 'createFinal', 'storeBimestral', 'storeFinal']]);
        $this->middleware('permission:report-edit', ['only' => ['editBimestral', 'editFinal', 'updateBimestral', 'updateFinal']]);
    }

    public function index()
    {
        $bReports = BimestralReport::all();
        $fReports = FinalReport::all();
        return view('coordinator.report.index')->with(['bReports' => $bReports, 'fReports' => $fReports]);
    }

    public function createBimestral()
    {
        $internships = State::findOrFail(1)->internships()->get();
        $i = request()->i;
        return view('coordinator.report.bimestral.new')->with(['internships' => $internships, 'i' => $i]);
    }

    public function createFinal()
    {
        $internships = State::findOrFail(1)->internships()->get();
        $i = request()->i;
        return view('coordinator.report.final.new')->with(['internships' => $internships, 'i' => $i]);
    }

    public function storeBimestral(StoreBimestral $request)
    {
        $bimestral = new BimestralReport();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Novo relatório bimestral";
        $log .= "\nUsuário: " . Auth::user()->name;

        $bimestral->created_at = Carbon::now();
        $bimestral->internship_id = $validatedData->internship;
        $bimestral->date = $validatedData->date;
        $bimestral->protocol = $validatedData->protocol;
        $saved = $bimestral->save();

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
