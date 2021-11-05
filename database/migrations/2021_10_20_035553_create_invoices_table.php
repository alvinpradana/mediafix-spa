<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code')->unique();
            $table->string('customer_name', 191)->nullable();
            $table->string('customer_phone', 50)->nullable();
            $table->date('date_in')->nullable();
            $table->date('date_taken')->nullable();
            $table->integer('guarantee')->nullable();
            $table->string('order_status')->nullable();
            $table->string('payment_status')->nullable();
            $table->double('subtotal')->nullable();
            $table->double('discount')->nullable();
            $table->double('total_payment')->nullable();
            $table->double('down_payment')->nullable();
            $table->double('dependents')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
