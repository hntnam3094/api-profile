<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('struction_pages', function (Blueprint $table) {
            $table->id();
            $table->string('pageCode');
            $table->string('code', 64);
            $table->integer('singleRow');
            $table->string('title');
            $table->tinyInteger('status')->default(1);
            $table->integer('sequence')->default(0);

            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('deleted_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('struction_pages');
    }
};
