<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('unique_items', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->default(DB::raw('public.uuid_generate_v4()'))->unique();
            $table->timestamps();
            $table->foreignId('item_id')->constrained();
            $table->string('alt_name')->nullable();
            $table->foreignId('taken_out_by')->nullable();
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
        Schema::dropIfExists('unique_items');
    }
};
