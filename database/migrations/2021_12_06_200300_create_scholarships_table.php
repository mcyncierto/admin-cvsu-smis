<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScholarshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')->constrained('semesters');
            $table->string('school_year');
            $table->foreignId('scholarship_type_id')->constrained('scholarship_types');
            // $table->string('gpa');
            $table->boolean('status')->default(0); // (0 - Created, 1 - For Approval, 2 - Approved, 3 - Closed)
            $table->string('organization')->nullable(); // Free text e.g. , Member of Harmonic Voices Choral, Student Publication Officer, Central Student Government Officer, Member of Con Aces Dance Strive, Athlete,and ROTC Officer
            $table->string('remarks')->nullable();
            $table->boolean('is_qualified')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            // $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scholarships');
    }
}
