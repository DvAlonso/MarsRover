<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->uuid('key')->unique();
            $table->enum('status', ['pending_landing', 'landed', 'completed', 'aborted'])->default('pending_landing');
            $table->integer('rover_starting_x')->nullable();
            $table->integer('rover_starting_y')->nullable();
            $table->enum('rover_starting_orientation', ['n','w','e','s'])->default('n');
            $table->string('commands')->nullable();
            $table->json('commands_output')->nullable();
            $table->integer('rover_finishing_x')->nullable();
            $table->integer('rover_finishing_y')->nullable();
            $table->enum('rover_finishing_orientation', ['n','w','e','s'])->nullable();
            $table->enum('aborting_reason', ['out_of_bounds', 'obstacle'])->nullable();
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
        Schema::dropIfExists('missions');
    }
}
