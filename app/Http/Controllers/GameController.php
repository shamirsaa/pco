<?php

namespace App\Http\Controllers;

use App\integrations_service_manager;
// use App\Point;
use App\User;
use DB;
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
        ->Username($request->get('filter'))
        ->paginate($page)
         //->get()
        ;
        return $sm;
        //return response()->json($sm);
    }


    public static function getDataSMPrueba(Request $request)
    {
        // $sm = integrations_service_manager::selectRaw("users.name as username, 
        // sum(cerrados) as cerrados, 
        // ROUND((avg(cumplimiento)*100),2) as cumplimiento, 
        // max(integrations_service_manager.updated_at) as updated_at,
        // ROUND((avg(productividad)*100),2) as productividad, date_format(carga,'%Y-%m-%d') as carga")
        // ->whereRaw("carga='".date_format(now(),'Y-m-d 00:00:00')."' and users.name like "."'%".$request->get('username')."%' and goals.life >= now()")
        // ->join('users', 'users.username', '=', 'integrations_service_manager.cerrado_por')
        // ->join('goals', 'goals.name', '=', 'productividad')
        // ->orderBy('carga','desc')
        // ->orderBy('cerrados','desc')
        // ->groupBy('users.name', 'carga')
        // ->get()
        // ;
        $sm = DB::select("
            select 
            users.name as username, 
            goals.goal,
            sum(cerrados) as cerrados, 
            ROUND((avg(cumplimiento)*100),2) as cumplimiento, 
            max(integrations_service_manager.updated_at) as updated_at, 
            ROUND((avg(productividad)*100),2) as productividad, 
            date_format(carga,'%Y-%m-%d') as carga 
            from `integrations_service_manager` 
            inner join `users` on `users`.`username` = `integrations_service_manager`.`cerrado_por` 
            inner join `goals` on `goals`.`name` = 'productividad' 
            where carga='".date_format(now(),'Y-m-d 00:00:00')."'
            and users.name like "."'%".$request->get('username')."%' 
            and goals.life >= now() 
            group by users.name, `carga`, goals.goal 
            order by `carga` desc, `cerrados` desc
        ");
        return $sm;
 
    }
    
    

    public static function getUser(Request $request)
    {
        $user = User::where('username','=',$request->get('username'))->get();
        return $user;
 
    }

    public static function getDataSMChart(Request $request)
    {
        if($request->get('d')=='last'){

            switch ($request->get('date')){
                case '':
                    $date = 'carga ="'.date_format(now(),'Y-m-d 00:00:00').'"';
                break;
    
                case 'today':
                    $date = 'carga ="'.date_format(now(),'Y-m-d 00:00:00').'"';
                break;
               
                case 'month':
                     $date = "carga between '".gmdate('Y-m-d 00:00:00', strtotime('first day of -1 month'))."' and '".gmdate('Y-m-d 00:00:00', strtotime('last day of -1 month'))."'";
                break;
    
                case 'week':
                    $date = "carga between '".date('Y-m-d 00:00:00', strtotime("Monday last week".now()))."' and '".date('Y-m-d 00:00:00', strtotime("Sunday last week".now()))."'";
                break;
    
                case 'quarter':
                    $date = "carga between '".date('Y-m-d 00:00:00', strtotime('first day of last -2 month'.now()))."' and '".date('Y-m-d 00:00:00', strtotime('last day of last month'.now()))."'";
                break;
            }
        }else{
            switch ($request->get('date')){
                case '':
                    $date = 'carga ="'.date_format(now(),'Y-m-d 00:00:00').'"';
                break;
    
                case 'today':
                    $date = 'carga ="'.date_format(now(),'Y-m-d 00:00:00').'"';
                break;
               
                case 'month':
                    $date = "carga between '".gmdate('Y-m-d 00:00:00', strtotime('first day of this month'))."' and '".gmdate('Y-m-d 00:00:00', strtotime('last day of this month'))."'";
                break;
    
                case 'week':
                    $date = "carga between '".date('Y-m-d 00:00:00', strtotime("Monday this week".now()))."' and '".date('Y-m-d 00:00:00', strtotime("Sunday this week".now()))."'";
                break;
    
                case 'quarter':
                    $date = "carga between '".date('Y-m-d 00:00:00', strtotime('first day of -2 month'.now()))."' and '".date('Y-m-d 00:00:00', strtotime('last day of this month'.now()))."'";
                break;
            }
        }
        
        $sm = DB::select("
            select 
            users.name as username, 
            goals.goal,
            sum(cerrados) as cerrados, 
            ROUND((avg(cumplimiento)*100),2) as cumplimiento, 
            max(integrations_service_manager.updated_at) as updated_at, 
            ROUND((avg(productividad)*100),2) as productividad
            from `integrations_service_manager` 
            inner join `users` on `users`.`username` = `integrations_service_manager`.`cerrado_por` 
            inner join `goals` on `goals`.`name` = 'productividad' 
            where ".$date."
            and users.name like "."'%".$request->get('username')."%' 
            and goals.life >= now() 
            group by users.name,  goals.goal 
            order by  productividad desc
        ");
        return $sm;
    }

}
