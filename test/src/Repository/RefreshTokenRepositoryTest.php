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

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ZfrOAuth2\Server\Doctrine\Repository\RefreshTokenRepository;
use ZfrOAuth2\Server\Model\AbstractToken;
use ZfrOAuth2\Server\Model\RefreshToken;
use ZfrOAuth2\Server\Repository\RefreshTokenRepositoryInterface;

/**
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 *
 * @covers  \ZfrOAuth2\Server\Doctrine\Repository\RefreshTokenRepository
 */
class RefreshTokenRepositoryTest extends TestCase
{
    /**
     * @var EntityManager|MockObject
     */
    protected $em;

    /**
     * @var ClassMetadata|MockObject
     */
    protected $meta;

    /**
     * @var RefreshTokenRepository
     */
    protected $repository;

    public function setUp(): void
    {
        $this->em         = $this->createMock(EntityManager::class);
        $this->meta       = $this->createMock(ClassMetadata::class);
        $this->repository = new RefreshTokenRepository($this->em, $this->meta);
    }

    public function testHasInterface(): void
    {
        $this->assertInstanceOf(RefreshTokenRepositoryInterface::class, $this->repository);
    }

    public function testSave(): void
    {
        $token = $this->createMock(RefreshToken::class);

        $this->em->expects($this->once())
            ->method('persist')
            ->with($token);

        $this->em->expects($this->once())
            ->method('flush')
            ->with($token);

        $returned = $this->repository->save($token);

        $this->assertEquals($token, $returned);
    }

    public function testFindByToken(): void
    {
        $this->em->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $returned = $this->repository->findByToken('token');

        $this->assertEquals(null, $returned);
    }

    public function testDeleteToken(): void
    {
        $token = $this->createMock(AbstractToken::class);

        $this->em->expects($this->once())
            ->method('remove')
            ->with($token);

        $this->em->expects($this->once())
            ->method('flush')
            ->with($token);

        $this->repository->deleteToken($token);
    }

    public function testPurgeExpired(): void
    {
        $qb = $this->createMock(QueryBuilder::class);
        $q  = $this->createMock(AbstractQuery::class);
        $this->em->expects($this->once())
            ->method('createQueryBuilder')
            ->willReturn($qb);

        $qb->expects($this->once())
            ->method('delete')
            ->with(RefreshToken::class, 'token')
            ->willReturn($qb);

        $qb->expects($this->once())
            ->method('where')
            ->with('token.expiresAt < :now')
            ->willReturn($qb);

        $qb->expects($this->once())
            ->method('setParameter')
            ->willReturn($qb);

        $qb->expects($this->once())
            ->method('getQuery')
            ->willReturn($q);

        $q->expects($this->once())
            ->method('execute');

        $this->repository->purgeExpiredTokens();
    }

    public function testTokenExistsTrue(): void
    {
        $this->em->expects($this->once())
            ->method('find')
            ->willReturn($this->createMock(RefreshToken::class));

        $returned = $this->repository->tokenExists('token');

        $this->assertTrue($returned);
    }

    public function testTokenExistsFalse(): void
    {
        $this->em->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $returned = $this->repository->tokenExists('token');

        $this->assertFalse($returned);
    }
}
