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
namespace OAT\Library\CorrelationIds\Registry;

class CorrelationIdsRegistry implements CorrelationIdsRegistryInterface
{
    /** @var string */
    private $currentCorrelationId;

    /** @var string|null */
    private $parentCorrelationId;

    /** @var string|null */
    private $rootCorrelationId;

    public function __construct(
        string $currentCorrelationId,
        string $parentCorrelationId = null,
        string $rootCorrelationId = null
    ) {
        $this->currentCorrelationId = $currentCorrelationId;
        $this->parentCorrelationId = $parentCorrelationId;
        $this->rootCorrelationId = $rootCorrelationId;
    }

    public function getCurrentCorrelationId(): string
    {
        return $this->currentCorrelationId;
    }

    public function getParentCorrelationId(): ?string
    {
        return $this->parentCorrelationId;
    }

    public function getRootCorrelationId(): ?string
    {
        return $this->rootCorrelationId;
    }

    public function update(CorrelationIdsRegistryInterface $registry): CorrelationIdsRegistryInterface
    {
        $this->currentCorrelationId = $registry->getCurrentCorrelationId();
        $this->parentCorrelationId = $registry->getParentCorrelationId();
        $this->rootCorrelationId = $registry->getRootCorrelationId();

        return $this;
    }
}
