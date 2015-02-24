<?php
namespace Vgno\Silex\Provider;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use VGS_Client;
use Vgno\Silex\Provider\SPiDServiceProvider;

class SPiDServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!class_exists('\VGS_Client')) {
            $this->markTestSkipped('VGS_Client was not installed.');
        }
    }

    public function testRegister()
    {
        $spidConfig = array(
            'spid.clientId'         => 'foobar',
            'spid.clientSecret'     => 'barfoo',
            'spid.clientSignSecret' => 'foobarsecret',
            'spid.redirectUri'      => 'http://example.com/auth/login',
            'spid.domain'           => 'example.com',
            'spid.cookie'           => false,
            'spid.production'       => false,
            'spid.https'            => false,
            'spid.apiVersion'       => 5
        );

        $app = new Application();

        $app->register(new SPiDServiceProvider(), $spidConfig);

        $app->get('/', function() use ($app) {
            $app['spid'];
        });

        $request = Request::create('/');
        $app->handle($request);

        $this->assertTrue($app['spid'] instanceof \VGS_Client);
        $this->assertSame($spidConfig['spid.clientId'], $app['spid']->getClientId());
        $this->assertSame($spidConfig['spid.clientSecret'], $app['spid']->getClientSecret());
        $this->assertSame($spidConfig['spid.clientSignSecret'], $app['spid']->getClientSignSecret());
        $this->assertSame($spidConfig['spid.redirectUri'], $app['spid']->getRedirectUri());
        $this->assertSame($spidConfig['spid.domain'], $app['spid']->getBaseDomain());
        $this->assertSame($spidConfig['spid.cookie'], $app['spid']->useCookieSupport());
        $this->assertSame($spidConfig['spid.production'], $app['spid']->isLive());
        $this->assertSame(substr($app['spid']->getServerURL(), 0, 5), 'http:');
    }
}
