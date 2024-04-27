<?php

namespace App\Http\Controllers;

// use App\Models\User;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    public function index()
    {
        // $users = User::all();
        return view('alternatif.weboender.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('alternatif.weboender.create');
    }
}


