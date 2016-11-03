<?php

namespace Josh\Fraud;

use Closure;
use Illuminate\Http\Request;

class FraudMiddleware extends BaseFraud
{
    /**
     * Set except check methods in class
     *
     * @var array
     **/
    protected $except = [];

    /**
     * FraudMiddleware constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        // call parent construct
        parent::__construct();

        // set user agent
        $this->agent = $request->header('user-agent');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        foreach ($this->methods($this) as $method){
            if($this->$method() === true) {
                return abort(403, 'Unauthorized action !');
            }
        }

        return $next($request);
    }
}
