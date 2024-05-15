<?php

namespace Floodx92\KhGateway\Model;

class GooglePayInitParams extends Base
{
    public int $apiVersion = 2;
    public int $apiVersionMinor = 0;
    public ?string $paymentMethodType = null;
    /** @var string[] */
    public ?array $allowedCardNetworks = null;
    /** @var string[] */
    public ?array $allowedCardAuthMethods = null;
    public ?bool $assuranceDetailsRequired = null;
    public ?bool $billingAddressRequired = null;
    public ?string $billingAddressParametersFormat = null;
    public ?string $tokenizationSpecificationType = null;
    public ?string $gateway = null;
    public ?string $gatewayMerchantId = null;
    public ?string $googlepayMerchantId = null;
    public ?string $merchantName = null;
    public ?string $environment = null;
    public ?string $totalPriceStatus = null;
    public ?string $countryCode = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->apiVersion,
            $this->apiVersionMinor,
            !empty($this->allowedCardNetworks) ? implode('|', $this->allowedCardNetworks) : null,
            !empty($this->allowedCardAuthMethods) ? implode('|', $this->allowedCardAuthMethods) : null,
            $this->googlepayMerchantId,
            $this->merchantName,
            $this->totalPriceStatus,
        ], fn ($value) => null !== $value)));
    }
}
