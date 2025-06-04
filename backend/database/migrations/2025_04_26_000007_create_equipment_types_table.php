
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('equipment_types', function (Blueprint $table) {
            $table->id('equipment_type_id');
            $table->string('equipment_type_name');
            $table->string('equipment_type_icon')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('equipment_types');
    }
};
