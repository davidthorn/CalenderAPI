<?php

namespace App\Http\Middleware;

use Closure;

class CheckCalenderEntryRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       
        $validator = validator()->make( $request->all()  , [ 'start' => 'required|date' , 'finish' => 'required|date'  , 'subject' => 'required|string|min:1|max:254']);

        if( $validator->fails() ){
            $errors = [ "errors" => $validator->errors() ];
            return response()->json( $errors , 400 );
            
        }

        //var_dump("came here");


        return $next($request);
    }
}
