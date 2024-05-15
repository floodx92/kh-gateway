<?php

namespace Floodx92\KhGateway\Model;

class Auth3dsBrowser extends Base
{
    public ?string $acceptHeader = null;
    public ?bool $javaEnabled = null;
    public ?string $language = null;
    public ?int $colorDepth = null;
    public ?int $screenHeight = null;
    public ?int $screenWidth = null;
    public ?int $timezone = null;
    public ?string $userAgent = null;
    public ?string $challengeWindowSize = null;
    public ?bool $javascriptEnabled = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->acceptHeader,
            $this->safeBool($this->javaEnabled),
            $this->language,
            $this->colorDepth,
            $this->screenHeight,
            $this->screenWidth,
            $this->timezone,
            $this->userAgent,
            $this->challengeWindowSize,
            $this->safeBool($this->javascriptEnabled),
        ], fn ($value) => null !== $value)));
    }
}
