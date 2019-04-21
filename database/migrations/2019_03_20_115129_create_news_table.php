<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('news', function (Blueprint $table) {
         $table->increments('id');
         $table->string('title');
         $table->text('description');
         $table->string('category');
         $table->string('file_path')->default('assets/images/blog/default_news_a.jpg');
         $table->integer('uploaded_by');
         $table->tinyInteger('status')->default(1);
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
      Schema::dropIfExists('news');
   }
}
