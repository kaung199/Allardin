<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('customer_status')->nullable();
            $table->string('phone');
            $table->text('address');
            $table->unsignedInteger('township_id');
            $table->integer('discount')->nullable();
            $table->string('delivery_date');
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('app_cards');
    }
}
