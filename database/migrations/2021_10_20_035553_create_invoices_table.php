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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('stripe_token')->unique();
            $table->string('invoice_code')->unique();
            $table->string('customer_name', 191)->nullable();
            $table->bigInteger('customer_phone')->nullable();
            $table->date('date_in')->nullable()->default(null);
            $table->date('date_taken')->nullable()->default(null);
            $table->integer('guarantee')->nullable();
            $table->string('order_status')->nullable();
            $table->string('payment_status')->nullable();
            $table->double('subtotal')->nullable();
            $table->double('discount')->nullable();
            $table->double('total_payment')->nullable();
            $table->double('down_payment')->nullable();
            $table->double('dependents')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('mark')->default(false);
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
