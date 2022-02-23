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
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->string('email');
            $table->date('invoice_date');
            $table->string('mobile_num');
            $table->string('to');
            $table->string('from_address');
            $table->text('items');
            $table->text('excluding_vat');
            $table->integer('vat_amount');
            $table->integer('invoice_total');
            $table->integer('payed_amount');
            $table->integer('due_total');
            $table->text('comment');
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
        Schema::dropIfExists('invoice');
    }
};
