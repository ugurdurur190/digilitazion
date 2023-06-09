<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_situation_activites', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id');
            $table->integer('user_id');
            $table->integer('state_id');
            $table->string('comment');
            $table->timestamps();
            
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_situation_activites');
    }
};