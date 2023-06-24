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
        Schema::connection('budget')->create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 255)->unique();
            $table->text('title');
            $table->text('description');
            $table->double('maximum_amount', 13, 2); // it means this columan can handle values range start from -99999999999.99 upto 99999999999.99
            $table->bigInteger('created_by');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->bigInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('budget')->dropIfExists('budgets');
    }
};
