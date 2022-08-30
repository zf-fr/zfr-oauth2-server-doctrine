<?php

declare(strict_types=1);

namespace ZfrOAuth2\Server\Doctrine\Subscriber;

use Doctrine\Common\EventSubscriber as EventSubscriberInterface;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use ZfrOAuth2\Server\Doctrine\Options\DoctrineOptions;
use ZfrOAuth2\Server\Model\AbstractToken;

class TokenOwnerPkColumnSubscriber implements EventSubscriberInterface
{
    /** @var DoctrineOptions */
    protected $options;

    public function __construct(DoctrineOptions $options)
    {
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        /** @var ClassMetadataInfo $metadata */
        $metadata = $eventArgs->getClassMetadata();

        if ($metadata->getName() !== AbstractToken::class) {
            return;
        }

        $metadata->associationMappings['owner']['joinColumns'][0]['referencedColumnName'] = $this
            ->options
            ->getTokenOwnerPkColumn();
    }
}
