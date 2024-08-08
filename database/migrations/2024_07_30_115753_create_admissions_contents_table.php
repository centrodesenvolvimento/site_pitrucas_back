<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionsContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admissions_contents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('emolumentos')->nullable();
            $table->text('calendario')->nullable();
            $table->json('exames')->nullable();
            $table->json('perguntas')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admissions_contents');
    }
}
