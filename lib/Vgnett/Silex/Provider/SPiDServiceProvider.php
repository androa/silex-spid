<?php

namespace Vgnett\Silex\Provider;

use Silex\Application,
    Silex\ServiceProviderInterface;

use VGS_Client;

class SPiDServiceProvider implements ServiceProviderInterface
{
    public function boot(Application $app) { }

    public function register(Application $app) {
        $app['spid.clientId']         = 'foobar';
        $app['spid.clientSecret']     = 'barfoo';
        $app['spid.clientSignSecret'] = 'barfoo';
        $app['spid.redirectUri']      = 'http://localhost/auth/login';
        $app['spid.domain']           = 'localhost';
        $app['spid.cookie']           = true;
        $app['spid.production']       = false;
        $app['spid.https']            = true;
        $app['spid.apiVersion']       = 2;

        $app["spid"] = $app->share(
            function (Application $app) {
                $client = new VGS_Client(array(
                    'client_id'     => $app['spid.clientId'],
                    'client_secret' => $app['spid.clientSecret'],
                    'sig_secret'    => $app['spid.clientSignSecret'],
                    'redirect_uri'  => $app['spid.redirectUri'],
                    'domain'        => $app['spid.domain'],
                    'cookie'        => $app['spid.cookie'],
                    'production'    => $app['spid.production'],
                    'https'         => $app['spid.https'],
                    'api_version'   => $app['spid.apiVersion']
                ));

                try {
                    $client->auth();
                } catch (\Exception $e) {
                    // The client is intact even if the auth fails
                    // handle error result in middleware/controllers
                }

                return $client;
            }
        );
    }
}
