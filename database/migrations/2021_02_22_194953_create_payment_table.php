<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order-id');
            $table->string('orderAmount');
            $table->string('referenceId');
            $table->string('txStatus');
            $table->string('paymentMode');
            $table->string('txMsg');
            $table->string('txTime');
            $table->string('signature');
            $table->enum('status',['pending', 'success','fail']);
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
        Schema::dropIfExists('payment');
    }
}
