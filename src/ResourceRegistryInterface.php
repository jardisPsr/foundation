<?php

declare(strict_types=1);

namespace JardisPort\Foundation;

use RuntimeException;

/**
 * Resource Registry Interface
 *
 * Defines contract for managing external resources (connections, instances)
 * that should be reused instead of creating new ones.
 *
 * This interface allows legacy applications to share their existing database
 * connections, cache instances, and message broker clients with Foundation,
 * avoiding duplicate connections and ensuring consistent state.
 *
 * Resource Key Conventions:
 * ========================
 *
 * Database Connections:
 * - connection.pdo.writer          - PDO for write operations
 * - connection.pdo.reader1         - PDO for read operations (1-N)
 * - connection.pdo.reader2         - Additional read PDO
 *
 * Cache Connections:
 * - connection.redis.cache         - Redis instance for cache layer
 *
 * Messaging Connections:
 * - connection.redis.messaging     - Redis instance for messaging
 * - connection.kafka.producer      - RdKafka\Producer instance
 * - connection.kafka.consumer      - RdKafka\KafkaConsumer instance
 * - connection.amqp                - AMQPConnection instance
 *
 * Logger Handlers:
 * - logger.handler.{name}          - Pre-configured log handler
 *
 * Example Usage:
 * ==============
 *
 * ```php
 * // Register external resources
 * $registry = new ResourceRegistry();
 * $registry->register('connection.pdo.writer', $legacyPdo);
 * $registry->register('connection.redis.cache', $legacyRedis);
 *
 * // Pass to DomainKernel
 * $kernel = new DomainKernel($appRoot, $domainRoot, null, null, $registry);
 *
 * // Services automatically reuse external connections
 * $db = $kernel->getDatabase();      // Uses $legacyPdo
 * $cache = $kernel->getCache();      // Uses $legacyRedis
 * ```
 */
interface ResourceRegistryInterface
{
    /**
     * Register a resource by key
     *
     * @param string $key Resource identifier (e.g., 'connection.pdo.writer')
     * @param mixed $resource The resource instance (PDO, Redis, etc.)
     */
    public function register(string $key, mixed $resource): void;

    /**
     * Check if a resource exists
     *
     * @param string $key Resource identifier
     * @return bool True if resource is registered
     */
    public function has(string $key): bool;

    /**
     * Get a resource by key
     *
     * @param string $key Resource identifier
     * @return mixed The resource instance
     * @throws RuntimeException If resource not found
     */
    public function get(string $key): mixed;

    /**
     * Get all registered resources
     *
     * @return array<string, mixed> All registered resources
     */
    public function all(): array;

    /**
     * Remove a resource
     *
     * @param string $key Resource identifier
     */
    public function unregister(string $key): void;
}
