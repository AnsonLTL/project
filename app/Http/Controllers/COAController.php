<?php

namespace App\Http\Controllers;

use App\Coa;
use App\TrialBalanceSheet;
use Illuminate\Http\Request;
use App\Http\Requests;

class COAController extends Controller
{
    public function index()
    {
        $info_s = Coa::all();
        return view('tBalForm', compact('info_s'));
    }
    public function testTableT()
    {
        $info_s = TrialBalanceSheet::all();
        return $info_s;
    }
    public function testTableTPost(Request $request)
    {
        $tbs = new TrialBalanceSheet;
        $tbs->year = $request->year;
        $tbs->coa = $request->coa;
        $tbs->amount = $request->amount;
        $tbs->save();
        return $tbs;
    }
    public function testTableTPut(Request $request)
    {
        $tbs = TrialBalanceSheet::find($request->id);
        $tbs->update(['coa' => $request->coa]);
        return $tbs;
    }
    public function testTableTDel(Request $request)
    {
        $tbs = TrialBalanceSheet::where('id', $request->id);
        $tbs->delete();
        $info_s = TrialBalanceSheet::all();
        return $info_s;
    }


    public function index2()
    {
        $info_s = Coa::all();
        return view('tBalFormBackUp', compact('info_s'));
    }
    public function testIndex()
    {
        $info_s = Coa::all();
        return view('tBalFormTest', compact('info_s'));
    }
    public function testMagic()
    {
        $info_s = Coa::all();
        return view('testMagic', compact('info_s'));
    }
    public function testMagic2()
    {
        $info_s = Coa::all();
        return view('testMagicFunc', compact('info_s'));
    }
    public function testTable()
    {
        $info_s = Coa::select('id','code', 'parent', 'description', 'crdr')->get();
        return view('testTable', compact('info_s'));
    }
    public function testTable2()
    {
        $info_s = Coa::select('id','code', 'parent', 'description', 'crdr')->get();
        return view('testTable2', compact('info_s'));
    }
}
