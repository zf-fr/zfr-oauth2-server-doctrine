<?php

namespace ZfrOAuth2\Server\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use ZfrOAuth2\Server\Model\AbstractToken;
use ZfrOAuth2\Server\Model\AccessToken;
use ZfrOAuth2\Server\Repository\AccessTokenRepositoryInterface;

class AccessTokenRepository extends EntityRepository implements AccessTokenRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function save(AccessToken $token): AccessToken
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
