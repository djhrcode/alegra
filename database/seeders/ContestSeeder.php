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
        $this->createNewActiveContest();
        $this->createNewContestWinningPoints();
    }

    public function createNewActiveContest()
    {
        $currentContest = $this->contest->newQuery()->firstOrCreate(
            ['status' => ContestStatus::OPEN],
            ['name' => 'Vendedores a Correr']
        );

        $this->setting->newQuery()->firstOrCreate([
            'value' => $currentContest->id,
            'name' => SettingName::CONTEST_ACTIVE_ID,
        ]);
    }

    public function createNewContestWinningPoints()
    {
        $this->setting->newQuery()->firstOrCreate([
            'value' => 20,
            'name' => SettingName::CONTEST_WINNING_POINTS,
        ]);
    }
}
