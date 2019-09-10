<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTotalsaleproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('totalsaleproducts', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('product_id');
            $table->integer('totalqty');
            $table->string('date');
            $table->integer('totalprice');
            $table->integer('deliveryprice');
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
        Schema::dropIfExists('totalsaleproducts');
    }
}
