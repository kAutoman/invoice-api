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
            $table->string('invoice_no')->nullable();
            $table->string('email')->nullable();
            $table->dateTime('invoice_date')->nullable();
            $table->string('mobile_num')->nullable();
            $table->string('to')->nullable();
            $table->string('from_address')->nullable();
            $table->text('items')->nullable();
            $table->text('excluding_vat')->nullable();
            $table->integer('vat_amount')->nullable();
            $table->integer('invoice_total')->nullable();
            $table->integer('payed_amount')->nullable();
            $table->integer('due_total')->nullable();
            $table->text('comment')->nullable();
            $table->integer('customer_id')->nullable();
            $table->text('preset1')->nullable();
            $table->text('preset2')->nullable();
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
