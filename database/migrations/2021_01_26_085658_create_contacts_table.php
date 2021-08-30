<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone',20)->nullable();
            $table->string('email')->nullable();
            $table->string('category')->nullable();
            $table->string('tags')->nullable();
            $table->integer('valid_email')->default(0);
            $table->longText('json')->nullable();
            $table->longText('message')->nullable();
            $table->longText('comment')->nullable();
            $table->integer('client_id')->default(1);
            $table->integer('agency_id')->default(1);
            $table->integer('user_id')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('contacts');
    }
}
