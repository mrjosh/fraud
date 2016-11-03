<?php

namespace Josh\Fraud;

use Closure;
use Illuminate\Http\Request;

class FraudMiddleware extends BaseFraud
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        foreach ($this->methods() as $method){
            if($this->$method() === true) {
                return abort(403, 'Unauthorized action !');
            }
        }

        return $next($request);
    }
}
