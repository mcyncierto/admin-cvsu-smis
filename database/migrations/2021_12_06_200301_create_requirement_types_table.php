<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequirementTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirement_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scholarship_type_id')->constrained('scholarship_types');
            $table->string('requirement_name');
            $table->string('description')->nullable();
            $table->string('input_type'); // attachment, textbox, dropdown etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requirement_types');
    }
}
