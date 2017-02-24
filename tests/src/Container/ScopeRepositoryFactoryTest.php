<?php

declare(strict_types=1);
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace ZfrOAuth2Test\Server\Container;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use ZfrOAuth2\Server\Doctrine\Container\ScopeRepositoryFactory;
use ZfrOAuth2\Server\Doctrine\Repository\ScopeRepository;
use ZfrOAuth2\Server\Model\Scope;

/**
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 * @covers  \ZfrOAuth2\Server\Doctrine\Container\ScopeRepositoryFactory
 */
class ScopeRepositoryFactoryTest extends TestCase
{
    public function testCanCreateFromFactory()
    {
        $container       = $this->createMock(ContainerInterface::class);
        $objectManager   = $this->createMock(ObjectManager::class);
        $managerRegistry = $this->createMock(ManagerRegistry::class, [], [], '', false);

        $objectManager->expects($this->at(0))
            ->method('getClassMetadata')
            ->with(Scope::class)
            ->willReturn($this->createMock(\Doctrine\ORM\Mapping\ClassMetadata::class, [], [], '', false));

        $managerRegistry->expects($this->once())
            ->method('getManagerForClass')
            ->with(Scope::class)
            ->willReturn($objectManager);

        $container->expects($this->at(0))
            ->method('get')
            ->with(ManagerRegistry::class)
            ->willReturn($managerRegistry);

        $factory = new ScopeRepositoryFactory();
        $service = $factory($container);

        $this->assertInstanceOf(ScopeRepository::class, $service);
    }
}
