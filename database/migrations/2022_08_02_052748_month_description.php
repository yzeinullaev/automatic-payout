<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MonthDescription extends Migration
{

    protected $months;

    public function __construct()
    {
        $months_desc = collect([
            1 => 'Январь',
            2 => 'Февраль',
            3 => 'Март',
            4 => 'Апрель',
            5 => 'Май',
            6 => 'Июнь',
            7 => 'Июль',
            8 => 'Август',
            9 => 'Сентябрь',
            10 => 'Октябрь',
            11 => 'Ноябрь',
            12 => 'Декабрь',
        ]);

        $this->months = $months_desc->map(function ($month, $key) {
            return [
                'id' => $key,
                'month' => $month
            ];
        })->toArray();
    }

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        $tableName = 'month_description';

        Schema::create($tableName, function (Blueprint $table) {
            $table->integer('id');
            $table->string('month');
        });

        if (Schema::hasTable($tableName)) {
            DB::table($tableName)->insertOrIgnore($this->months);
        }
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('month_description');
    }
}
