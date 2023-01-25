<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->text('content')->nullable();
            $table->integer('rating')->nullable();
            $table->string('commentable_type');
            $table->bigInteger('commentable_id');
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::connection('sqlite')->create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->text('content')->nullable();
            $table->integer('rating')->nullable();
            $table->string('commentable_type');
            $table->bigInteger('commentable_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('comments', function(Blueprint $table){
        //     $table->dropForeign('user_id');
        // });
        Schema::dropIfExists('comments');

        Schema::connection('sqlite')->dropIfExists('comments');
    }
};
