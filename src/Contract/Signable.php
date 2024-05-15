<?php

namespace Floodx92\KhGateway\Contract;

interface Signable
{
    /**
     * Get the data that should be signed.
     */
    public function toSignable(): string;

    /**
     * Set the DTTM (Date Time of the request).
     */
    public function setDttm(string $dttm): void;

    /**
     * Set the signature.
     */
    public function setSignature(string $signature): void;
}
