<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTotalsaledetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('totalsaledetail', function (Blueprint $table) {
            $table->unsignedInteger('tsp_id')->nullable();
                $table->foreign('tsp_id')
                    ->references('id')->on('totalsaleproducts')
                    ->onUpdate('cascade')
                    ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('totalsaledetail', function (Blueprint $table) {
            //
        });
    }
}
