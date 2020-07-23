<?php

namespace App\Tests\Service;

use App\Service\SnowflakeGenerator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SnowflakeGeneratorTest extends KernelTestCase
{
    /**
     * @var SnowflakeGenerator
     */
    private $snowflake;

    public function setUp(): void{
        self::bootKernel();
        $this->snowflake = self::$container->get(SnowflakeGenerator::class);
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
