<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index(){
        return view('tournaments.list');
    }

    public function create(){
        return view('tournaments.create');
    }
}
