<?php

namespace SunValley\Tests\CallableUtil;

use PHPUnit\Framework\MockObject\Matcher\Invocation;
use SunValley\LoopUtil\Common\Message\Exception\MessageException;

trait CallableTestTrait
{
    protected function expectCallableExactly($amount)
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->exactly($amount))
            ->method('__invoke');

        return $mock;
    }

    protected function expectCallableOnce()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke');

        return $mock;
    }

    protected function expectCallableOnceWith($value)
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($value);

        return $mock;
    }

    protected function expectCallableManyWithClass(string $class)
    {
        return $this->expectCallableWithClass($class, $this->atLeastOnce());
    }

    protected function expectCallableOnceWithClass(string $class)
    {
        return $this->expectCallableWithClass($class, $this->once());
    }

    protected function expectCallableWithClass(string $class, Invocation $times = null)
    {
        $times = $times ?? $this->any();

        $mock = $this->createCallableMock();
        $mock
            ->expects($times)
            ->method('__invoke')
            ->with(
                $this->callback(
                    function (object $e) use ($class) {
                        return $e instanceof $class;
                    }
                )
            );

        return $mock;
    }
    
    protected function expectCallableNever()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->never())
            ->method('__invoke');

        return $mock;
    }

    protected function createCallableMock()
    {
        return $this
            ->getMockBuilder(CallableStub::class)
            ->getMock();
    }


}