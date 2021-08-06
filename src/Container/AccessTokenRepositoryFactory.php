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

namespace ZfrOAuth2\Server\Doctrine\Container;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Container\ContainerInterface;
use ZfrOAuth2\Server\Doctrine\Repository;
use ZfrOAuth2\Server\Model\AccessToken;

/**
 * Class AccessTokenRepositoryFactory
 */
class AccessTokenRepositoryFactory
{
    public function __invoke(ContainerInterface $container): Repository\AccessTokenRepository
    {
        /** @var ManagerRegistry $managerRegistry */
        $managerRegistry = $container->get(ManagerRegistry::class);

        /** @var ObjectManager $objectManager */
        $objectManager = $managerRegistry->getManagerForClass(AccessToken::class);

        /** @var ClassMetadata $meta */
        $meta = $objectManager->getClassMetadata(AccessToken::class);

        return new Repository\AccessTokenRepository($objectManager, $meta);
    }
}
