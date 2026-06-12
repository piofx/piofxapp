<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('agency_id')->nullable();
            $table->bigInteger('client_id')->nullable();
            $table->bigInteger('mail_template_id')->nullable();
            $table->bigInteger('reference_id')->nullable();
            $table->string('email');
            $table->timestamp('scheduled_at')->nullable();
            $table->string('app')->nullable();
            $table->longText('subject')->nullable();
            $table->longText('message')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('mail_logs');
    }
}
