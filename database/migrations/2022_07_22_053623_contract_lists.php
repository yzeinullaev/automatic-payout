<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContractLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('branch_id');
            $table->string('contract_number');
            $table->date('start_contract_date');
            $table->date('end_contract_date');
            $table->integer('partner_id');
            $table->string('partner_bin');
            $table->integer('agent_id');
            $table->integer('pay_status_id');
            $table->integer('pay_type_id');
            $table->float('agent_fee');
            $table->boolean('enabled')->default(false);
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
        Schema::drop('contract_lists');
    }
}
