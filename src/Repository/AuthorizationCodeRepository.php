<?php

namespace ZfrOAuth2\Server\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use ZfrOAuth2\Server\Model\AbstractToken;
use ZfrOAuth2\Server\Model\AuthorizationCode;
use ZfrOAuth2\Server\Repository\AuthorizationCodeRepositoryInterface;

class AuthorizationCodeRepository extends EntityRepository implements AuthorizationCodeRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function save(AuthorizationCode $token): AuthorizationCode
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
