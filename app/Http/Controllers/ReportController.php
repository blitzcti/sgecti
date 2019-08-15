<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBimestral;
use App\Http\Requests\StoreFinal;
use App\Http\Requests\UpdateBimestral;
use App\Http\Requests\UpdateFinal;
use App\Models\BimestralReport;
use App\Models\FinalReport;
use App\Models\Internship;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $bReports = BimestralReport::all()->filter(function ($report) use ($cIds) {
            return in_array($report->internship->student->course_id, $cIds);
        });

        $fReports = FinalReport::all()->filter(function ($report) use ($cIds) {
            return in_array($report->internship->student->course_id, $cIds);
        });

        return view('coordinator.report.index')->with(['bReports' => $bReports, 'fReports' => $fReports]);
    }

    public function createBimestral()
    {
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $internships = State::findOrFail(1)->internships->filter(function ($internship) use ($cIds) {
            return in_array($internship->student->course_id, $cIds);
        });

        $i = request()->i;
        return view('coordinator.report.bimestral.new')->with(['internships' => $internships, 'i' => $i]);
    }

    public function createFinal()
    {
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $internships = State::findOrFail(1)->internships->filter(function ($internship) use ($cIds) {
            return in_array($internship->student->course_id, $cIds);
        });

        $i = request()->i;
        return view('coordinator.report.final.new')->with(['internships' => $internships, 'i' => $i]);
    }

    public function editBimestral($id)
    {
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $internships = Internship::all()->filter(function ($internship) use ($cIds) {
            return in_array($internship->student->course_id, $cIds);
        });

        $report = BimestralReport::findOrFail($id);
        return view('coordinator.report.bimestral.edit')->with(['report' => $report, 'internships' => $internships]);
    }

    public function editFinal($id)
    {
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $internships = Internship::all()->filter(function ($internship) use ($cIds) {
            return in_array($internship->student->course_id, $cIds);
        });

        $report = FinalReport::findOrFail($id);
        return view('coordinator.report.final.edit')->with(['report' => $report, 'internships' => $internships]);
    }

    public function storeBimestral(StoreBimestral $request)
    {
        $bimestral = new BimestralReport();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Novo relatório bimestral";
        $log .= "\nUsuário: " . Auth::user()->name;

        $bimestral->internship_id = $validatedData->internship;
        $bimestral->date = $validatedData->date;
        $bimestral->protocol = $validatedData->protocol;
        $saved = $bimestral->save();
        $log .= "\nNovos dados: " . json_encode($bimestral, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

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

        $final->internship_id = $validatedData->internship;
        $final->date = $validatedData->date;

        $course_id = $final->internship->student->course_id;

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
        $final->approval_number = $this->generateApprovalNumber($course_id);
        $final->observation = $validatedData->observation;

        $coordinator_id = Auth::user()->coordinators->where('course_id', '=', $course_id)->last()->id;
        $final->coordinator_id = $coordinator_id;

        $saved = $final->save();
        $log .= "\nNovos dados: " . json_encode($final, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

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

    public function updateBimestral($id, UpdateBimestral $request)
    {
        $bimestral = BimestralReport::all()->find($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Alteração de relatório bimestral";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nDados antigos: " . json_encode($bimestral, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $bimestral->internship_id = $validatedData->internship;
        $bimestral->date = $validatedData->date;
        $bimestral->protocol = $validatedData->protocol;
        $saved = $bimestral->save();
        $log .= "\nNovos dados: " . json_encode($bimestral, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar relatório bimestral");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.relatorio.index')->with($params);
    }

    public function updateFinal($id, UpdateFinal $request)
    {
        $final = FinalReport::all()->find($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Alteração de relatório final";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nDados antigos: " . json_encode($final, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $final->internship_id = $validatedData->internship;
        $final->date = $validatedData->date;

        $course_id = $final->internship->student->course_id;

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
        $final->observation = $validatedData->observation;

        $coordinator_id = Auth::user()->coordinators->where('course_id', '=', $course_id)->last()->id;
        $final->coordinator_id = $coordinator_id;

        $saved = $final->save();
        $log .= "\nNovos dados: " . json_encode($final, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

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

    public function pdfFinal($id)
    {
        ini_set('max_execution_time', 300);

        $report = FinalReport::findOrFail($id);
        $student = $report->internship->student ?? null;

        $data = [
            'report' => $report,
            'student' => $student,
        ];

        $pdf = PDF::loadView('pdf.report.final', $data);
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('relatorioFinal.pdf');
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
