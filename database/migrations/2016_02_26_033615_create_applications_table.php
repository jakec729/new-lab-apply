<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('company');
            $table->string('website');
            $table->string('desks');
            $table->string('disciplines');
            $table->string('membership_type');
            $table->text('text_pitch');
            $table->text('text_tech');
            $table->text('text_team');
            $table->text('text_strategy');
            $table->string('funding_stage');
            $table->string('new_lab_resources');
            $table->text('text_community');
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
        Schema::drop('applications');
    }
}
