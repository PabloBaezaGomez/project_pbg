
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('equipment_user', function (Blueprint $table) {
            $table->foreignId('equipment_id')->constrained('equipment', 'equipment_id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->primary(['equipment_id', 'user_id']);
            $table->timestamps(); // Added timestamps
        });
    }

    public function down(): void {
        Schema::dropIfExists('equipment_user');
    }
};
