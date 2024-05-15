<?php

namespace Floodx92\KhGateway\Mapper;

use JsonMapper\JsonMapperFactory;
use JsonMapper\JsonMapperInterface;

class JsonMapper
{
    private JsonMapperInterface $mapper;

    public function __construct()
    {
        $this->mapper = (new JsonMapperFactory())->bestFit();
    }

    public function mapObject(object $json, object $object)
    {
        return $this->mapper->mapObject($json, $object);
    }
}
