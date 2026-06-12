<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TemplateTemplateTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_template_tag', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('template_id');
            $table->unsignedBigInteger('template_tag_id');
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
        Schema::dropIfExists('template_template_tag');
    }
}
