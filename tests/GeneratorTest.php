<?php

namespace Vinelab\Assistant\tests;

use PHPUnit_Framework_TestCase as TestCase;
use Vinelab\Assistant\Generator;

class GeneratorTest extends TestCase
{
    public function test_uid()
    {
        $g = new Generator();

        for ($i = 0; $i < 1000; ++$i) {
            $uid = $g->uid();

            $this->assertNotNull($uid);
            $this->assertGreaterThan(0, $uid);
            $this->assertLessThan(30, strlen($uid), 'Make sure it does not exceed 30 characters');
            $this->assertGreaterThan(13, strlen($uid), 'Make sure it is longer than what uniqid() provides');
        }
    }
}
