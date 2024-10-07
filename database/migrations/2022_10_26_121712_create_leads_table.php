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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('lead_no',65)->nullable();
            $table->text('description')->nullable();
            $table->string('subject',65)->nullable();
            $table->string('type',65)->nullable();
            $table->dateTime('start_date_time')->nullable();
            $table->dateTime('due_date_time')->nullable();
            $table->foreignId('timezone_id')
                  ->constrained('timezones')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->string('priority',20)->default('medium');
            $table->decimal('expected_amount',10,2)->nullable();
            $table->json('meta')->nullable();
            $table->tinyInteger('is_converted')->default(0);
            $table->foreignId('lead_stage_id')
                  ->constrained('lead_stages')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('lead_source_id')
                  ->constrained('lead_sources')
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
        Schema::dropIfExists('leads');
    }
};
