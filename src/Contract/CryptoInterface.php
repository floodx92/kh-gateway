<?php

namespace Floodx92\KhGateway\Contract;

interface CryptoInterface
{
    /**
     * Create a signature for the given data.
     */
    public function createSignature(Signable $data): string;

    /**
     * Verify the signature for the given data.
     */
    public function verifySignature(Signable $data, string $signature): bool;
}
