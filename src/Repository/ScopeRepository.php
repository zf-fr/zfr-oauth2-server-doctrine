<?php

namespace ZfrOAuth2\Server\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use ZfrOAuth2\Server\Model\Scope;
use ZfrOAuth2\Server\Repository\ScopeRepositoryInterface;

class ScopeRepository extends EntityRepository implements ScopeRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function save(Scope $scope): Scope
    {
        // not done
    }

    /**
     * @inheritdoc
     */
    public function findAllScopes(): array
    {
        // not done
    }

    /**
     * @inheritdoc
     */
    public function findDefaultScopes(): array
    {
        // not done
    }
}
