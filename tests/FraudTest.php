<?php

use Illuminate\Http\Request;

/**
 * Fraud Middleware unit test
 *
 * @author Alireza Josheghani <a.josheghani@anetwork.ir>
 * @since  3 Nov 2016
 */

class FraudTest extends PHPUnit_Framework_TestCase
{
    /**
     * Set request of user
     *
     * @var object
     */
    protected $request = null;

    /**
     * FraudTest constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $request = new Request;

        $request->headers->replace([
            'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36'
        ]);

        $this->request = $request;
    }

    /**
     * Test user agent of user
     */
    public function testUserAgent()
    {
        $middleware = new Josh\Fraud\FraudMiddleware($this->request);

        $this->assertFalse($middleware->isUserAgent());

        $this->request->headers->replace([
            'user-agent' => '*****'
        ]);

        $middleware = new Josh\Fraud\FraudMiddleware($this->request);

        $this->assertTrue($middleware->isUserAgent());
    }

    /**
     * Test user is curl
     */
    public function testIsCurl()
    {
        $middleware = new Josh\Fraud\FraudMiddleware($this->request);

        $this->assertFalse($middleware->isCurl());

        $this->request->headers->replace([
            'user-agent' => 'curl/7.49.1'
        ]);

        $middleware = new Josh\Fraud\FraudMiddleware($this->request);

        $this->assertTrue($middleware->isCurl());
    }

    /**
     * Test user if httpie
     */
    public function testIsHttpie()
    {
        $middleware = new Josh\Fraud\FraudMiddleware($this->request);

        $this->assertFalse($middleware->isHttpie());

        $this->request->headers->replace([
            'user-agent' => 'HTTPie/0.9.4'
        ]);

        $middleware = new Josh\Fraud\FraudMiddleware($this->request);

        $this->assertTrue($middleware->isHttpie());
    }

    /**
     * Test user is Robot
     */
    public function testIsRobot()
    {
        $middleware = new Josh\Fraud\FraudMiddleware($this->request);

        $this->assertFalse($middleware->isRobot());

        $this->request->headers->replace([
            'user-agent' => 'crawler'
        ]);

        $middleware = new Josh\Fraud\FraudMiddleware($this->request);

        $this->assertTrue($middleware->isRobot());
    }

}