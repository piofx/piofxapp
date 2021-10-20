<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('agency_id')->nullable();
            $table->bigInteger('client_id')->nullable();
            $table->text('title');
            $table->text('slug');
            $table->longText('top_head')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('tag_id')->nullable();
            $table->longText('image')->nullable();
            $table->longText('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured')->nullable();
            $table->string('visibility')->nullable();
            $table->text('group')->nullable();
            $table->bigInteger("views")->default(0);
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamp('published_at')->nullable();
            $table->text('top_head');
            $table->text('link');
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
        Schema::dropIfExists('posts');
    }
}
