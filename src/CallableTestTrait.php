<?php

namespace SunValley\Tests\CallableUtil;

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

    protected function expectCallableOnceWithException(string $class)
    {
        if (!is_a($class, \Throwable::class, true)) {
            throw new \InvalidArgumentException('Requires an exception');
        }

        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with(
                $this->callback(
                    function (\Throwable $e) use($class) {
                        $check = $e instanceof $class;
                        $this->assertTrue($check, $check ? '' : $e);
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