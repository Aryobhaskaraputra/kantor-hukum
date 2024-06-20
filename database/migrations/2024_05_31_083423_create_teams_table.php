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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('case_id')->constrained('legal_cases')->nullable();
            $table->string('leader_id');
            $table->string('member2_id');
            $table->string('member3_id');
            $table->string('member4_id')->nullable();
            $table->string('member5_id')->nullable();
            $table->string('member6_id')->nullable();
            $table->string('created_by')->default('2');
            $table->timestamps();


            $table->foreign('leader_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('member2_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('member3_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('member4_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('member5_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('member6_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            // Hapus kolom kunci asing pada 'case_id' jika ada
            $table->dropForeign(['case_id']);
        });

        Schema::dropIfExists('teams');
    }
};
