<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     * $formattedDate = Carbon::parse($request->date)->format('Y-m-s');
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->longText('description');
            $table->string('start_date');
            $table->string('delivery_date');
            $table->unsignedBigInteger('initiator_id')->nullable();
            $table->unsignedBigInteger('designator_id')->nullable();
            $table->string('status')->default('Pending'); // In-Progress, Cancelled, Paused, Completed
            $table->timestamps();

            $table->foreign('initiator_id')->references('id')->on('users');
            $table->foreign('designator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
