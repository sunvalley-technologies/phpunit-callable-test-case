<?php

namespace SunValley\Tests\test;

use SunValley\Tests\CallableUtil\CallableTestCase;

class CallableTest extends CallableTestCase
{

    public function testCallableExactly()
    {
        /** @var callable $callable */
        $callable = $this->expectCallableOnceWith('test');
        $callable('test');
    }

    public function testCallableFails()
    {
        $this->expectCallableNever();
    }
}
