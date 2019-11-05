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
namespace OAT\Library\CorrelationIds\Provider;

class CorrelationIdsHeaderNamesProvider implements CorrelationIdsHeaderNamesProviderInterface
{
    /** @var string */
    private $currentCorrelationIdHeaderName;

    /** @var string */
    private $parentCorrelationIdHeaderName;

    /** @var string */
    private $rootCorrelationIdHeaderName;

    public function __construct(
        string $currentCorrelationIdHeaderName = null,
        string $parentCorrelationIdHeaderName= null,
        string $rootCorrelationIdHeaderName= null
    ) {
        $this->currentCorrelationIdHeaderName = $currentCorrelationIdHeaderName ?? self::DEFAULT_CURRENT_CORRELATION_ID_HEADER_NAME;
        $this->parentCorrelationIdHeaderName = $parentCorrelationIdHeaderName ?? self::DEFAULT_PARENT_CORRELATION_ID_HEADER_NAME;
        $this->rootCorrelationIdHeaderName = $rootCorrelationIdHeaderName ?? self::DEFAULT_ROOT_CORRELATION_ID_HEADER_NAME;
    }

    public function provideCurrentCorrelationIdHeaderName(): string
    {
        return $this->currentCorrelationIdHeaderName;
    }

    public function provideParentCorrelationIdHeaderName(): string
    {
        return $this->parentCorrelationIdHeaderName;
    }

    public function provideRootCorrelationIdHeaderName(): string
    {
        return $this->rootCorrelationIdHeaderName;
    }
}
