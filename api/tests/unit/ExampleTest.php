<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testExample() {
        $this->assertEquals(1, 1);
    }

    /**
     * @dataProvider someProvider
     */
    public function testExampleWithProvider($expected, $a, $b) {
        $this->assertSame($expected, $a + $b);
    }

    public function someProvider() {
        return [
            "One plus One"      => [2, 1, 1],
            "One plus Nine"     => [10, 1, 9],
            "Zero plus zero"    => [0, 0, 0]
        ];
    }
}