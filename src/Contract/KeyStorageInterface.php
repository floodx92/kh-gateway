<?php

namespace Floodx92\KhGateway\Contract;

interface KeyStorageInterface
{
    /**
     * Get the private key.
     *
     * @throws \RuntimeException if the private key file not found
     */
    public function getPrivateKey(): string;

    /**
     * Get the public key.
     *
     * @throws \RuntimeException if the public key file not found
     */
    public function getPublicKey(): string;

    /**
     * Get the passphrase.
     */
    public function getPassphrase(): ?string;
}
