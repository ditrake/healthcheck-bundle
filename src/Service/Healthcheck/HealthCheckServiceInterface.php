<?php
/**
 * 17.06.2020.
 */

declare(strict_types=1);

namespace App\Service\Healthcheck;

/**
 * Интерфейс для проверки подсистем
 *
 * Interface HealthCheckServiceInterface
 *
 * @package App\Service
 */
interface HealthCheckServiceInterface
{
    /**
     * Проверяет подсистемы.
     *
     * @return bool
     */
    public function check(): bool;
}
