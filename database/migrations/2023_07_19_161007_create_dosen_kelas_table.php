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
        Schema::create('dosen_kelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('kelas_id');
            $table->timestamps();

            $table->foreign('dosen_id')
                ->references('id')
                ->on('dosen')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('kelas_id')
                ->references('id')
                ->on('kelas')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_kelas');
    }
};
