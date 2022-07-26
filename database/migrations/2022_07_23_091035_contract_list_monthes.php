<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContractListMonthes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_list_months', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_list_id');
            $table->integer('month');
            $table->float('pay_decode', 16, 2)->nullable();
            $table->float('pay_act', 16, 2)->nullable();
            $table->string('upload_decode_file')->nullable();
            $table->string('download_akt_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contract_list_months');
    }
}
