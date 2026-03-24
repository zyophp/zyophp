<?php

namespace Tests\Framework\Core;

use PHPUnit\Framework\TestCase;
use Zyo\Core\Container;
use stdClass;
use Exception;

class ContainerTest extends TestCase
{
    protected Container $container;

    protected function setUp(): void
    {
        $this->container = new Container();
    }

    public function test_it_can_bind_and_resolve_a_closure(): void
    {
        $this->container->bind('test', fn() => 'bar');
        $this->assertEquals('bar', $this->container->get('test'));
    }

    public function test_it_can_bind_without_concrete_specified(): void
    {
        $this->container->bind(StubDependency::class);
        $this->assertInstanceOf(StubDependency::class, $this->container->get(StubDependency::class));
    }

    public function test_it_can_register_a_singleton(): void
    {
        $this->container->singleton('singleton', fn() => new stdClass());
        
        $instance1 = $this->container->get('singleton');
        $instance2 = $this->container->get('singleton');

        $this->assertSame($instance1, $instance2);
    }

    public function test_it_can_auto_wire_dependencies_using_reflection(): void
    {
        $target = $this->container->build(StubTarget::class);

        $this->assertInstanceOf(StubTarget::class, $target);
        $this->assertInstanceOf(StubDependency::class, $target->dep);
    }

    public function test_it_throws_exception_for_unresolvable_class(): void
    {
        $this->expectException(Exception::class);
        $this->container->get('NonExistentClass');
    }

    public function test_it_throws_exception_on_circular_dependency(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Circular dependency detected');

        $this->container->build(CircularA::class);
    }

    public function test_it_handles_default_values_in_constructor(): void
    {
        $instance = $this->container->build(ClassWithDefault::class);
        $this->assertEquals('Zyo', $instance->name);
    }

    public function test_it_fails_to_instantiate_interfaces_or_abstract_classes_not_bound(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('is not instantiable');

        $this->container->build(AbstractClassStub::class);
    }

    public function test_it_throws_exception_for_unresolvable_primitive_dependency(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unresolvable dependency');

        $this->container->build(StubWithPrimitive::class);
    }

    public function test_it_can_resolve_recursive_bindings(): void
    {
        $this->container->bind('a', 'b');
        $this->container->bind('b', 'c');
        $this->container->bind('c', StubDependency::class);

        $this->assertInstanceOf(StubDependency::class, $this->container->get('a'));
    }

    public function test_it_can_resolve_nested_shared_bindings(): void
    {
        // Vincula a classe em si como singleton para que o autowire a utilize
        $this->container->singleton(StubDependency::class, function() {
            return new StubDependency();
        });
        
        $this->container->bind('target', StubTarget::class);

        $target1 = $this->container->get('target');
        $target2 = $this->container->get('target');

        $this->assertNotSame($target1, $target2);
        $this->assertSame($target1->dep, $target2->dep);
    }
}

class StubDependency {}
class StubTarget {
    public function __construct(public StubDependency $dep) {}
}

class CircularA {
    public function __construct(public CircularB $b) {}
}
class CircularB {
    public function __construct(public CircularA $a) {}
}

class ClassWithDefault {
    public function __construct(public string $name = 'Zyo') {}
}

abstract class AbstractClassStub {}

class StubWithPrimitive {
    public function __construct(int $id) {}
}