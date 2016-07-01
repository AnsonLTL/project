<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrialBalanceSheet extends Model
{
    public $table = "TrialBalanceSheets";

    protected $fillable = [
        'company_id',
        'year',
        'coa',
        'amount'
    ];
}
