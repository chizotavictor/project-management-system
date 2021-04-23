<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskItemIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_item_issues', function (Blueprint $table) {
            $table->id();
            $table->longText('comment');
            $table->unsignedBigInteger('task_id')->nullable();
            $table->unsignedBigInteger('task_item_id')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->string('status')->default('Open'); # Close
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('task_item_id')->references('id')->on('task_items');
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
        Schema::dropIfExists('task_item_issues');
    }
}
