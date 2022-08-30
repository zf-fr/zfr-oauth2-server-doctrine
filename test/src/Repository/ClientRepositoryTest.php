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

namespace ZfrOAuth2Test\Server\Doctrine\Container;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ZfrOAuth2\Server\Doctrine\Repository\ClientRepository;
use ZfrOAuth2\Server\Model\Client;
use ZfrOAuth2\Server\Repository\ClientRepositoryInterface;

/**
 * @licence MIT
 * @covers  \ZfrOAuth2\Server\Doctrine\Repository\ClientRepository
 */
class ClientRepositoryTest extends TestCase
{
    /** @var EntityManager|MockObject */
    protected $em;

    /** @var ClassMetadata|MockObject */
    protected $meta;

    /** @var ClientRepository */
    protected $repository;

    public function setUp(): void
    {
        $this->em         = $this->createMock(EntityManager::class);
        $this->meta       = $this->createMock(ClassMetadata::class);
        $this->repository = new ClientRepository($this->em, $this->meta);
    }

    public function testHasInterface(): void
    {
        $this->assertInstanceOf(ClientRepositoryInterface::class, $this->repository);
    }

    public function testSave(): void
    {
        $client = $this->createMock(Client::class);

        $this->em->expects($this->once())
            ->method('persist')
            ->with($client);

        $this->em->expects($this->once())
            ->method('flush')
            ->with($client);

        $returned = $this->repository->save($client);

        $this->assertEquals($client, $returned);
    }

    public function testFindById(): void
    {
        $this->em->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $returned = $this->repository->findById('id');

        $this->assertEquals(null, $returned);
    }

    public function testIdExistsTrue(): void
    {
        $this->em->expects($this->once())
            ->method('find')
            ->willReturn($this->createMock(Client::class));

        $returned = $this->repository->idExists('id');

        $this->assertTrue($returned);
    }

    public function testIdExistsFalse(): void
    {
        $this->em->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $returned = $this->repository->idExists('id');

        $this->assertFalse($returned);
    }
}
