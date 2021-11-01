<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Order;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable( );
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('contact')->nullable();

            $table->string('phone')->nullable();

            $table->string('requestid')->nullable();

            $table->string('urlgenerada')->nullable();

            $table->string('hash')->nullable();


            $table->enum('status', [Order::CREATED,Order::PAYED, Order::REJECTED]);

            $table->enum('envio_type', [1, 2]);

            $table->float('shipping_cost')->nullable();

            $table->float('total')->nullable();

            $table->json('content')->nullable();

            $table->json('envio')->nullable();

            $table->timestamps();
        });



        Schema::create('orders_requests_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->string('request_id');
            $table->string('process_url');
            $table->text('response')->nullable();
            $table->boolean('ending')->default(0);
            $table->string('status')->nullable();
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
        Schema::dropIfExists('orders');
        Schema::dropIfExists('orders_requests_payments');
    }
}
