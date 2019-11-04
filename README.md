# Correlation Ids Library

> PHP library for correlation ids management.

## Table of contents
- [Installation](#installation)
- [Principles](#principles)
- [Usage](#usage)
- [Tests](#tests)

## Installation

```console
$ composer require oat-sa/lib-correlation-ids
```

## Principles

This library provides an [interface](./src/Registry/CorrelationIdsRegistryInterface.php) that will allow access to 3 kind of correlation ids:

- `getCurrentCorrelationId()`: for the current application process.
- `getParentCorrelationId()`: for the parent application that calls your application, if any.
- `getRootCorrelationId()`: for the root application from which all the calls originate in the first place.

Example:
```
 Request
    |
    v
+---------------+  current: xxx
| Application A |  parent: NULL
+---+-----------+  root: NULL
    |
    v
+---------------+  current: yyy
| Application B |  parent: xxx
+---+-----------+  root: xxx
    |
    v
+---------------+  current: zzz
| Application C |  parent: yyy
+---------------+  root: xxx
```

## Usage

### From HTTP context

```php
<?php declare(strict_types=1);

use Psr\Http\Message\RequestInterface;
use OAT\Library\CorrelationIds\Builder\CorrelationIdsRegistryBuilder;
use OAT\Library\CorrelationIds\Generator\CorrelationIdGenerator;

$builder = new CorrelationIdsRegistryBuilder(new CorrelationIdGenerator());

/** @var RequestInterface $request */
$registry = $builder->buildFromRequestHeaders($request->getHeaders());

...

$registry->getCurrentCorrelationId(); // current correlation id
$registry->getParentCorrelationId();  // parent correlation id (nullable)
$registry->getRootCorrelationId();    // root correlation id (nullable)
```
**Note**: you can customize the used HTTP headers names by providing you own [CorrelationIdsHeaderNamesProviderInterface](./src/Provider/CorrelationIdsHeaderNamesProviderInterface.php) implementation and pass it to the `CorrelationIdsRegistryBuilder` constructor.

### Manually

```php
<?php declare(strict_types=1);

use OAT\Library\CorrelationIds\Builder\CorrelationIdsRegistryBuilder;
use OAT\Library\CorrelationIds\Generator\CorrelationIdGenerator;

$builder = new CorrelationIdsRegistryBuilder(new CorrelationIdGenerator());

$registry = $builder->build(
    'parentCorrelationId', // optional
    'rootCorrelationId'    // optional
);
```

## Tests

To run tests:
```console
$ vendor/bin/phpunit
```
**Note**: see [phpunit.xml.dist](phpunit.xml.dist) for available test suites.