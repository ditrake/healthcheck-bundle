<?php

declare(strict_types=1);

namespace App\Service\Healthcheck;

/**
 * Интерфейса для тега на пул сервисов, занимающихся проверкой доступности необходимых для работоспособности сервисов.
 *
 * Interface CheckServiceInterface
 *
 * @package App\Service\Healthcheck
 */
interface CheckServiceInterface
{
    /**
     * Проверяет доступность конкретного сервиса.
     *
     * @return bool
     */
    public function checkService(): bool;
}
