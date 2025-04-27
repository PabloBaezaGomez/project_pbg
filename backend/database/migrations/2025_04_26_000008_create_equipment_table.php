
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id('equipment_id');
            $table->string('equipment_name');
            $table->foreignId('equipment_type')->constrained('equipment_types', 'equipment_type_id')->onDelete('cascade');
            $table->integer('equipment_stat');
            $table->text('equipment_description')->nullable();
            $table->string('equipment_image')->nullable();
            $table->timestamps(); // Added timestamps
        });
    }

    public function down(): void {
        Schema::dropIfExists('equipment'); // Fixed table name to match creation
    }
};
