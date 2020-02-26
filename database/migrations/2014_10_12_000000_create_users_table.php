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
            $table->bigIncrements('id');
            $table->string('username')->unique();
            $table->string('name');
            $table->string('rank');
            $table->integer('website_id');
            $table->string('department_id')->nullable();
            $table->string('password');
            $table->boolean('temp_password')->default(true);
            $table->string('avatar')->default('antelope');
            $table->boolean('antelope_status')->default(true);
            $table->boolean('advanced_training')->default(false);
            $table->boolean('requirements_exempt')->default(false);
            $table->string('department_status')->nullable();
            $table->string('timezone')->default('UTC');
            $table->string('api_token', 80)
                ->unique()
                ->nullable()
                ->default(null);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
