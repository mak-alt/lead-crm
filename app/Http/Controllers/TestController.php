<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class TestController extends Controller
{
    public function show()
    {
        $users = User::all();
        return Inertia::render('User/Index',['users' => $users]);
    }
}
