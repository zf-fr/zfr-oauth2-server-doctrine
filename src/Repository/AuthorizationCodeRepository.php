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

namespace ZfrOAuth2\Server\Doctrine\Repository;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityRepository;
use ZfrOAuth2\Server\Model\AbstractToken;
use ZfrOAuth2\Server\Model\AuthorizationCode;
use ZfrOAuth2\Server\Repository\AuthorizationCodeRepositoryInterface;

class AuthorizationCodeRepository extends EntityRepository implements AuthorizationCodeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function save(AuthorizationCode $token): AuthorizationCode
    {
        $this->_em->persist($token);
        $this->_em->flush($token);

        return $token;
    }

    /**
     * {@inheritdoc}
     */
    public function findByToken(string $token): ?AbstractToken
    {
        return $this->find($token);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteToken(AbstractToken $token): void
    {
        $this->_em->remove($token);
        $this->_em->flush($token);
    }

    /**
     * {@inheritdoc}
     */
    public function purgeExpiredTokens(): void
    {
        $this->_em->createQueryBuilder()
            ->delete(AuthorizationCode::class, 'token')
            ->where('token.expiresAt < :now')
            ->setParameter('now', new DateTime('now', new DateTimeZone('UTC')))
            ->getQuery()
            ->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function tokenExists(string $token): bool
    {
        return $this->find($token) !== null;
    }
}
