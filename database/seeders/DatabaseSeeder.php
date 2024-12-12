<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\EmailList;
use App\Models\Subscriber;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CampaignSeeder;
use Database\Seeders\TemplateSeeder;
use Database\Seeders\EmailListSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TemplateSeeder::class,
            EmailListSeeder::class,
            CampaignSeeder::class
        ]);
    }
}
