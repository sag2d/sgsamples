<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use Config\Database;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Database::class)]
final class DatabaseConfigTest extends CIUnitTestCase
{
    public function testDefaultConnectionUsesPortableUtf8mb4Collation(): void
    {
        $config = new Database();

        $this->assertSame('utf8mb4', $config->default['charset']);
        $this->assertSame('utf8mb4_unicode_ci', $config->default['DBCollat']);
    }

    public function testDefaultConnectionReadsDbEnvironmentDefaults(): void
    {
        $config = new Database();

        $this->assertSame(env('DB_HOSTNAME', 'db'), $config->default['hostname']);
        $this->assertSame(env('DB_DATABASE', 'team_mgr'), $config->default['database']);
        $this->assertSame(env('DB_DRIVER', 'MySQLi'), $config->default['DBDriver']);
    }
}
