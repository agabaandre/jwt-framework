<?php

declare(strict_types=1);

namespace Jose\Bundle\JoseFramework\Event;

use Jose\Component\Core\JWK;
use Jose\Component\Core\JWKSet;
use Jose\Component\Signature\JWS;
use Symfony\Contracts\EventDispatcher\Event;

final class JWSVerificationSuccessEvent extends Event
{
    public function __construct(
        private JWS $jws,
        private JWKSet $JWKSet,
        private int $signature,
        private ?string $detachedPayload,
        private JWK $JWK
    ) {
    }

    public function getJws(): JWS
    {
        return $this->jws;
    }

    public function getJWKSet(): JWKSet
    {
        return $this->JWKSet;
    }

    public function getJWK(): JWK
    {
        return $this->JWK;
    }

    public function getSignature(): int
    {
        return $this->signature;
    }

    public function getDetachedPayload(): ?string
    {
        return $this->detachedPayload;
    }
}
