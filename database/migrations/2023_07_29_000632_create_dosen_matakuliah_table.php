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
        Schema::create('dosen_matakuliah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('matakuliah_id');
            $table->timestamps();

            $table->foreign('dosen_id')
                ->references('id')
                ->on('dosen')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('matakuliah_id')
                ->references('id')
                ->on('matakuliah')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_matakuliah');
    }
};
