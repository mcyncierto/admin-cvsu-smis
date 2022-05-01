<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScholarshipTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scholarship_types', function (Blueprint $table) {
            $table->id();
            $table->string('scholarship_type_name');
            $table->string('description')->nullable();
            $table->string('max_scholars_allowed')->nullable();
            $table->string('lowest_gpa_allowed')->nullable();
            $table->string('highest_gpa_allowed')->nullable();
            $table->string('restrictions')->nullable(); // Sample values: INC, Dropped (This field should be comma separated string)
            $table->timestamps();
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scholarship_types');
    }
}
