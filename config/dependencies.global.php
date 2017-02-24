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

use Doctrine\Common\Persistence\ManagerRegistry;
use ZfrOAuth2\Server\Doctrine\Container\AccessTokenRepositoryFactory;
use ZfrOAuth2\Server\Doctrine\Container\AuthorizationCodeRepositoryFactory;
use ZfrOAuth2\Server\Doctrine\Container\ClientRepositoryFactory;
use ZfrOAuth2\Server\Doctrine\Container\DoctrineOptionsFactory;
use ZfrOAuth2\Server\Doctrine\Container\RefreshTokenRepositoryFactory;
use ZfrOAuth2\Server\Doctrine\Container\ScopeRepositoryFactory;
use ZfrOAuth2\Server\Doctrine\Container\TokenOwnerPkColumnSubscriberFactory;
use ZfrOAuth2\Server\Doctrine\Options\DoctrineOptions;
use ZfrOAuth2\Server\Doctrine\Subscriber\TokenOwnerPkColumnSubscriber;
use ZfrOAuth2\Server\Repository\AccessTokenRepositoryInterface;
use ZfrOAuth2\Server\Repository\AuthorizationCodeRepositoryInterface;
use ZfrOAuth2\Server\Repository\ClientRepositoryInterface;
use ZfrOAuth2\Server\Repository\RefreshTokenRepositoryInterface;
use ZfrOAuth2\Server\Repository\ScopeRepositoryInterface;

return [
    'dependencies' => [
        'factories' => [
            /**
             * Repositories
             */
            AccessTokenRepositoryInterface::class       => AccessTokenRepositoryFactory::class,
            RefreshTokenRepositoryInterface::class      => RefreshTokenRepositoryFactory::class,
            AuthorizationCodeRepositoryInterface::class => AuthorizationCodeRepositoryFactory::class,
            ClientRepositoryInterface::class            => ClientRepositoryFactory::class,
            ScopeRepositoryInterface::class             => ScopeRepositoryFactory::class,

            /**
             * Utils
             */
            TokenOwnerPkColumnSubscriber::class         => TokenOwnerPkColumnSubscriberFactory::class,
            DoctrineOptions::class                      => DoctrineOptionsFactory::class,
            ManagerRegistry::class                      => My\ManagerRegistryFactory::class,
        ],
    ],
];
