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

    public function __construct()
    {
        parent::__construct();

        $this->default['hostname'] = env('DB_HOSTNAME', 'db');
        $this->default['database'] = env('DB_DATABASE', 'team_mgr');
        $this->default['username'] = env('DB_USERNAME', 'team_mgr');
        $this->default['password'] = env('DB_PASSWORD', '');
        $this->default['DBDriver'] = env('DB_DRIVER', 'MySQLi');
        $this->default['DBPrefix'] = env('DB_PREFIX', '');
        $this->default['port'] = (int) env('DB_PORT', 3306);
    }
}
