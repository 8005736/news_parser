<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniversitiesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string("title")->nullable();
            $table->string("url")->nullable();
            $table->string("favicon")->nullable();
            $table->integer("is_active")->default(1);
            $table->string("class")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('universities');
    }
}
