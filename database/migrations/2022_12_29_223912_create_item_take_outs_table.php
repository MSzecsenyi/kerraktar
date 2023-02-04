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
        Schema::create('item_take_outs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('request_id')->constrained();
            $table->foreignId('item_id')->constrained();
            $table->int('amount')->default(0);
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
        Schema::dropIfExists('item_take_outs');
    }
};
