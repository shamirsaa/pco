<?php

namespace App\Console;

use DB;
use App\integrations_service_manager;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->call(function () {
            $posts = DB::connection('sqlsrv')->table('CASOS_EBUSINESS')
            //->select('ID_ASIGNATARIO', DB::raw('count(NUMLLAMADA) as points'))
            //->select('ID_ASIGNATARIO, GRUPO,CERRADO_POR, NUMLLAMADA, NUMINCIDENTE, FECHA_APERTURA, FECHA_CIERRE,FECHA_ATENCION, FECHA_ANS')
            ->selectRaw("cerrado_por,
            SUM(case when CUMPLIO_ANS='SI' then 1 else 0 end)as cumplidos, 
            count(numllamada) as cerrados,  
            round((cast(sum(case when cumplio_ans='SI' then 1 else 0 end) as float)/cast(count(numllamada) as float)),4)as cumplimiento
            ")
            ->where('estado','=','Cerrado')
            ->whereBetween('FECHA_CIERRE', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
            //->whereBetween('FECHA_CIERRE', ['2019-12-01 00:00:00', '2019-12-01 23:59:59'])
            ->groupBy('CERRADO_POR')
            ->get();
    
            foreach($posts as $post)
            {
                integrations_service_manager::updateOrCreate(
                [
                    'cerrado_por'   => $post->cerrado_por, 
                    'carga'         => date_format(now(),'Y-m-d')
                ],
                [
                    'cumplidos'     => $post->cumplidos,
                    'cerrados'      => $post->cerrados,
                    'cumplimiento'  => $post->cumplimiento
                ]
            );
                // ->where('user_id', $post->ID_ASIGNATARIO)
                // ->update(['points' => $post->points]);
            }
        })->everyMinute();

        //-------- calculo de productividad ----//

        $schedule->call(function () {
            $results = integrations_service_manager::selectRaw("cerrado_por as username, carga
            , round((sum(cerrados)/10),4) as productividad")
            ->groupBy(['cerrado_por', 'carga'])
            ->get();
    
            foreach($results as $result)
            {
                integrations_service_manager::where('cerrado_por', $result->username)
                ->where('carga', "$result->carga") 
                ->update(['productividad' => $result->productividad]);
                // ->where('user_id', $post->ID_ASIGNATARIO)
                // ->update(['points' => $post->points]);
            }
        })->everyMinute();

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
