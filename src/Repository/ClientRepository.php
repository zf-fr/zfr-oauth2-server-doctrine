<?php

namespace ZfrOAuth2\Server\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use ZfrOAuth2\Server\Model\Client;
use ZfrOAuth2\Server\Repository\ClientRepositoryInterface;

class ClientRepository extends EntityRepository implements ClientRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function save(Client $client): Client
    {
        // not done
    }

    /**
     * @inheritdoc
     */
    public function findById(string $id)
    {
        // not done
    }
}
