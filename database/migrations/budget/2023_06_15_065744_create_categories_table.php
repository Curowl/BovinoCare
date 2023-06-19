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
        Schema::connection('budget')->create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 255)->unique();
            $table->string('name', 100);
            $table->text('description');
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
        Schema::connection('budget')->dropIfExists('categories');
    }
};
