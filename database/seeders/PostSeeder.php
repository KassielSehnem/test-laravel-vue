<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Cria posts apenas para os usuários que podem criar posts (admins)
        User::where('is_admin', true)->get()->each(function($user) {
            Post::factory(20)->create(['user_id' => $user->id]);
        });
    }
}
