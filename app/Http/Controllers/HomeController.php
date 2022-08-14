<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Operator;
use App\Fare;

class HomeController extends Controller
{

    public function index() {

        // Intancia e faz a busca no banco de todas as operadoras
        $operators = Operator::all();

        // Intancia e faz a busca no banco de todas as taxas
        $fares = Fare::all();

        return view('welcome', ['operators' => $operators, 'fares' => $fares]);
    }
}
