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

namespace ZfrOAuth2Test\Server\Container;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use ZfrOAuth2\Server\Doctrine\Container\TokenOwnerPkColumnSubscriberFactory;
use ZfrOAuth2\Server\Doctrine\Options\DoctrineOptions;
use ZfrOAuth2\Server\Doctrine\Subscriber\TokenOwnerPkColumnSubscriber;

/**
 * @licence MIT
 * @covers  \ZfrOAuth2\Server\Doctrine\Container\TokenOwnerPkColumnSubscriberFactory
 */
class TokenOwnerPkColumnSubscriberFactoryTest extends TestCase
{
    public function testCanCreateFromFactory(): void
    {
        $container = $this->createMock(ContainerInterface::class);

        $container->expects($this->once())
            ->method('get')
            ->with(DoctrineOptions::class)
            ->willReturn($this->createMock(DoctrineOptions::class));

        $factory = new TokenOwnerPkColumnSubscriberFactory();
        $service = $factory($container);

        $this->assertInstanceOf(TokenOwnerPkColumnSubscriber::class, $service);
    }
}
