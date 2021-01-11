<?php

declare(strict_types=1);

namespace App\Service\Healthcheck;

class HealthCheckService implements HealthCheckServiceInterface
{
    /**
     * Наши сервисы для проверки подсистем.
     *
     * @var null|iterable
     */
    private ?iterable $services;

    public function __construct(?iterable $services = null)
    {
        $this->services = $services;
    }

    /**
     * {@inheritDoc}
     */
    public function check(): bool
    {
        if (null === $this->services) {
            return true;
        }

        foreach ($this->services as $service) {
            if ($service instanceof CheckServiceInterface) {
                if (!$service->checkService()) {
                    return false;
                }
            }
        }

        return true;
    }
}
