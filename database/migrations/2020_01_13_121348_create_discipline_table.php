<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisciplineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discipline', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('issued_by')->unsigned()->index();
            $table->foreign('issued_by')->references('id')->on('users')->onDelete('cascade');
            $table->date('discipline_date');
            $table->integer('type');
            $table->longText('details');
            $table->boolean('overturned')->default(false);
            $table->unsignedBigInteger('overturned_by')->unsigned()->index()->nullable();
            $table->foreign('overturned_by')->references('id')->on('users')->onDelete('cascade');
            $table->date('overturned_date')->nullable();
            $table->longText('overturned_reason')->nullable();
            $table->boolean('disputed')->default(false);
            $table->date('disputed_date')->nullable();
            $table->longText('disputed_reason')->nullable();
            $table->date('custom_expiry_date')->nullable();
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
        Schema::dropIfExists('discipline');
    }
}
