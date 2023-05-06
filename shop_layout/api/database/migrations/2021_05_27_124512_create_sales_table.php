<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('type_product_id')->default(0);
            $table->integer('category_id')->default(0);
            $table->integer('supplier_id')->default(0);
            $table->unique(['type_product_id', 'category_id', 'supplier_id'], 'unique_sale');
            $table->integer('sale');
            $table->integer('order_no');
            $table->integer('status');
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
        Schema::dropIfExists('sales');
    }
}
