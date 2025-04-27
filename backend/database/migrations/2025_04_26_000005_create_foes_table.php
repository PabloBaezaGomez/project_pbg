
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('foes', function (Blueprint $table) {
            $table->id('foe_id');
            $table->string('foe_name');
            $table->foreignId('foe_type')->constrained('foe_types', 'foe_type_id')->onDelete('cascade');
            $table->string('foe_size');
            $table->text('foe_description')->nullable();
            $table->string('foe_icon')->nullable();
            $table->string('foe_image')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('foes');
    }
};
