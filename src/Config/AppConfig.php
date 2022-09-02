<?php
declare(strict_types=1);
namespace App\Config;

final class AppConfig
{
    private $config = [
        'db' => [
            'host' => 'localhost',
            'username' => 'postgres',
            'password' => 'postgres',
            'port' => '5432',
            'dbname' => 'admin',
            'charset' => 'utf8'
    ]];

    public function getConfig():Array
    {
        return $this->config;
    }
}
