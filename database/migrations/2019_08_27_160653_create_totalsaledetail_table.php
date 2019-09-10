<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTotalsaledetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('totalsaledetail', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('order_id');
            $table->integer('totalqty');
            $table->Integer('totalprice');
            $table->string('date');
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
        Schema::dropIfExists('totalsaledetail');
    }
}
