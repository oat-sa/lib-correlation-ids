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
namespace OAT\Library\CorrelationIds\Tests\Unit\Builder;

use OAT\Library\CorrelationIds\Builder\CorrelationIdsRegistryBuilder;
use OAT\Library\CorrelationIds\Generator\CorrelationIdGeneratorInterface;
use OAT\Library\CorrelationIds\Provider\CorrelationIdsHeaderNamesProviderInterface;
use OAT\Library\CorrelationIds\Registry\CorrelationIdsRegistryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CorrelationIdsRegistryBuilderTest extends TestCase
{
    /** @var CorrelationIdGeneratorInterface|MockObject */
    private $generatorMock;

    /** @var CorrelationIdsHeaderNamesProviderInterface|MockObject */
    private $providerMock;

    /** @var CorrelationIdsRegistryBuilder */
    private $subject;

    protected function setUp(): void
    {
        $this->generatorMock = $this->createMock(CorrelationIdGeneratorInterface::class);
        $this->providerMock = $this->createMock(CorrelationIdsHeaderNamesProviderInterface::class);

        $this->subject = new CorrelationIdsRegistryBuilder($this->generatorMock, $this->providerMock);
    }

    public function testBuildFromRequestHeaders(): void
    {
        $this->generatorMock
            ->expects($this->once())
            ->method('generate')
            ->willReturn('current');

        $this->providerMock
            ->expects($this->once())
            ->method('provideParentCorrelationIdHeaderName')
            ->willReturn('parentHeaderName');

        $this->providerMock
            ->expects($this->once())
            ->method('provideRootCorrelationIdHeaderName')
            ->willReturn('rootHeaderName');

        $result = $this->subject->buildFromRequestHeaders([
            'parentHeaderName' => 'parent',
            'rootHeaderName' => ['root1', 'root2']
        ]);

        $this->assertInstanceOf(CorrelationIdsRegistryInterface::class, $result);
        $this->assertEquals('current', $result->getCurrentCorrelationId());
        $this->assertEquals('parent', $result->getParentCorrelationId());
        $this->assertEquals('root1,root2', $result->getRootCorrelationId());
    }

    public function testBuildFromRequestHeadersWithSanitization(): void
    {
        $this->generatorMock
            ->expects($this->once())
            ->method('generate')
            ->willReturn('current');

        $this->providerMock
            ->expects($this->once())
            ->method('provideParentCorrelationIdHeaderName')
            ->willReturn('parent-header-name');

        $this->providerMock
            ->expects($this->once())
            ->method('provideRootCorrelationIdHeaderName')
            ->willReturn('root-header-name');

        $result = $this->subject->buildFromRequestHeaders([
            'Parent-Header-Name' => 'parent',
            'Root-Header-Name' => ['root1', 'root2']
        ]);

        $this->assertInstanceOf(CorrelationIdsRegistryInterface::class, $result);
        $this->assertEquals('current', $result->getCurrentCorrelationId());
        $this->assertEquals('parent', $result->getParentCorrelationId());
        $this->assertEquals('root1,root2', $result->getRootCorrelationId());
    }
}
