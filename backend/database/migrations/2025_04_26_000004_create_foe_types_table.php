
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('foe_types', function (Blueprint $table) {
            $table->id('foe_type_id');
            $table->string('foe_type_name');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('foe_types');
    }
};
