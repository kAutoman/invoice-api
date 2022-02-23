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
            $table->text('title');
            $table->text('mobile_phone');
            $table->text('email');
            $table->text('name');
            $table->text('address');
            $table->text('town');
            $table->text('postal_code');
            $table->text('further_note');
            $table->string('state');
            $table->date('remind_date');
            $table->integer('category_id');
            $table->text('attached_files');
            $table->text('invoices_id');
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