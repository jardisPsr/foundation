# JardisPort Foundation

![Build Status](https://github.com/jardisport/foundation/actions/workflows/ci.yml/badge.svg)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.2-blue.svg)](https://www.php.net/)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-Level%208-success.svg)](phpstan.neon)
[![PSR-4](https://img.shields.io/badge/autoload-PSR--4-blue.svg)](https://www.php-fig.org/psr/psr-4/)
[![PSR-12](https://img.shields.io/badge/code%20style-PSR--12-orange.svg)](phpcs.xml)

**Interface library** providing domain foundation contracts for Domain-Driven Design (DDD) applications. This package contains strictly typed PHP 8.2+ interfaces defining the boundaries for bounded contexts and domain-level abstractions.

## Installation

```bash
composer require jardisport/foundation
```

## Requirements

- PHP >= 8.2
- jardisport/dbconnection ^1.0
- jardisport/factory ^1.0
- jardisport/messaging ^1.0
- psr/simple-cache ^3.0
- psr/log ^3.0

## Architecture Overview

This library provides the foundational contracts for implementing Domain-Driven Design patterns with a focus on type safety and clear separation of concerns.

### Core Interfaces (src/)

#### DomainKernelInterface
Central service container providing access to infrastructure components:
- **Path Resolution**: Application and domain root paths (`getAppRoot()`, `getDomainRoot()`)
- **Environment**: Configuration and environment variable access (`getEnv(?string $key)`)
- **Services**: Factory (`getFactory()`), Cache PSR-16 (`getCache()`), Logger PSR-3 (`getLogger()`)
- **Infrastructure**: Connection Pool (`getConnectionPool()`), Messaging (`getMessage()`)
- **Resource Registry**: External resource sharing via `ResourceRegistryInterface` (`getResources()`)

#### BoundedContextInterface
Generic type-safe use case executor:
```php
public function handle(string $className, mixed ...$parameters): mixed;
```
Instantiates and executes handlers within a bounded context, supporting dependency injection and flexible parameter passing.

#### ResponseInterface
Standardized response contract for bounded contexts:
- Message and error collection (recursive and non-recursive)
- Domain event tracking (`array<int, object>`)
- Nested sub-context response aggregation
- Success/failure state management
- Metadata summaries with full PHPStan Level 8 type coverage

#### ResourceRegistryInterface
External resource management for legacy integration:
- **Purpose**: Share existing connections (PDO, Redis, Kafka) with Foundation to avoid duplication
- **Operations**: `register()`, `has()`, `get()`, `unregister()`, `all()`
- **Key Conventions**:
  - Database: `connection.pdo.writer`, `connection.pdo.reader1`
  - Cache: `connection.redis.cache`
  - Messaging: `connection.redis.messaging`, `connection.kafka.producer`, `connection.amqp`
  - Logging: `logger.handler.{name}`
- **Use Case**: Legacy applications can inject existing infrastructure instances into DomainKernel, ensuring consistent state across old and new code

### Typical Application Flow

```
Request --> BoundedContext.handle(UseCase)
                  |
            Response with sub-contexts and events
                  |
            Infrastructure services accessed via DomainKernelInterface
```

## Development

All development commands run inside Docker containers for consistent environments.

### Available Commands

```bash
make install     # Install Composer dependencies
make update      # Update Composer dependencies
make autoload    # Regenerate autoload files
make phpstan     # Run PHPStan static analysis (Level 8)
make phpcs       # Run PHP_CodeSniffer (PSR-12)
make shell       # Access Docker container shell
make help        # Show all available commands
```

### Code Quality Standards

- **PHPStan Level 8** - Maximum strictness with full type coverage
- **PSR-12** coding standard with 120-character line limit
- **Strict types** required in all PHP files (`declare(strict_types=1)`)
- **Pre-commit hooks** validate branch naming and run phpcs on staged files

### Branch Naming Convention

Branches must follow this pattern:
```
(feature|fix|hotfix)/[1-7 digits]_[alphanumeric-_]+
```

Example: `feature/123_add-new-interface`

## License

MIT License - see [LICENSE](LICENSE) file for details.

## Support

- **Issues:** [GitHub Issues](https://github.com/JardisPort/foundation/issues)
- **Email:** jardisCore@headgent.dev

## Authors

Jardis Core Development
