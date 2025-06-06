
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('material_types', function (Blueprint $table) {
            $table->id('material_type_id');
            $table->string('material_type_name');
            $table->string('material_type_icon')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('material_types');
    }
};
