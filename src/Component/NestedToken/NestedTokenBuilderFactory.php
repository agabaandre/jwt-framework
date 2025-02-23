<?php

declare(strict_types=1);

namespace Jose\Component\NestedToken;

use Jose\Component\Encryption\JWEBuilderFactory;
use Jose\Component\Encryption\Serializer\JWESerializerManagerFactory;
use Jose\Component\Signature\JWSBuilderFactory;
use Jose\Component\Signature\Serializer\JWSSerializerManagerFactory;

class NestedTokenBuilderFactory
{
    public function __construct(
        private JWEBuilderFactory $jweBuilderFactory,
        private JWESerializerManagerFactory $jweSerializerManagerFactory,
        private JWSBuilderFactory $jwsBuilderFactory,
        private JWSSerializerManagerFactory $jwsSerializerManagerFactory
    ) {
    }

    /**
     * This method creates a Nested Token Builder with the given encryption/signature algorithms, serializers and
     * compression methods.
     */
    public function create(
        array $jwe_serializers,
        array $keyEncryptionAlgorithms,
        array $contentEncryptionAlgorithms,
        array $compressionMethods,
        array $jws_serializers,
        array $signatureAlgorithms
    ): NestedTokenBuilder {
        $jweBuilder = $this->jweBuilderFactory->create(
            $keyEncryptionAlgorithms,
            $contentEncryptionAlgorithms,
            $compressionMethods
        );
        $jweSerializerManager = $this->jweSerializerManagerFactory->create($jwe_serializers);
        $jwsBuilder = $this->jwsBuilderFactory->create($signatureAlgorithms);
        $jwsSerializerManager = $this->jwsSerializerManagerFactory->create($jws_serializers);

        return new NestedTokenBuilder($jweBuilder, $jweSerializerManager, $jwsBuilder, $jwsSerializerManager);
    }
}
