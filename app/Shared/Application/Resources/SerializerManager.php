<?php

namespace App\Shared\Application\Resources;

use League\Fractal\Manager;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Serializer\DataArraySerializer;

final class SerializerManager
{
    public function __construct(private Manager $manager, private DataArraySerializer $serializer)
    {
        $this->useSerializer($this->serializer);
    }

    public function useSerializer(SerializerAbstract $serializer): static
    {
        $this->manager->setSerializer($serializer);

        return $this;
    }

    public function serialize(ResourceInterface $resource): array
    {
        return $this->manager->createData($resource)->toArray();
    }
}
