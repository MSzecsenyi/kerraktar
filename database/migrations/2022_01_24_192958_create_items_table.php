<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('district');
            $table->foreignId('category_id')->onDelete('set null');
            $table->foreignId('store_id')->onDelete('set null');
            $table->boolean('is_available')->default(true);
            $table->boolean('is_usable')->default(true);
            $table->string('owner')->nullable();
            $table->string('item_name');
            $table->integer('amount')->default(1);
            $table->string('comment')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
