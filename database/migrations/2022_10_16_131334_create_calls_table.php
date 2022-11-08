<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->unsigned();
            $table->integer('agency_id')->unsigned();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->datetime('call_start_date')->nullable();
            $table->datetime('admission_date')->nullable();
            $table->string('call_type')->nullable();
            $table->string('call_tag')->nullable();
            $table->integer('duration')->nullable();
            $table->string('caller_name')->nullable();
            $table->string('caller_role')->nullable();
            $table->string('caller_center')->nullable();
            $table->string('caller_phone')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('calls');
    }
}
