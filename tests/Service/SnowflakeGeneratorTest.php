<?php

namespace App\Tests\Service;

use App\Service\SnowflakeGenerator;
use PHPUnit\Framework\TestCase;

class SnowflakeGeneratorTest extends TestCase
{
    /**
     * @var SnowflakeGenerator
     */
    private $snowflake;

    public function setUp(): void{
        $this->snowflake = new SnowflakeGenerator;
    }

    public function testExplicitlyGeneratesId()
    {
        $id1 = $this->snowflake->getId();
        $id2 = $this->snowflake->getId();
        $id3 = $this->snowflake->new();

        $this->assertSame($id1, $id2);
        $this->assertNotSame($id1, $id3);
    }

    public function testInstanceToString()
    {
        $instance = $this->snowflake->getId();
        $string = (string) $this->snowflake;

        $this->assertSame($instance, $string);
    }
}
