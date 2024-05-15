<?php

namespace Floodx92\KhGateway\Crypto;

use Floodx92\KhGateway\Contract\CryptoInterface;
use Floodx92\KhGateway\Contract\KeyStorageInterface;
use Floodx92\KhGateway\Contract\Signable;

class OpenSSLAdapter implements CryptoInterface
{
    private \OpenSSLAsymmetricKey|\OpenSSLCertificate|string $publicKeyId;
    private \OpenSSLAsymmetricKey|\OpenSSLCertificate|string $privateKeyId;

    public function __construct(
        private readonly KeyStorageInterface $keyStorage,
        private readonly bool $verifySignature = true
    ) {
        $this->publicKeyId = openssl_get_publickey($this->keyStorage->getPublicKey());

        $this->privateKeyId = openssl_get_privatekey(
            $this->keyStorage->getPrivateKey(),
            $this->keyStorage->getPassphrase()
        );
    }

    public static function make(
        KeyStorageInterface $keyStorage,
        bool $verifySignature = true
    ): self {
        return new self($keyStorage, $verifySignature);
    }

    public function createSignature(Signable $data): string
    {
        $data->setDttm(date('YmdHis'));
        openssl_sign($data->toSignable(), $signature, $this->privateKeyId, OPENSSL_ALGO_SHA256);
        $signature = base64_encode($signature);
        $data->setSignature($signature);

        return $signature;
    }

    public function verifySignature(Signable $data, string $signature): bool
    {
        if (!$this->verifySignature) {
            return true;
        }

        $signature = base64_decode($signature);
        $res = openssl_verify($data->toSignable(), $signature, $this->publicKeyId, OPENSSL_ALGO_SHA256);

        return 1 === $res;
    }
}
