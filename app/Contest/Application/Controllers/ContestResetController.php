<?php

namespace App\Contest\Application\Controllers;

use App\Contest\Domain\Contest;
use App\Contest\Domain\ContestRepository;
use App\Contest\Domain\ValueObjects\ContestStatus;
use App\Setting\Domain\Contest\ContestActiveIdSetting;
use App\Setting\Domain\SettingRepository;
use App\Setting\Domain\ValueObjects\SettingName;
use App\Setting\Domain\ValueObjects\SettingValue;
use App\Shared\Application\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContestResetController extends Controller
{

    public function  __construct(
        private ContestActiveIdSetting $contestActiveId,
        private ContestRepository $contests,
        private SettingRepository $settings
    ) {
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $newContest = Contest::fromPrimitives(-1, "Vendedores a Correr", ContestStatus::OPEN);

        $newContest = $this->contests->create($newContest);

        $this->settings->update(
            SettingName::fromValue(SettingName::CONTEST_ACTIVE_ID),
            SettingValue::fromValue($newContest->id()->value())
        );

        return response()->json([
            'message' => 'The active contest was successfully restarted',
            'status' => Response::HTTP_CREATED,
        ]);
    }
}
