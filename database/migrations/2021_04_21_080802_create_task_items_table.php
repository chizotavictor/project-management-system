<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_items', function (Blueprint $table) {
            $table->id();
            $table->text('task_indicator');
            $table->longText('description');
            $table->unsignedBigInteger('designator_id')->nullable();
            $table->unsignedBigInteger('task_id')->nullable();
            $table->string('status')->default('Pending'); // In-Progress, Cancelled, Paused, Completed
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamps();
            $table->foreign('designator_id')->references('id')->on('users');
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('approved_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_items');
    }
}
