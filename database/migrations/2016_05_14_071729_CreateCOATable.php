<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCOATable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('code');
            $table->integer('parent');
            $table->string('label');
            $table->string('description');
            $table->string('crdr');
            $table->timestamps();
            $table->timestamp('created_by');
            $table->timestamp('updated_by');
        });

        //dummy data, remember it requires MassAssignment in EloquentModel
        $coas = [
            ['company_id' => '1', 'code' => '01', 'parent' => '00', 'label' => '', 'description' => 'Asset', 'crdr' => 'Credit'],
            ['company_id' => '1', 'code' => '02', 'parent' => '01', 'label' => '', 'description' => 'ABuilding', 'crdr' => 'Credit'],
            ['company_id' => '1', 'code' => '30', 'parent' => '00', 'label' => '', 'description' => 'ABuilding2', 'crdr' => 'Credit'],
            ['company_id' => '1', 'code' => '50', 'parent' => '30', 'label' => '', 'description' => 'Duno', 'crdr' => 'Debit'],
            ['company_id' => '1', 'code' => '90', 'parent' => '50', 'label' => '', 'description' => 'Sigh', 'crdr' => 'Debit']
        ];
        foreach($coas as $coa){
            App\Coa::create($coa);
        }
        //end of dummy data
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coas');
    }
}
