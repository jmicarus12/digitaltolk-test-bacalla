<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('key')->index();
            $table->unsignedBigInteger('locale_id')->index();
            $table->foreign('locale_id')
                  ->references('id')->on('locales')
                  ->onDelete('cascade');
            $table->text('content');
            $table->string('tags')->index();
            $table->timestamps();

            $table->unique(['key', 'locale_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translations');
    }
}
