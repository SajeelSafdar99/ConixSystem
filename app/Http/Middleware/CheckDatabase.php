<?php

namespace App\Http\Middleware;
use Session;
use Closure;

class CheckDatabase
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
        if($request->has('db_year')){
            Session::put('selected_database', trim($request->db_year));
        }

        if(Session::has('selected_database')){
            
            // \Config::set('database.connections.erp.database', trim(Session::get('selected_database')));           
            // echo \DB::connection()->getDatabaseName().'<br>';            
            // echo (Session::get('selected_database')).'<br>';
            \DB::purge('mysql');
            \DB::reconnect(Session::get('selected_database'));
            \DB::setDefaultConnection(Session::get('selected_database'));
            // echo \DB::connection()->getDatabaseName().'<br>';
            // echo (Session::get('selected_database')).'<br>';

        }
        return $next($request);
    }
}
