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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('team_no',65)->nullable();
            $table->string('name',65);
            $table->string('slug',65);
            $table->tinyInteger('status')->default(1); //0 for inactive 1 for active
            $table->foreignId('user_id')
                  ->constrained('users') // there is only 1 team lead for 1 team
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('website_id')
                  ->constrained('websites')
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
        Schema::dropIfExists('teams');
    }
};
