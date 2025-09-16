<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // id
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK للمستخدم
            $table->string('title', 255); // عنوان المهمة
            $table->text('description')->nullable(); // وصف المهمة
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium'); // الأولوية
            $table->dateTime('due_date'); // تاريخ الاستحقاق
            $table->boolean('completed')->default(false); // حالة الإنجاز
            $table->timestamps(); // created_at + updated_at
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
