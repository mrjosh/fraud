<?php

/**
 * @author Alireza Josheghani <a.josheghani@anetwork.ir>
 * @since 28 Oct 2016
 *
 * BaseFraud middleware object
 */

namespace Josh\Fraud;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class BaseFraud
{
    /**
     * User agent
     *
     * @var string|array
     **/
    protected $agent;

    /**
     * check except methods in class
     *
     * @var array
     **/
    protected $except = [];

    /**
     * Bots list
     *
     * @var array
     */
    private $bots = [
        'crawler',
        'spider'
    ];

    /**
     * BaseFraud constructor.
     */
    public function __construct(Request $request)
    {
        // set user agent
        $this->agent = $request->header('user-agent');

        if(function_exists('config_path')) {

            // if exists bots file then include list
            if(file_exists(config_path('bots.php'))) {

                // require bots list
                $this->bots = include config_path('bots.php');
            }

        } else {
            $this->bots = include __DIR__ . '/../bots.php';
        }
    }

    /**
     * Check user agent has browser
     *
     * @return bool
     */
    public function isUserAgent()
    {
        $agent = new Agent;

        $agent->setUserAgent($this->agent);
        if(! $agent->browser() 
            || ! $agent->device()
            || ! $agent->platform($this->agent)
            || ! $agent->version($agent->browser())
            || ! $agent->version($agent->platform())
        ) {
            return true;
        }

        return false;
    }

    /**
     * Check user is curl
     *
     * @author Alireza Josheghani <a.josheghani@anetwork.ir>
     * @since  25 Oct , 2016
     * @return boolean
     */
    public function isCurl()
    {
        if(preg_match('/curl/', $this->agent)) {
            return true;
        }

        return false;
    }

    /**
     * Check user is httpie
     *
     * @author Alireza Josheghani <a.josheghani@anetwork.ir>
     * @since  27 Oct , 2016
     * @return boolean
     */
    public function isHttpie()
    {
        if(preg_match('/HTTPie/', $this->agent)) {
            return true;
        }

        return false;
    }

    /**
     * Check user is robot
     *
     * @author Alireza Josheghani <a.josheghani@anetwork.ir>
     * @since  25 Oct , 2016
     */
    public function isRobot()
    {
        foreach ($this->bots as $bot){
            if(preg_match('/' . $bot . '/', $this->agent)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check except methods array
     *
     * @author Alireza Josheghani <a.josheghani@anetwork.ir>
     * @since  28 Oct 2016
     * @param  $method
     * @return bool
     */
    public function checkExcept($method)
    {
        if(!empty($this->except)) {
            foreach ($this->except as $except){
                if($except === $method) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get all fraud methods
     *
     * @author Alireza Josheghani <a.josheghani@anetwork.ir>
     * @since  28 Oct 2016
     * @param  $class
     * @return array
     */
    public function methods()
    {
        $methods = get_class_methods($this);

        foreach ($methods as $key => $method){
            if(substr($method, 0, 2) !== 'is' || $this->checkExcept($method)) {
                unset($methods[$key]);
            }
        }

        return $methods;
    }

}