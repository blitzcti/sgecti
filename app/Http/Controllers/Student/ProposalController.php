<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Proposal;

class ProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware('student');
        $this->middleware('permission:proposal-list');
    }

    public function index()
    {
        $proposals = Proposal::approved();

        return view('student.proposal.index')->with(['proposals' => $proposals]);
    }

    public function show($id)
    {
        $proposal = Proposal::findOrFail($id);

        return view('student.proposal.details')->with(['proposal' => $proposal]);
    }
}
