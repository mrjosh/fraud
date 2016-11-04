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
     * Make middleware instance
     *
     * @return \Josh\Fraud\FraudMiddleware
     */
    public function middleware()
    {
        return new Josh\Fraud\FraudMiddleware($this->request);
    }

    /**
     * Test user agent of user
     */
    public function testUserAgent()
    {
        $this->assertFalse($this->middleware()->isUserAgent());

        $this->request->headers->replace([ 'user-agent' => '' ]);

        $this->assertTrue($this->middleware()->isUserAgent());
    }

    /**
     * Test user is curl
     */
    public function testIsCurl()
    {
        $this->assertFalse($this->middleware()->isCurl());

        $this->request->headers->replace([ 'user-agent' => 'curl/7.49.1' ]);

        $this->assertTrue($this->middleware()->isCurl());
    }

    /**
     * Test user if httpie
     */
    public function testIsHttpie()
    {
        $this->assertFalse($this->middleware()->isHttpie());

        $this->request->headers->replace([ 'user-agent' => 'HTTPie/0.9.4' ]);

        $this->assertTrue($this->middleware()->isHttpie());
    }

    /**
     * Test user is Robot
     */
    public function testIsRobot()
    {
        $this->assertFalse($this->middleware()->isRobot());

        $this->request->headers->replace([ 'user-agent' => 'crawler' ]);

        $this->assertTrue($this->middleware()->isRobot());
    }

}