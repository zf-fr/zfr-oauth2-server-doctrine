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
use PHPUnit_Framework_MockObject_MockObject;
use ZfrOAuth2\Server\Doctrine\Repository\RefreshTokenRepository;
use ZfrOAuth2\Server\Model\AbstractToken;
use ZfrOAuth2\Server\Model\RefreshToken;
use ZfrOAuth2\Server\Repository\RefreshTokenRepositoryInterface;

/**
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 *
 * @covers  ZfrOAuth2\Server\Doctrine\Repository\RefreshTokenRepository
 */
class RefreshTokenRepositoryTest extends \PHPUnit_Framework_TestCase
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
     * @var RefreshTokenRepository
     */
    protected $repository;

    public function setUp()
    {
        $this->em         = $this->getMock(EntityManager::class, [], [], '', false);
        $this->meta       = $this->getMock(ClassMetadata::class, [], [], '', false);
        $this->repository = new RefreshTokenRepository($this->em, $this->meta);
    }

    public function testHasInterface()
    {
        $this->assertInstanceOf(RefreshTokenRepositoryInterface::class, $this->repository);
    }

    public function testSave()
    {
        $token = $this->getMock(RefreshToken::class, [], [], '', false);

        $this->em->expects($this->at(0))
            ->method('persist')
            ->with($token);

        $this->em->expects($this->at(1))
            ->method('flush')
            ->with($token);

        $returned = $this->repository->save($token);

        $this->assertEquals($token, $returned);
    }

    public function testFindByToken()
    {
        $this->em->expects($this->at(0))
            ->method('find')
            ->willReturn(null);

        $returned = $this->repository->findByToken('token');

        $this->assertEquals(null, $returned);
    }

    public function testDeleteToken()
    {
        $token = $this->getMock(AbstractToken::class, [], [], '', false);

        $this->em->expects($this->at(0))
            ->method('remove')
            ->with($token);

        $this->em->expects($this->at(1))
            ->method('flush')
            ->with($token);

        $this->repository->deleteToken($token);
    }

    public function testTokenExistsTrue()
    {
        $this->em->expects($this->at(0))
            ->method('find')
            ->willReturn($this->getMock(RefreshToken::class, [], [], '', false));

        $returned = $this->repository->tokenExists('token');

        $this->assertTrue($returned);
    }

    public function testTokenExistsFalse()
    {
        $this->em->expects($this->at(0))
            ->method('find')
            ->willReturn(null);

        $returned = $this->repository->tokenExists('token');

        $this->assertFalse($returned);
    }
}
