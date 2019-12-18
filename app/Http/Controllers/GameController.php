<?php

namespace App\Http\Controllers;

use App\integrations_service_manager;
// use App\Point;
use App\User;
use Illuminate\Http\Request;
use UsersTableSeeder;

class GameController extends Controller
{
    // public static function getRanking($limitTopUsers = 20,Request $request)
    // {
    //     // DB::insert( DB::raw( "SET @row_number = 0") );
    //     // $rankinkg = DB::select("select * from (SELECT user_id, puntos, (@row_number:=@row_number + 1) AS num FROM (
    //     //     SELECT username as user_id, sum(points) as puntos FROM `points` group by username order by puntos desc) as tbl) as tbl2");
    //     $rankinkg = Point::filterdates($request->input('dates'))
    //     ->selectRaw('username as user_id,sum(points) as puntos')
    //     ->groupBy('user_id')
    //     ->orderBy('puntos','desc')
    //     ->get();
    //     return $rankinkg;
    // }

    public static function getDataSM(Request $request, $page=10)
    {
        // DB::insert( DB::raw( "SET @row_number = 0") );
        // $rankinkg = DB::select("select * from (SELECT user_id, puntos, (@row_number:=@row_number + 1) AS num FROM (
        //     SELECT username as user_id, sum(points) as puntos FROM `points` group by username order by puntos desc) as tbl) as tbl2");
        $sm = integrations_service_manager::selectRaw('cerrado_por as username, sum(cerrados) as cerrados, ROUND((avg(cumplimiento)*100),2) as cumplimiento, max(updated_at) as updated_at')
        //->where('carga','=',date_format(now(),'Y-m-d 00:00:00'))
        ->orderBy('cerrados','desc')
        ->groupBy('cerrado_por')
        //->get()
        ->paginate($page)
        ;
        return $sm;
        //return response()->json($sm);
    }


    public static function getDataSMPrueba(Request $request)
    {
        $sm = integrations_service_manager::selectRaw("name as username, 
        sum(cerrados) as cerrados, 
        ROUND((avg(cumplimiento)*100),2) as cumplimiento, 
        max(integrations_service_manager.updated_at) as updated_at,
        ROUND((avg(productividad)*100),2) as productividad, date_format(carga,'%Y-%m-%d') as carga")
        ->whereRaw("carga='".date_format(now(),'Y-m-d 00:00:00')."' and name like "."'%".$request->get('username')."%'")
        ->join('users', 'users.username', '=', 'integrations_service_manager.cerrado_por')
        ->orderBy('carga','desc')
        ->orderBy('cerrados','desc')
        ->groupBy('name', 'carga')
        ->get()
        ;
        // $sm = integrations_service_manager::selectRaw('cerrado_por as username, 
        // sum(cerrados) as cerrados, 
        // ROUND((avg(cumplimiento)*100),2) as cumplimiento, 
        // max(integrations_service_manager.updated_at) as updated_at,
        // ROUND((avg(productibidad)*100),2) as productibidad')
        // //->where('carga','=',date_format(now(),'Y-m-d 00:00:00'))
        // //->join('users', 'users.username', '=', 'integrations_service_manager.cerrado_por')
        // ->orderBy('cerrados','desc')
        // ->groupBy('cerrado_por')
        // ->get()
        // ;
        return $sm;
 
    }
    

    public static function getUser(Request $request)
    {
        $user = User::where('username','=',$request->get('username'))->get();
        return $user;
 
    }

}
