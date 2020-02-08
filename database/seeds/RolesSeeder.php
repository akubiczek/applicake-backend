<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    const TABLE_NAME = 'roles';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'SUPER_ADMIN',
        ];

        if (Schema::hasTable(self::TABLE_NAME)) {
            $now = \Carbon\Carbon::now()->toDateTimeString();
            $maped = array_map(
                function ($role) use ($now) {
                    return [
                        'name' => $role,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                },
                $roles
            );

            switch (DB::table(self::TABLE_NAME)->exists()) {
                case false:
                    DB::table(self::TABLE_NAME)->insert($maped);
                    break;
                case true:
                    foreach ($maped as $role) {
                        if (!DB::table(self::TABLE_NAME)->where('name', $role['name'])->exists()) {
                            DB::table(self::TABLE_NAME)->insert($role);
                        }
                    }
                    break;
            }
        }
    }
}
