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
        Schema::create('take_out_unique_item', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('take_out_id')->constrained();
            $table->foreignId('unique_item_id')->constrained();
            $table->string('notes_added')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('take_out_unique_item');
    }
};
