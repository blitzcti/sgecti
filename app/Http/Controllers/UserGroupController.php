<?php

namespace App\Http\Controllers;

use App\User;
use App\UserGroup;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    public function index()
    {
        $userGroups = UserGroup::all();

        return view('admin.group.index')->with(['userGroups' => $userGroups]);
    }

    public function new()
    {

    }

    public function edit($id)
    {

    }

    public function save(Request $request)
    {

    }
}
