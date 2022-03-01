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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('mobile_phone')->nullable();
            $table->text('email')->nullable();
            $table->text('name')->nullable();
            $table->text('address')->nullable();
            $table->text('town')->nullable();
            $table->text('postal_code')->nullable();
            $table->text('further_note')->nullable();
            $table->string('state')->nullable();
            $table->dateTime('remind_date')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('sms_sent')->nullable();
            $table->text('attached_files')->nullable();
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
        Schema::dropIfExists('customers');
    }
};
