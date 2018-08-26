<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->foreign("user_id")->references('id')->on('users')->onDelete('cascade');
            $table->string('province')->comment('省份');
            $table->string("city")->comment('城市');
            $table->string('district')->comment('地区');
            $table->string('address')->comment('详细地址');
            $table->unsignedInteger('zip')->comment('邮编');
            $table->string('contact_name')->comment('收件人');
            $table->string('contact_phone')->comment('收件人联系电话');
            $table->dateTime('last_used_at')->nullable()->comment('最后使用时间');
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
        Schema::dropIfExists('user_addresses');
    }
}
