<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreasuriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treasuries', function (Blueprint $table) {
            $table->id();
            $table->string('total_credit');
            $table->string('total_spent');
            $table->string('sell');
            $table->string('refund');
            $table->string('total_lend');
            $table->string('on_hand');
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
        Schema::dropIfExists('treasuries');
    }
}
