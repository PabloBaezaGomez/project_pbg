
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('material_equipment', function (Blueprint $table) {
            $table->foreignId('material_id')->constrained('materials', 'material_id')->onDelete('cascade');
            $table->foreignId('equipment_id')->constrained('equipment', 'equipment_id')->onDelete('cascade');
            $table->integer('required_quantity');
            $table->primary(['material_id', 'equipment_id']);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('material_equipment');
    }
};
