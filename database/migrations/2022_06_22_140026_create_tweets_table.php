<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('twitter_id')->unique();
            $table->text('text');
            $table->integer('retweets');
            $table->integer('likes');
            $table->integer('replies');
            $table->integer('quotes');
            $table->float('polarity', 2, 2);
            $table->float('subjectivity', 2, 2);
            $table->float('toxicity_rate', 2, 2);
            $table->float('claim_rate', 2, 2);
            $table->dateTime('posted_at');
            $table->boolean('deleted')->default(0);
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('tweets');
    }
}
