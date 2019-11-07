<?php declare(strict_types=1);
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2019 (original work) Open Assessment Technologies SA;
 */
namespace OAT\Library\CorrelationIds\Builder;

use OAT\Library\CorrelationIds\Generator\CorrelationIdGeneratorInterface;
use OAT\Library\CorrelationIds\Provider\CorrelationIdsHeaderNamesProvider;
use OAT\Library\CorrelationIds\Provider\CorrelationIdsHeaderNamesProviderInterface;
use OAT\Library\CorrelationIds\Registry\CorrelationIdsRegistry;
use OAT\Library\CorrelationIds\Registry\CorrelationIdsRegistryInterface;

class CorrelationIdsRegistryBuilder
{
    /** @var CorrelationIdGeneratorInterface */
    private $generator;

    /** @var CorrelationIdsHeaderNamesProviderInterface */
    private $provider;

    public function __construct(
        CorrelationIdGeneratorInterface $generator,
        CorrelationIdsHeaderNamesProviderInterface $provider = null
    ) {
        $this->generator = $generator;
        $this->provider = $provider ?? new CorrelationIdsHeaderNamesProvider();
    }

    public function build(string $parentCorrelationId = null, string $rootCorrelationId = null): CorrelationIdsRegistryInterface
    {
        return new CorrelationIdsRegistry(
            $this->generator->generate(),
            $parentCorrelationId,
            $rootCorrelationId
        );
    }

    public function buildFromRequestHeaders(array $requestHeaders): CorrelationIdsRegistryInterface
    {
        $sanitizedRequestHeaders = $this->sanitizeRequestHeaders($requestHeaders);

        return $this->build(
            $this->extractRequestHeader(
                $sanitizedRequestHeaders,
                $this->sanitize($this->provider->provideParentCorrelationIdHeaderName())
            ),
            $this->extractRequestHeader(
                $sanitizedRequestHeaders,
                $this->sanitize($this->provider->provideRootCorrelationIdHeaderName())
            )
        );
    }

    private function extractRequestHeader(array $requestHeaders, string $headerName): ?string
    {
        $value = $requestHeaders[$headerName] ?? null;

        return is_array($value) ? implode(',', $value) : $value;
    }

    private function sanitizeRequestHeaders(array $requestHeaders): array
    {
        $sanitizedRequestHeaders = [];

        foreach ($requestHeaders as $key => $value) {
            $sanitizedRequestHeaders[$this->sanitize($key)] = $value;
        }

        return $sanitizedRequestHeaders;
    }

    private function sanitize(string $value): string
    {
        return strtolower($value);
    }
}
