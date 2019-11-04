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
namespace OAT\Library\CorrelationIds\Tests\Unit\Registry;

use OAT\Library\CorrelationIds\Registry\CorrelationIdsRegistry;
use OAT\Library\CorrelationIds\Registry\CorrelationIdsRegistryInterface;
use PHPUnit\Framework\TestCase;

class CorrelationIdsRegistryTest extends TestCase
{
    public function testItImplementsCorrelationIdsRegistryInterface(): void
    {
        $this->assertInstanceOf(CorrelationIdsRegistryInterface::class, new CorrelationIdsRegistry(''));
    }

    public function testConstructorDefaults(): void
    {
        $subject = new CorrelationIdsRegistry('custom_current');

        $this->assertEquals('custom_current', $subject->getCurrentCorrelationId());
        $this->assertNull($subject->getParentCorrelationId());
        $this->assertNull($subject->getRootCorrelationId());
    }

    public function testConstructorWithCustomValues(): void
    {
        $subject = new CorrelationIdsRegistry('custom_current', 'custom_parent', 'custom_root');

        $this->assertEquals('custom_current', $subject->getCurrentCorrelationId());
        $this->assertEquals('custom_parent', $subject->getParentCorrelationId());
        $this->assertEquals('custom_root', $subject->getRootCorrelationId());
    }

    public function testItCanBeUpdatedFromAnotherCorrelationIdsRegistry(): void
    {
        $subject = new CorrelationIdsRegistry('old_current');

        $subject->update(new CorrelationIdsRegistry('new_current', 'new_parent', 'new_root'));

        $this->assertEquals('new_current', $subject->getCurrentCorrelationId());
        $this->assertEquals('new_parent', $subject->getParentCorrelationId());
        $this->assertEquals('new_root', $subject->getRootCorrelationId());
    }
}
