
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('materials', function (Blueprint $table) {
            $table->id('material_id');
            $table->string('material_name');
            $table->string('material_rarity');
            $table->text('material_description')->nullable();
            $table->foreignId('material_type')->constrained('material_types', 'material_type_id')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('materials');
    }
};
