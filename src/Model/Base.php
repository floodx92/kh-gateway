<?php

namespace Floodx92\KhGateway\Model;

use Floodx92\KhGateway\Contract\Signable;
use Floodx92\KhGateway\Trait\Fillable;

abstract class Base implements Signable
{
    use Fillable;

    public ?string $dttm = null;
    public ?string $signature = null;

    protected function removeLast(string $data2Sign): string
    {
        if (!str_ends_with($data2Sign, '|')) {
            return $data2Sign;
        }

        return substr($data2Sign, 0, -1);
    }

    public function setSignature(string $signature): void
    {
        $this->signature = $signature;
    }

    public function setDttm(string $dttm): void
    {
        $this->dttm = $dttm;
    }

    protected function safeBool(?bool $value): ?string
    {
        return null === $value ?: ($value ? 'true' : 'false');
    }
}
