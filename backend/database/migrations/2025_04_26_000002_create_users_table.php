
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('user_name');
            $table->string('user_type');
            $table->string('user_password');
            $table->string('user_email')->unique();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};
