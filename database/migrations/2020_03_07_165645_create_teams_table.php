<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('owner_id');
            $table->string('title');
            $table->text('image_url')->nullable();
            $table->tinyInteger('uniform');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('district_id');
            $table->string('lineup')->nullable();
            $table->json('top_players')->nullable();
            $table->timestamps();

            $table->foreign('owner_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');
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
}
