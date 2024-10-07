<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_no',65)->nullable();
            $table->string('name',65);
            $table->longText('description')->nullable();
            $table->dateTime('start_date_time')->nullable();
            $table->dateTime('due_date_time')->nullable();
            $table->integer('is_completed')->default(0);
            $table->bigInteger('parent_id')->default(0);
            $table->foreignId('timezone_id')
                  ->constrained('timezones')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('task_stage_id')
                  ->constrained('task_stages')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('website_id')
                  ->constrained('websites')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('client_id')
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('tasks');
    }
};
