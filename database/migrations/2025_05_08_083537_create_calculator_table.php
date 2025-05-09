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
        Schema::create('calculator', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('url');
            $table->string('icon');
            $table->tinyInteger('status')->default(1)->comment('状态 1启用 0禁用');
            $table->timestamps();
        });

        // status add sql
        // ALTER TABLE `calculator` ADD COLUMN `status` TINYINT(1) DEFAULT 1 COMMENT '状态 1启用 0禁用' AFTER `icon`;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculator');
    }
};
