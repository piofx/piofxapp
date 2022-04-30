<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('agency_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('order_id');
            $table->string('txn_id')->nullable();
            $table->string('product');
            $table->string('payment_mode')->nullable();
            $table->string('bank_txn_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->integer('txn_amount');
            $table->dateTime('expiry')->nullable();
            $table->longText('redirect_url')->nullable();
            $table->longText('data')->nullable();
            $table->integer('status'); 
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
