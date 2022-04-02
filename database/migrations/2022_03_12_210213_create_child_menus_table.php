<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_menus', function (Blueprint $table) {
            $table->id();
            $table->string('menu_name');
            $table->text('image');
            $table->text('icon');
            $table->Integer('parent');
            $table->string('status');
            $table->datetime('created_by');
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
        Schema::dropIfExists('child_menus');
    }
}
