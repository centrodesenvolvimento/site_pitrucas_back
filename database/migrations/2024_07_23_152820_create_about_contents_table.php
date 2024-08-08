<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_contents', function (Blueprint $table) {
            $table->id();
            $table->text('video')->nullable(); // Store video data
            $table->text('somos')->nullable(); // Store video data
            $table->text('missao')->nullable();
            $table->text('visao')->nullable(); // Large text field
            $table->json('valores')->nullable(); // JSON array of objects
            $table->json('orgaos_singulares')->nullable(); // JSON array of objects
            $table->json('orgaos_colegiais')->nullable(); // JSON array of objects
            $table->json('administracao')->nullable(); // JSON array of objects
            $table->json('historial')->nullable(); // JSON array of objects
            $table->text('organigrama')->nullable(); // Large text field
            $table->json('regulamentos')->nullable(); // JSON array of objects





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
        Schema::dropIfExists('about_contents');
    }
}
