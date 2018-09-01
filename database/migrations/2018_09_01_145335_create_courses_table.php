<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bank_id')->unsigned()->nullable()->default(null);
            $table->string('currency')->nullable()->default(null);
            /*purchase_price, sale_price, interbank, actual_date*/
            $table->decimal('purchase_price', 10, 4)->nullable()->default(null);
            $table->decimal('sale_price', 10, 4)->nullable()->default(null);
            $table->decimal('interbank', 10, 4)->nullable()->default(null);
            $table->string('ru_date')->nullable()->default(null);

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
        Schema::dropIfExists('courses');
    }
}
