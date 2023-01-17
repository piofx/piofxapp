                         <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('user');
            $table->unsignedBigInteger('client_id')->default(1);
            $table->unsignedBigInteger('agency_id')->default(1);
            $table->text('group')->nullable();
            $table->text('subgroup')->nullable();
            $table->longText('data')->nullable();
            $table->longText('json')->nullable();
            $table->integer('status')->default(1);
            $table->string('c1')->nullable();
            $table->string('c2')->nullable();
            $table->string('c3')->nullable();
            $table->string('c4')->nullable();
            $table->string('c5')->nullable();
            $table->string('c6')->nullable();
            $table->string('c7')->nullable();
            $table->string('c8')->nullable();
            $table->string('c9')->nullable();
            $table->string('c10')->nullable();
            $table->integer('subscribe_phone')->nullable();
            $table->integer('subscribe_email')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
