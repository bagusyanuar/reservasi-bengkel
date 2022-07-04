<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'username' => 'johnny',
                'password' => 'johnny',
                'name' => 'Johnny Abs',
                'phone' => '089287258',
                'address' => 'Jl. Surya No. 16. Surakarta'
            ],
            [
                'username' => 'jenny',
                'password' => 'jenny',
                'name' => 'Jenny Abs',
                'phone' => '0892872589',
                'address' => 'Jl. Ir. Sutami No. 18. Surakarta'
            ],
        ];

        foreach ($data as $v) {
            $user = User::create([
               'username' => $v['username'],
               'password' => Hash::make($v['password']),
               'role' => 'member'
            ]);

            Member::create([
                'user_id' => $user->id,
                'nama' => $v['name'],
                'no_hp' => $v['phone'],
                'alamat' => $v['address']
            ]);
        }
    }
}
