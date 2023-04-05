<?php

namespace SunValley\Tests\CallableUtil;


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

    /**
     * @param \PHPUnit\Framework\MockObject\Rule\InvocationOrder|\PHPUnit\Framework\MockObject\Matcher\Invocation $times
     */
    protected function expectCallableWithClass(string $class, object $times = null)
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
