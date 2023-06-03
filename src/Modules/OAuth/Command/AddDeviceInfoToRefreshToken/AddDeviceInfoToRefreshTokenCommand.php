<?php

declare(strict_types=1);

namespace App\Modules\OAuth\Command\AddDeviceInfoToRefreshToken;

final class AddDeviceInfoToRefreshTokenCommand
{
    public function __construct(
        public readonly ?string $identifier = null,
        public readonly ?string $locale = null,
        public readonly ?string $pushToken = null,
        public readonly ?string $voipToken = null,
        public readonly ?string $baseOS = null,
        public readonly ?string $buildId = null,
        public readonly ?string $brand = null,
        public readonly ?string $buildNumber = null,
        public readonly ?string $bundleId = null,
        public readonly ?string $carrier = null,
        public readonly ?string $deviceId = null,
        public readonly ?string $deviceName = null,
        public readonly ?string $ipAddress = null,
        public readonly ?string $installerPackageName = null,
        public readonly ?string $macAddress = null,
        public readonly ?string $manufacturer = null,
        public readonly ?string $model = null,
        public readonly ?string $systemName = null,
        public readonly ?string $systemVersion = null,
        public readonly ?string $userAgent = null,
        public readonly ?string $version = null,
    ) {
    }
}
