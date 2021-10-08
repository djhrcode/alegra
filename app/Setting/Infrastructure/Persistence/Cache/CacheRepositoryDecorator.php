<?php

namespace App\Setting\Infrastructure\Persistence\Cache;

use App\Setting\Domain\Setting;
use App\Setting\Domain\SettingRepository;
use App\Setting\Domain\ValueObjects\SettingName;
use App\Setting\Domain\ValueObjects\SettingValue;
use Illuminate\Support\Facades\Cache;

class CacheRepositoryDecorator implements SettingRepository
{
    const CACHE_LIFETIME = 3600;
    const CACHE_NAMESPACE = "settings";
    const CACHE_FIND_METHOD = "find";

    public function __construct(
        private SettingRepository $repository,
        private Cache $cache
    ) {
    }

    private function getCacheKey(string $action, string ...$words): string
    {
        return implode(".", [static::CACHE_NAMESPACE, $action, ...$words]);
    }

    public function find(SettingName $name): ?Setting
    {
        return $this->cache::remember(
            $this->getCacheKey(static::CACHE_FIND_METHOD, $name->value()),
            static::CACHE_LIFETIME,
            fn () => $this->repository->find($name)
        );
    }

    public function update(SettingName $name, SettingValue $value): void
    {
        $this->repository->update($name, $value);

        $this->cache::forget(
            $this->getCacheKey(static::CACHE_FIND_METHOD, $name->value())
        );
    }
}
