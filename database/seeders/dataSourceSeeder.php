<?php

namespace Database\Seeders;

use App\Logic\Content\NewsSources\GuardianAPISource;
use App\Logic\Content\NewsSources\NewsAPISource;
use App\Models\DataSource;
use Illuminate\Database\Seeder;

class dataSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataSource::create(
            [
                'id' => NewsAPISource::ID,
                'name' => NewsAPISource::NAME,
            ]
        );
        DataSource::create(
            [
                'id' => GuardianAPISource::ID,
                'name' => GuardianAPISource::NAME,
            ]
        );

    }
}
