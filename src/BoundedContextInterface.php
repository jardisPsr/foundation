<?php

declare(strict_types=1);

namespace JardisPort\Foundation;

use Exception;

/**
 * Bounded Context interface for handling domain use cases.
 *
 * Executes use case handlers within a bounded context, providing a generic
 * interface for instantiating and executing domain logic with type safety.
 */
interface BoundedContextInterface
{
    /**
     * Handles a use case by instantiating and executing the specified class.
     *
     * @template T
     * @param class-string<T> $className The fully qualified class name of the use case handler
     * @return T|null The result of the use case execution, or null if no result
     * @throws Exception If the use case execution fails
     */
    public function handle(string $className, mixed ...$parameters): mixed;
}
