<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('spots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('vSal_Base');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_admin')->default(0);
            $table->boolean('is_user')->default(0);
            $table->foreignId('spot_id');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->default(1);
            $table->foreignId('status_id')->default(1);
            $table->timestamps();
//            $table->foreignId('spot_id');
        });

        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->default(1);
            $table->foreignId('product_id');
            $table->string('quantity')->default(1);
           // $table->string('price')->default(1);
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('restrict');
            $table->foreign('status_id')
                  ->references('id')->on('statuses')
                  ->onDelete('restrict');

        });
        Schema::table('order_products', function (Blueprint $table) {
            $table->foreign('order_id')
                  ->references('id')->on('orders')
                  ->onDelete('restrict');
            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('restrict');

        });
        /*
               Schema::table('projects', function(Blueprint $table)
               {
                   $table->foreign('spot_id')
                       ->references('id')->on('spots')
                       ->onDelete('restrict');
                   $table->foreign('status_id')
                       ->references('id')->on('statuses')
                       ->onDelete('restrict');
               });
 */
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('spot_id')
                  ->references('id')->on('spots')
                  ->onDelete('restrict');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('products');
        Schema::dropIfExists('spots');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('statuses');
    }
}
