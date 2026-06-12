<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->longText('html')->nullable();
            $table->longText('html_minified')->nullable();
            $table->longText('settings')->nullable();
            $table->integer('admin')->default(1);
            $table->integer('client_id')->default(1);
            $table->integer('theme_id')->default(1);
            $table->integer('agency_id')->default(1);
            $table->integer('user_id')->default(1);
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
        Schema::dropIfExists('pages');
    }
}
