<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('order_id');
            $table->string('delivery_id')->nullable();
            $table->unsignedInteger('totalquantity');
            $table->Integer('totalprice');
            $table->string('deliverystatus');
            $table->unsignedInteger('discount')->nullable(); 
            $table->date('orderdate');
            $table->date('deliverydate')->nullable();
            $table->string('remark')->nullable();
            $table->string('monthly');
            $table->year('yearly');
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
        Schema::dropIfExists('orders');
    }
}
