<?php

declare(strict_types=1);

namespace App\Infra\Database;

use App\Config\AppConfig;
use PDO;

final class PdoConnection
{
    private array $config;
    public function __construct(AppConfig $appConfig)
    {
        $this->config = $appConfig->getConfig();
    }

    public function getTx(): PDO
    {
        $config = $this->config;
        $dsn = sprintf(
            'pgsql:host=%s;port=%s;dbname=%s;',
            $config['db']['host'],
            $config['db']['port'],
            $config['db']['dbname']
        );

        $pdo = new PDO($dsn, $config['db']['username'], $config['db']['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT => true
        ]);
        return $pdo;
    }
}
