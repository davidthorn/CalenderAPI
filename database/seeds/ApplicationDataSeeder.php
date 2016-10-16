<?php

use Illuminate\Database\Seeder;

/**
 * This one can be used to generate overall applications data
 */
class ApplicationDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\CalenderEntry::class, 666)->create()->each(function ($entry) {
            // Do something with $entry when needed
        });
    }
}
