<?php

namespace Floodx92\KhGateway\Storage;

use Floodx92\KhGateway\Contract\KeyStorageInterface;

class FileKeyStorage implements KeyStorageInterface
{
    public function __construct(
        private readonly string $privateKeyPath,
        private readonly string $publicKeyPath,
        private readonly ?string $passphrase = null
    ) {
    }

    /**
     * Create a new instance of the class.
     */
    public static function make(
        string $privateKeyPath,
        string $publicKeyPath,
        ?string $passphrase = null
    ): self {
        return new self($privateKeyPath, $publicKeyPath, $passphrase);
    }

    public function getPrivateKey(): string
    {
        if (!file_exists($this->privateKeyPath)) {
            throw new \RuntimeException('Private key file not found in: '.$this->privateKeyPath);
        }

        return file_get_contents($this->privateKeyPath);
    }

    public function getPublicKey(): string
    {
        if (!file_exists($this->publicKeyPath)) {
            throw new \RuntimeException('Public key file not found in: '.$this->publicKeyPath);
        }

        return file_get_contents($this->publicKeyPath);
    }

    public function getPassphrase(): ?string
    {
        return $this->passphrase;
    }
}
