<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use Illuminate\Http\Request;

class CoordinatorController extends Controller
{
    public function index()
    {

    }

    public function new()
    {
       $courses = Course::all();
       $users = User::all()->where('id_group', '=', 2);

        return view('admin.coordinator.new')->with(["courses"=> $courses,"users"=> $users]);
    }

    public function edit($id)
    {

    }

    public function save(Request $request)
    {

    }
}
