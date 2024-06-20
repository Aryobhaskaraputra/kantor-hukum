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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_extension')->nullable();
            $table->foreignUuid('case_id')->constrained('legal_cases');
            $table->string('uploaded_by');
            $table->timestamps();
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('files', function (Blueprint $table) {
        // Drop foreign key pada kolom 'case_id' di table 'files'
        $table->dropForeign(['case_id']);
    });

    // Drop table 'legal_cases'
    Schema::dropIfExists('legal_cases');
}
};
