<?php

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

        $this->call(UsersTableSeeder::class);
        $this->call(RelationsTableSeeder::class);
        $this->call(ClassificationsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(FacilitiesTableSeeder::class);
        $this->call(RoomTypesTableSeeder::class);
        $this->call(RoomCategoriesTableSeeder::class);
        $this->call(RoomChargesTypeTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(FinanceReceivablesTableSeeder::class);
        $this->call(SportsTableSeeder::class);
    }
}
