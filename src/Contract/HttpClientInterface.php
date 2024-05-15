<?php

namespace Floodx92\KhGateway\Contract;

interface HttpClientInterface
{
    public function get(string $url, ?string $returnHeader = null): \stdClass|string;

    public function post(string $url, array $data): ?\stdClass;

    public function put(string $url, array $data): ?\stdClass;

    public function delete(string $url): ?\stdClass;
}
