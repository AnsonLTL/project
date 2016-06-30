<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\company;
use App\Http\Requests;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('registerCompany');
    }
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|max:255|unique:companies',
            'email' => 'required|email|max:255',
        ]);
        $co = new Company;
        $co->name = $request->name;
        $co->email = $request->email;
        $co->save();
        return view('home');
    }
}
