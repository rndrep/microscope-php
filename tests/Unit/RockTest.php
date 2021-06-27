<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use App\Models\Rock;
use Tests\TestCase;

class RockTest extends TestCase
{
    public function testPublic()
    {
        /** Rock */
        $rock = new Rock();
        $this->assertTrue(empty($rock->isPublic()));
        $rock->toggleStatus(1);
        $this->assertEquals(1, $rock->isPublic());
    }

}
