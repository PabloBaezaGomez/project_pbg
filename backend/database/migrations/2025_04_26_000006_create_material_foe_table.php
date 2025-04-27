
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('material_foe', function (Blueprint $table) {
            $table->foreignId('material_id')->constrained('materials', 'material_id')->onDelete('cascade');
            $table->foreignId('foe_id')->constrained('foes', 'foe_id')->onDelete('cascade');
            $table->decimal('drop_rate', 5, 2);
            $table->primary(['material_id', 'foe_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('material_foe');
    }
};
