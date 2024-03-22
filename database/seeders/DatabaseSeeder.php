<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Permittion;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::Create([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' => bcrypt('admin'),
            'level' => 1
        ]);
        User::Create([
            'name' => 'verifikator',
            'email' => 'verifikator@email.com',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' => bcrypt('verifikator'),
            'level' => 2
        ]);
        User::Create([
            'name' => 'user biasa 1',
            'email' => 'user1@email.com',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' => bcrypt('user'),
            'level' => 3
        ]);
        User::Create([
            'name' => 'user biasa 2',
            'email' => 'user2@email.com',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' => bcrypt('user'),
            'level' => 3
        ]);
        User::Create([
            'name' => 'user biasa 3',
            'email' => 'user3@email.com',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' => bcrypt('user'),
            'level' => 3
        ]);
        Permittion::Create([
            'userId' => '3',
            'subject' => 'Cuti',
            'description' => 'Assalamualaikum pak, saya izin cuti hari ini, dikarenakan saya harus menghadiri interview di PT A'
        ]);
        Permittion::Create([
            'userId' => '4',
            'subject' => 'Sakit',
            'description' => 'Assalamualaikum pak, saya izin absen hari ini, dikarenakan saya sedang demam dan flu. Terima kasih'
        ]);
    }
}
