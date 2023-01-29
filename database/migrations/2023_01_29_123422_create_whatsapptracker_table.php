<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsapptrackerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapptracker', function (Blueprint $table) {
            $table->id();
            $table->string("phone");
            $table->string("name")->nullable();
            $table->string("email")->nullable();
            $table->string("code")->nullable();
            $table->string("college")->nullable();
            $table->string("branch")->nullable();
            $table->string("yop")->nullable();
            $table->string("zone")->nullable();
            $table->integer("account")->nullable();
            $table->integer("instagram")->nullable();
            $table->integer("youtube")->nullable();
            $table->longText("comment")->nullable();
            $table->longText("data")->nullable();
            $table->integer("user_id");
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
        Schema::dropIfExists('whatsapptracker');
    }
}
