<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBimestral;
use App\Http\Requests\StoreFinal;
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
        $cId = auth()->user()->coordinators->last()->course_id;
        $bReports = BimestralReport::all()->where('course_id', '=', $cId);
        $fReports = FinalReport::all()->where('course_id', '=', $cId);

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

    public function storeFinal(StoreFinal $request)
    {
        $final = new FinalReport();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Novo relatório final";
        $log .= "\nUsuário: " . Auth::user()->name;

        $final->created_at = Carbon::now();
        $final->internship_id = $validatedData->internship;
        $final->date = $validatedData->date;

        $final->grade_1_a = $validatedData->grade_1_a;
        $final->grade_1_b = $validatedData->grade_1_b;
        $final->grade_1_c = $validatedData->grade_1_c;
        $final->grade_2_a = $validatedData->grade_2_a;
        $final->grade_2_b = $validatedData->grade_2_b;
        $final->grade_2_c = $validatedData->grade_2_c;
        $final->grade_2_d = $validatedData->grade_2_d;
        $final->grade_3_a = $validatedData->grade_3_a;
        $final->grade_3_b = $validatedData->grade_3_b;
        $final->grade_4_a = $validatedData->grade_4_a;
        $final->grade_4_b = $validatedData->grade_4_b;
        $final->grade_4_c = $validatedData->grade_4_c;

        $final->final_grade = 4.9; //formula
        $final->hours_completed = $validatedData->hoursCompleted;
        $final->end_date = $validatedData->endDate;
        $final->approval_number = $this->generateApprovalNumber($final->course_id);
        $final->coordinator_id = Auth::user()->coordinators->last()->id;
        $final->observation = $validatedData->observation;

        $saved = $final->save();

        if ($saved) {
            Log::info($log);
            $final->internship->state_id = 2;
            $final->internship->save();
        } else {
            Log::error("Erro ao salvar relatório final");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.relatorio.index')->with($params);
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

    private function generateApprovalNumber($course_id)
    {
        $no = 1;
        $year = Carbon::now()->year;

        $reports = FinalReport::whereYear('date', '=', $year)->get();

        foreach ($reports as $report) {
            if ($report->internship->student->course_id == $course_id) {
                $no++;
            }
        }

        while (strlen($no) < 3) {
            $no = "0$no";
        }
        return "$no/$year";
    }
}
