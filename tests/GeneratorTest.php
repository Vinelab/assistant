<?php

namespace Vinelab\Assistant\tests;

use PHPUnit_Framework_TestCase as TestCase;
use Vinelab\Assistant\Generator;

class GeneratorTest extends TestCase
{
    public function testRandomId()
    {
        $g = new Generator();

        $generated = array();
        for ($i = 0; $i < 1000; ++$i) {
            $id = $g->randomId();

            $this->assertFalse(in_array($id, $generated), 'Make sure it is unique among the generated ones.');

            $generated[] = $id;

            $this->assertNotNull($id);
            $this->assertGreaterThan(0, $id);
            $this->assertLessThan(30, strlen($id), 'Make sure it does not exceed 30 characters');
            $this->assertGreaterThan(13, strlen($id), 'Make sure it is longer than what uniqid() provides');
        }
    }

    public function testUuid()
    {
        $g = new Generator();

        $generated = array();
        for ($i = 0; $i < 1000; ++$i) {
            $uuid = $g->uuid();
            $this->assertFalse(in_array($uuid, $generated), 'Make sure it is unique among the generated ones.');

            $generated[] = $uuid;

            $this->assertNotNull($uuid);
            $this->assertTrue((bool) preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid));
        }
    }
}
