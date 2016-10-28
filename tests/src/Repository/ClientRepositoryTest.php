<?php
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
use Doctrine\ORM\Persisters\Entity\EntityPersister;
use Doctrine\ORM\UnitOfWork;
use PHPUnit_Framework_MockObject_MockObject;
use ZfrOAuth2\Server\Doctrine\Repository\ClientRepository;
use ZfrOAuth2\Server\Model\Client;
use ZfrOAuth2\Server\Repository\ClientRepositoryInterface;

/**
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 *
 * @covers  ZfrOAuth2\Server\Doctrine\Repository\ClientRepository
 */
class ClientRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManager|PHPUnit_Framework_MockObject_MockObject
     */
    protected $em;

    /**
     * @var ClassMetadata|PHPUnit_Framework_MockObject_MockObject
     */
    protected $meta;

    /**
     * @var ClientRepository
     */
    protected $repository;

    public function setUp()
    {
        $this->em         = $this->createMock(EntityManager::class, [], [], '', false);
        $this->meta       = $this->createMock(ClassMetadata::class, [], [], '', false);
        $this->repository = new ClientRepository($this->em, $this->meta);
    }

    public function testHasInterface()
    {
        $this->assertInstanceOf(ClientRepositoryInterface::class, $this->repository);
    }

    public function testSave()
    {
        $client = $this->createMock(Client::class, [], [], '', false);

        $this->em->expects($this->at(0))
            ->method('persist')
            ->with($client);

        $this->em->expects($this->at(1))
            ->method('flush')
            ->with($client);

        $returned = $this->repository->save($client);

        $this->assertEquals($client, $returned);
    }

    public function testFindById()
    {
        $this->em->expects($this->at(0))
            ->method('find')
            ->willReturn(null);

        $returned = $this->repository->findById('id');

        $this->assertEquals(null, $returned);
    }

    public function testIdExistsTrue()
    {
        $this->em->expects($this->at(0))
            ->method('find')
            ->willReturn($this->createMock(Client::class, [], [], '', false));

        $returned = $this->repository->idExists('id');

        $this->assertTrue($returned);
    }

    public function testIdExistsFalse()
    {
        $this->em->expects($this->at(0))
            ->method('find')
            ->willReturn(null);

        $returned = $this->repository->idExists('id');

        $this->assertFalse($returned);
    }
}
