<?php

namespace App\Contest\Application\Controllers;

use App\Contest\Application\Resources\ContestResource;
use App\Contest\Domain\Contest;
use App\Contest\Domain\ContestRepository;
use App\Contest\Domain\ValueObjects\ContestId;
use App\Contest\Domain\ValueObjects\ContestName;
use App\Contest\Domain\ValueObjects\ContestStatus;
use App\Setting\Domain\SettingRepository;
use App\Setting\Domain\ValueObjects\SettingName;
use App\Setting\Domain\ValueObjects\SettingValue;
use App\Shared\Application\Http\Controllers\Controller;
use App\Shared\Application\Resources\SerializerManager;
use Illuminate\Http\Request;

class ContestActiveCreateController extends Controller
{
    public function __construct(
        private SettingRepository $settings,
        private ContestRepository $contests,
        private SerializerManager $manager,
        private ContestResource $resource
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
        $contest = $this->contests->create(
            Contest::fromPrimitives(0, 'Vendedores a Correr', ContestStatus::OPEN)
        );

        $this->settings->update(
            SettingName::fromValue(SettingName::CONTEST_ACTIVE_ID),
            SettingValue::fromValue($contest->id()->value())
        );

        return response()->json([
            'status' => 201,
            'message' => 'A new contest was created and set as active',
        ]);
    }
}
