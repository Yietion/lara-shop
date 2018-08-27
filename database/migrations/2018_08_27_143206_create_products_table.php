<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('商品名称');
            $table->text('description')->comment('商品描述');
            $table->string('image')->comment('商品图');
            $table->boolean('on_sale')->default(true)->comment('是否在售');
            $table->float('rating')->default(5)->comment('综合评分');
            $table->unsignedInteger('sold_count')->default(0)->comment('销售量');
            $table->unsignedInteger('review_count')->default(0)->comment('评论量');
            $table->decimal('price', 10, 2)->comment('SKU 最低价格');
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
        Schema::dropIfExists('products');
    }
}
