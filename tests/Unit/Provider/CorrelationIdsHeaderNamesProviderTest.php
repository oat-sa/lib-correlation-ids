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
namespace OAT\Library\CorrelationIds\Tests\Unit\Provider;

use OAT\Library\CorrelationIds\Provider\CorrelationIdsHeaderNamesProvider;
use OAT\Library\CorrelationIds\Provider\CorrelationIdsHeaderNamesProviderInterface;
use PHPUnit\Framework\TestCase;

class CorrelationIdsHeadersNameProviderTest extends TestCase
{
    public function testItImplementsCorrelationIdsHeaderNamesProviderInterface(): void
    {
        $this->assertInstanceOf(CorrelationIdsHeaderNamesProviderInterface::class, new CorrelationIdsHeaderNamesProvider());
    }

    public function testItProvidesTheCorrelationIdsHeaderNamesProviderInterfaceNamesByDefault(): void
    {
        $subject = new CorrelationIdsHeaderNamesProvider();

        $this->assertEquals(
            CorrelationIdsHeaderNamesProviderInterface::DEFAULT_CURRENT_CORRELATION_ID_HEADER_NAME,
            $subject->provideCurrentCorrelationIdHeaderName()
        );

        $this->assertEquals(
            CorrelationIdsHeaderNamesProviderInterface::DEFAULT_PARENT_CORRELATION_ID_HEADER_NAME,
            $subject->provideParentCorrelationIdHeaderName()
        );

        $this->assertEquals(
            CorrelationIdsHeaderNamesProviderInterface::DEFAULT_ROOT_CORRELATION_ID_HEADER_NAME,
            $subject->provideRootCorrelationIdHeaderName()
        );
    }

    public function testItCanProvideCustomHeaderNames(): void
    {
        $subject = new CorrelationIdsHeaderNamesProvider('custom_current', 'custom_parent', 'custom_root');

        $this->assertEquals('custom_current', $subject->provideCurrentCorrelationIdHeaderName());
        $this->assertEquals('custom_parent', $subject->provideParentCorrelationIdHeaderName());
        $this->assertEquals('custom_root', $subject->provideRootCorrelationIdHeaderName());
    }
}
