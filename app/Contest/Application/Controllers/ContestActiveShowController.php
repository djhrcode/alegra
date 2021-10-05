<?php

namespace App\Contest\Application\Controllers;

use App\Contest\Application\Resources\ContestResource;
use App\Contest\Domain\Contest;
use App\Contest\Domain\ContestRepository;
use App\Contest\Domain\ValueObjects\ContestId;
use App\Setting\Domain\SettingRepository;
use App\Setting\Domain\ValueObjects\SettingName;
use App\Shared\Application\Http\Controllers\Controller;
use App\Shared\Application\Resources\SerializerManager;
use Illuminate\Http\Request;

class ContestActiveShowController extends Controller
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
        $contestActiveId = $this->settings->find(
            SettingName::fromValue(SettingName::CONTEST_ACTIVE_ID)
        )->value();

        $contestActive = $this->contests->find(
            ContestId::fromValue($contestActiveId->value())
        );

        return $this->manager->serialize($this->resource->makeItem($contestActive));
    }
}
