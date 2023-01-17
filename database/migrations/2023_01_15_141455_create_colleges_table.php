<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colleges', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("code")->nullable();
            $table->string("type")->nullable();
            $table->string("location")->nullable();
            $table->string("zone")->nullable();
            $table->string("district")->nullable();
            $table->string("state")->nullable();
            $table->string("contact_person")->nullable();
            $table->string("contact_designation")->nullable();
            $table->string("contact_phone")->nullable();
            $table->string("contact_email")->nullable();
            $table->string("data_volume")->nullable();
            $table->integer("client_id");
            $table->integer("agency_id");
            $table->integer("status");
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
        Schema::dropIfExists('colleges');
    }
}
