<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMousebungeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mousebungees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mousebungee_name');
            $table->unsignedBigInteger('maker_id')->foreign('maker_id')->references('id')->on('makers')->onDelete('set null');
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
        Schema::dropIfExists('mousebungees');
    }
}
