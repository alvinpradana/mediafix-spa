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
            $table->string('customer_name', 191);
            $table->string('customer_phone', 16);
            $table->date('date_in');
            $table->date('date_taken')->nullable();
            $table->integer('guarantee')->nullable();
            $table->string('order_status');
            $table->string('payment_status');
            $table->double('subtotal');
            $table->double('discount')->nullable();
            $table->double('total_payment');
            $table->double('down_payment')->nullable();
            $table->double('dependents');
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
