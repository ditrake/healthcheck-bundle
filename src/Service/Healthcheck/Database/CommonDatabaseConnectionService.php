<?php

declare(strict_types=1);

namespace App\Service\Healthcheck\Database;

use App\Service\Healthcheck\CheckServiceInterface;
use App\Service\Healthcheck\HealthCheckException;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Throwable;

class CommonDatabaseConnectionService implements CheckServiceInterface
{
    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $registry;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * CommonDatabaseConnectionService constructor.
     *
     * @param ManagerRegistry $registry
     * @param LoggerInterface $logger
     */
    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        $this->registry = $registry;
        $this->logger = $logger;
    }

    /**
     * @return bool
     */
    public function checkService(): bool
    {
        foreach ($this->registry->getConnections() as $connection) {
            if ($connection instanceof Connection) {
                if (!$this->tryConnect($connection)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param Connection $connection
     *
     * @return bool
     */
    protected function tryConnect(Connection $connection): bool
    {
        try {
            return $connection->connect() && $connection->isConnected();
        } catch (Throwable $exception) {
            $this->logger->critical($exception->getMessage());

            throw new HealthCheckException($exception->getMessage());
        }
    }
}
