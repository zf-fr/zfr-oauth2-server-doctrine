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
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use ZfrOAuth2\Server\Doctrine\Container\ClientRepositoryFactory;
use ZfrOAuth2\Server\Doctrine\Repository\ClientRepository;
use ZfrOAuth2\Server\Model\Client;

/**
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 * @covers  \ZfrOAuth2\Server\Doctrine\Container\ClientRepositoryFactory
 */
class ClientRepositoryFactoryTest extends TestCase
{
    public function testCanCreateFromFactory(): void
    {
        $container       = $this->createMock(ContainerInterface::class);
        $objectManager   = $this->createMock(EntityManagerInterface::class);
        $managerRegistry = $this->createMock(ManagerRegistry::class);

        $objectManager->expects($this->at(0))
            ->method('getClassMetadata')
            ->with(Client::class)
            ->willReturn($this->createMock(\Doctrine\ORM\Mapping\ClassMetadata::class));

        $managerRegistry->expects($this->once())
            ->method('getManagerForClass')
            ->with(Client::class)
            ->willReturn($objectManager);

        $container->expects($this->at(0))
            ->method('get')
            ->with(ManagerRegistry::class)
            ->willReturn($managerRegistry);

        $factory = new ClientRepositoryFactory();
        $service = $factory($container);

        $this->assertInstanceOf(ClientRepository::class, $service);
    }
}
