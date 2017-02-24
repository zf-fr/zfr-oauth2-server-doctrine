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
use Doctrine\ORM\Persisters\Entity\EntityPersister;
use Doctrine\ORM\UnitOfWork;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use ZfrOAuth2\Server\Doctrine\Repository\ScopeRepository;
use ZfrOAuth2\Server\Model\Scope;
use ZfrOAuth2\Server\Repository\ScopeRepositoryInterface;

/**
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 *
 * @covers  ZfrOAuth2\Server\Doctrine\Repository\ScopeRepository
 */
class ScopeRepositoryTest extends TestCase
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
     * @var ScopeRepository
     */
    protected $repository;

    public function setUp()
    {
        $this->em         = $this->createMock(EntityManager::class, [], [], '', false);
        $this->meta       = $this->createMock(ClassMetadata::class, [], [], '', false);
        $this->repository = new ScopeRepository($this->em, $this->meta);
    }

    public function testHasInterface()
    {
        $this->assertInstanceOf(ScopeRepositoryInterface::class, $this->repository);
    }

    public function testSave()
    {
        $scope = $this->createMock(Scope::class, [], [], '', false);

        $this->em->expects($this->at(0))
            ->method('persist')
            ->with($scope);

        $this->em->expects($this->at(1))
            ->method('flush')
            ->with($scope);

        $returned = $this->repository->save($scope);

        $this->assertEquals($scope, $returned);
    }

    public function testFindAllScopes()
    {
        $unitOfWork = $this->createMock(UnitOfWork::class, [], [], '', false);
        $persister  = $this->createMock(EntityPersister::class, [], [], '', false);

        $unitOfWork->expects($this->at(0))
            ->method('getEntityPersister')
            ->willReturn($persister);

        $this->em->expects($this->at(0))
            ->method('getUnitOfWork')
            ->willReturn($unitOfWork);

        $persister->expects($this->once())
            ->method('loadAll')
            ->willReturn([]);

        $returned = $this->repository->findAllScopes();

        $this->assertEquals([], $returned);
    }

    public function testFindDefaultScopes()
    {
        $unitOfWork = $this->createMock(UnitOfWork::class, [], [], '', false);
        $persister  = $this->createMock(EntityPersister::class, [], [], '', false);

        $unitOfWork->expects($this->at(0))
            ->method('getEntityPersister')
            ->willReturn($persister);

        $this->em->expects($this->at(0))
            ->method('getUnitOfWork')
            ->willReturn($unitOfWork);

        $persister->expects($this->once())
            ->method('loadAll')
            ->willReturn([]);

        $returned = $this->repository->findDefaultScopes();

        $this->assertEquals([], $returned);
    }
}
