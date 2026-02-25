<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin','cliente'])->default('cliente');
            $table->string('cpf', 14)->unique()->nullable();
            $table->string('phone',20)->nullable();
            $table->string('adress')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    
        DB::table('users')->insert([
        'name'       => 'Administrador',
        'email'      => 'admin@farmacia.com',
        'password'   => bcrypt('123456'),
        'role'       => 'admin',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    }
};
