<?php

namespace Database\Seeders;

use App\Contest\Domain\ValueObjects\ContestStatus;
use App\Contest\Infrastructure\Persistence\Eloquent\ContestModel;
use App\Setting\Domain\ValueObjects\SettingName;
use App\Setting\Infrastructure\Persistence\Eloquent\SettingModel;
use Illuminate\Database\Seeder;

class ContestSeeder extends Seeder
{

    public function __construct(
        private ContestModel $contest,
        private SettingModel $setting
    ) {
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nextContestId = number_format($this->contest->max('id') + 1, 1);

        $currentContest = $this->contest->newQuery()->firstOrCreate(
            [
                'status' => ContestStatus::OPEN,
            ],
            [
                'name' => 'Vendedores a Correr ' . $nextContestId,
            ]
        );

        $this->setting->newQuery()->firstOrCreate(
            [
                'name' => SettingName::CONTEST_ACTIVE_ID,
                'value' => $currentContest->id
            ]
        );
    }
}
