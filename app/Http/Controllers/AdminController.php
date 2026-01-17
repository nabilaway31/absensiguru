<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::all();
        return view('admin.index', compact('admins'));
    }
}
