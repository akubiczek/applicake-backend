<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'password' => bcrypt('test123'),
        ]);

        $stages = [1 => 'Nowy', 2 => 'Analiza CV', 3 => 'Rozmowa telefoniczna', 4 => 'Spotkanie', 5 => 'Odrzucenie po CV', 6 => 'Odrzucenie po telefonie', 7 => 'Odrzucenie po spotkaniu', 8 => 'Złożenie oferty', 9 => 'Zatrudnienie', 9 => 'Rezygnacja kandydata'];

        foreach ($stages as $key => $val) {
            DB::table('stages')->insert([
                'id'   => $key,
                'name' => $val,
            ]);
        }
    }
}
