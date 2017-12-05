<?php

namespace Kreait\Tests\Firebase;

use Kreait\Firebase\Exception\InvalidArgumentException;
use Kreait\Firebase\ServiceAccount;
use Kreait\Tests\FirebaseTestCase;

class ServiceAccountTest extends FirebaseTestCase
{
    private $validJsonFile;
    private $invalidJsonFile;
    private $malformedJsonFile;
    private $symlinkedJsonFile;
    private $unreadableJsonFile;

    /**
     * @var ServiceAccount
     */
    private $serviceAccount;

    protected function setUp()
    {
        $this->validJsonFile = $this->fixturesDir.'/ServiceAccount/valid.json';
        $this->malformedJsonFile = $this->fixturesDir.'/ServiceAccount/malformed.json';
        $this->invalidJsonFile = $this->fixturesDir.'/ServiceAccount/invalid.json';
        $this->symlinkedJsonFile = $this->fixturesDir.'/ServiceAccount/symlinked.json';
        $this->unreadableJsonFile = $this->fixturesDir.'/ServiceAccount/unreadable.json';

        @chmod($this->unreadableJsonFile, 0000);

        $this->serviceAccount = ServiceAccount::fromValue($this->validJsonFile);
    }

    protected function tearDown()
    {
        @chmod($this->unreadableJsonFile, 0644);
    }

    public function testGetters()
    {
        $data = json_decode(file_get_contents($this->validJsonFile), true);

        $this->assertSame($data['project_id'], $this->serviceAccount->getProjectId());
        $this->assertSame($data['client_id'], $this->serviceAccount->getClientId());
        $this->assertSame($data['client_email'], $this->serviceAccount->getClientEmail());
        $this->assertSame($data['private_key'], $this->serviceAccount->getPrivateKey());
    }

    public function testCreateFromJsonText()
    {
        $this->assertInstanceOf(
            ServiceAccount::class,
            ServiceAccount::fromValue(file_get_contents($this->validJsonFile))
        );
    }

    public function testCreateFromJsonFile()
    {
        $this->assertInstanceOf(ServiceAccount::class, ServiceAccount::fromValue($this->validJsonFile));
    }

    public function testCreateFromSymlinkedJsonFile()
    {
        $this->assertInstanceOf(ServiceAccount::class, ServiceAccount::fromValue($this->symlinkedJsonFile));
    }

    public function testCreateFromMissingFile()
    {
        $this->expectException(InvalidArgumentException::class);
        ServiceAccount::fromValue('missing.json');
    }

    public function testCreateFromMalformedJsonFile()
    {
        $this->expectException(InvalidArgumentException::class);
        ServiceAccount::fromValue($this->malformedJsonFile);
    }

    public function testCreateFromInvalidJsonFile()
    {
        $this->expectException(InvalidArgumentException::class);
        ServiceAccount::fromValue($this->invalidJsonFile);
    }

    public function testCreateFromDirectory()
    {
        $this->expectException(InvalidArgumentException::class);
        ServiceAccount::fromValue(__DIR__);
    }

    public function testCreateFromUnreadableFile()
    {
        $this->expectException(InvalidArgumentException::class);
        ServiceAccount::fromValue($this->unreadableJsonFile);
    }

    public function testCreateFromArray()
    {
        $data = json_decode(file_get_contents($this->validJsonFile), true);

        $this->assertInstanceOf(ServiceAccount::class, ServiceAccount::fromValue($data));
    }

    public function testCreateFromServiceAccount()
    {
        $serviceAccount = $this->createMock(ServiceAccount::class);

        $this->assertSame($serviceAccount, ServiceAccount::fromValue($serviceAccount));
    }

    public function testCreateFromInvalidValue()
    {
        $this->expectException(InvalidArgumentException::class);
        ServiceAccount::fromValue(false);
    }

    public function testCreateWithInvalidClientEmail()
    {
        $this->expectException(InvalidArgumentException::class);

        (new ServiceAccount())->withClientEmail('foo');
    }

    public function testWithCustomDiscoverer()
    {
        $discoverer = $this->createMock(ServiceAccount\Discoverer::class);
        $discoverer->expects($this->once())
            ->method('discover');

        ServiceAccount::discover($discoverer);
    }
}
