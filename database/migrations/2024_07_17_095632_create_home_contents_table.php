<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_contents', function (Blueprint $table) {
            $table->id();
            $table->text('videoInicial')->nullable(); // Store video data
            $table->text('imagemPr')->nullable(); // Store image data
            $table->text('perfilPr')->nullable();
            $table->text('mensagemPr')->nullable(); // Large text field
            $table->json('testemunhos')->nullable(); // JSON array of objects
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
        Schema::dropIfExists('home_contents');
    }
}
