<?php

namespace ZfrOAuth2\Server\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use ZfrOAuth2\Server\Model\AbstractToken;
use ZfrOAuth2\Server\Model\RefreshToken;
use ZfrOAuth2\Server\Repository\RefreshTokenRepositoryInterface;

class RefreshTokenRepository extends EntityRepository implements RefreshTokenRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function save(RefreshToken $token): RefreshToken
    {
        // not done
    }

    /**
     * @inheritdoc
     */
    public function findByToken(string $token)
    {
        // not done
    }

    /**
     * @inheritdoc
     */
    public function deleteToken(AbstractToken $token)
    {
        // not done
    }

    /**
     * @inheritdoc
     */
    public function tokenExists(string $token): bool
    {
        // not done
    }
}
