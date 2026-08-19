<?php

namespace Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;
    public string $defaultGroup = 'default';

    public array $default = [
        'DSN'      => '',
        'hostname' => '',
        'username' => '',
        'password' => '',
        'database' => '',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => true,
        'charset'  => 'utf8mb4',
        'DBCollat' => 'utf8mb4_unicode_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];

    public array $tests = [
        'DSN'      => '',
        'hostname' => '',
        'username' => '',
        'password' => '',
        'database' => '',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => true,
        'charset'  => 'utf8mb4',
        'DBCollat' => 'utf8mb4_unicode_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];

    public function __construct()
    {
        parent::__construct();

        $this->default = $this->applyEnvironment($this->default);
        $this->tests = $this->applyEnvironment($this->tests);
    }

    private function applyEnvironment(array $connection): array
    {
        $connection['hostname'] = env('DB_HOSTNAME', 'db');
        $connection['database'] = env('DB_DATABASE', 'team_mgr');
        $connection['username'] = env('DB_USERNAME', 'team_mgr');
        $connection['password'] = env('DB_PASSWORD', '');
        $connection['DBDriver'] = env('DB_DRIVER', 'MySQLi');
        $connection['DBPrefix'] = env('DB_PREFIX', '');
        $connection['port'] = (int) env('DB_PORT', 3306);

        return $connection;
    }
}
