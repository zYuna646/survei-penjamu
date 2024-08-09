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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->boolean('isUpdate')->default(false);
            $table->boolean('isAktif')->default(true);
            $table->unsignedBigInteger('jenis_id')->nullable();
            $table->unsignedBigInteger('target_id');
            $table->timestamps();

            $table->foreign('jenis_id')->references('id')->on('jenis')->onDelete('cascade');
            $table->foreign('target_id')->references('id')->on('targets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->dropForeign(['survey_id']);
            $table->dropForeign(['target_id']);
        });

        Schema::dropIfExists('surveys');
    }
};
