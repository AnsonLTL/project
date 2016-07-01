<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrialBalanceSheet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TrialBalanceSheets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('year');
            $table->string('coa');
            $table->integer('amount');
            $table->timestamps();
            $table->timestamp('created_by');
            $table->timestamp('updated_by');
        });

        $tBSheets = [
            ['company_id' => '1', 'year' => '1993', 'coa' => '01', 'amount' => '10'],
            ['company_id' => '1', 'year' => '1993', 'coa' => '0102', 'amount' => '20'],
            ['company_id' => '1', 'year' => '1993', 'coa' => '0103', 'amount' => '30'],
            ['company_id' => '1', 'year' => '1993', 'coa' => '05', 'amount' => '40'],
            ['company_id' => '1', 'year' => '1993', 'coa' => '90', 'amount' => '50']
        ];
        foreach($tBSheets as $tBSheet){
            App\TrialBalanceSheet::create($tBSheet);
        }

        //DB::statement("UPDATE TrialBalanceSheets SET coa=LPAD(coa, 2, '0'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('TrialBalanceSheets');
    }
}
