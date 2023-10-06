<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_managers', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('company')->unsigned()->index();
            $table->foreign('company')->references('id')->on('companies')->onDelete('cascade');

            $table->bigInteger('manager')->unsigned()->index();
            $table->foreign('manager')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_managers');
    }
};
