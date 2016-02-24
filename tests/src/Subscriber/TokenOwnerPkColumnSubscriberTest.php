<?php
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

namespace ZfrOAuth2Test\Server\Doctrine\Container;

use Doctrine\Common\EventSubscriber as EventSubscriberInterface;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use ZfrOAuth2\Server\Doctrine\Options\DoctrineOptions;
use ZfrOAuth2\Server\Doctrine\Subscriber\TokenOwnerPkColumnSubscriber;
use ZfrOAuth2\Server\Model\AbstractToken;

/**
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 *
 * @covers  ZfrOAuth2\Server\Doctrine\Subscriber\TokenOwnerPkColumnSubscriber
 */
class TokenOwnerPkColumnSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DoctrineOptions
     */
    protected $options;

    /**
     * @var TokenOwnerPkColumnSubscriber
     */
    protected $subscriber;

    public function setUp()
    {
        $this->options    = new DoctrineOptions();
        $this->subscriber = new TokenOwnerPkColumnSubscriber($this->options);
    }

    public function testHasInterface()
    {
        $this->assertInstanceOf(EventSubscriberInterface::class, $this->subscriber);
    }

    public function testSubscribedEvents()
    {
        $this->assertContains(Events::loadClassMetadata, $this->subscriber->getSubscribedEvents());
    }

    /**
     * @dataProvider providerLoadClassMetadata
     */
    public function testLoadClassMetadata($className, $columnName)
    {
        $eventsArgs    = $this->getMock(LoadClassMetadataEventArgs::class, [], [], '', false);
        $classMetaData = $this->getMock(ClassMetadataInfo::class, [], [], '', false);;

        $classMetaData->expects($this->once())
            ->method('getName')
            ->willReturn($className);

        $eventsArgs->expects($this->once())
            ->method('getClassMetadata')
            ->willReturn($classMetaData);

        if ($columnName) {
            $this->options->setTokenOwnerPkColumn($columnName);
        }

        $this->subscriber->loadClassMetadata($eventsArgs);

        if ($columnName) {
            $this->assertEquals($columnName,
                $classMetaData->associationMappings['owner']['joinColumns'][0]['referencedColumnName']);
        }
    }

    public function providerLoadClassMetadata()
    {
        return [
            [AbstractToken::class, 'user_id'],
            ['Some\Entity\Foo', false],
        ];
    }
}
