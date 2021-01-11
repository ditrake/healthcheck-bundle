<?php

declare(strict_types=1);

namespace App\Service\Healthcheck\Messenger;

use App\Service\Healthcheck\CheckServiceInterface;
use App\Service\Healthcheck\HealthCheckException;
use Symfony\Component\Messenger\Transport\SetupableTransportInterface;
use Throwable;

class RabbitMQConnectionService implements CheckServiceInterface
{
    private ?iterable $transports;

    /**
     * RabbitMQConnectionService constructor.
     *
     * @param null|iterable $transports
     */
    public function __construct(?iterable $transports)
    {
        $this->transports = $transports;
    }

    /**
     * @return bool
     */
    public function checkService(): bool
    {
        if (null === $this->transports) {
            return true;
        }

        foreach ($this->transports as $transport) {
            if ($transport instanceof SetupableTransportInterface) {
                if (!$this->trySetup($transport)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param SetupableTransportInterface $transport
     *
     * @return bool
     */
    protected function trySetup(SetupableTransportInterface $transport): bool
    {
        try {
            $transport->setup();

            return true;
        } catch (Throwable $exception) {
            throw new HealthCheckException($exception->getMessage());
        }
    }
}
