<?php

namespace App\Http\Controllers\public_module;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrganizationChartController extends Controller
{
    
    public function stream()
    {
        // $week  = ['monday' => true, 'tuesday' => true, 'wednesday' => false, 'thursday' => false, 'friday' => false, 'saturday' => true, 'sunday' => true];
        $week  = [
            'monday' => ['work' => true, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']], 
            'tuesday' => ['work' => true, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']], 
            'wednesday' => ['work' => true, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']], 
            'thursday' => ['work' => true, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']], 
            'friday' => ['work' => true, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']], 
            'saturday' => ['work' => true, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']], 
            'sunday' => ['work' => false, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']]];
        
        $week_parse = [];

        // return $week;

        foreach($week as $week => $day){

            foreach($day as $key => $value){

                if($key == 'work'){

                    if($value){
                        $week_parse[$week][$key] = 'Ocupado';
                    }else{
                        $week_parse[$week][$key] = 'Libre';
                    }
                    
                }else{
                    $week_parse[$week][$key] = $value;
                }
            }

        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('organization_chart', ['week_parse' => $week_parse])->setPaper('a4', 'landscape')->save('organization_charts/organigrama.pdf');
        return $pdf->stream();
    }

    public function download()
    {
        // $week  = ['monday' => true, 'tuesday' => true, 'wednesday' => false, 'thursday' => false, 'friday' => false, 'saturday' => true, 'sunday' => true];
        $week  = [
            'monday' => ['work' => true, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']], 
            'tuesday' => ['work' => true, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']], 
            'wednesday' => ['work' => true, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']], 
            'thursday' => ['work' => true, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']], 
            'friday' => ['work' => true, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']], 
            'saturday' => ['work' => true, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']], 
            'sunday' => ['work' => false, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']]];
        
        $week_parse = [];

        // return $week;

        foreach($week as $week => $day){

            foreach($day as $key => $value){

                if($key == 'work'){

                    if($value){
                        $week_parse[$week][$key] = 'Ocupado';
                    }else{
                        $week_parse[$week][$key] = 'Libre';
                    }
                    
                }else{
                    $week_parse[$week][$key] = $value;
                }
            }

        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('organization_chart', ['week_parse' => $week_parse])->setPaper('a4', 'landscape');
        return $pdf->download('organigrama.pdf');
    }

    public function qrCode()
    {
         // $week  = ['monday' => true, 'tuesday' => true, 'wednesday' => false, 'thursday' => false, 'friday' => false, 'saturday' => true, 'sunday' => true];
         $week  = [
            'monday' => ['work' => true, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']], 
            'tuesday' => ['work' => true, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']], 
            'wednesday' => ['work' => true, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']], 
            'thursday' => ['work' => true, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']], 
            'friday' => ['work' => true, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']], 
            'saturday' => ['work' => true, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']], 
            'sunday' => ['work' => false, 'shift' => 'T1', 'time' => ['start_time' => '07:19', 'finish_time' => '19:00']]];
        
        $week_parse = [];

        // return $week;

        foreach($week as $week => $day){

            foreach($day as $key => $value){

                if($key == 'work'){

                    if($value){
                        $week_parse[$week][$key] = 'Ocupado';
                    }else{
                        $week_parse[$week][$key] = 'Libre';
                    }
                    
                }else{
                    $week_parse[$week][$key] = $value;
                }
            }

        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('organization_chart', ['week_parse' => $week_parse])->setPaper('a4', 'landscape')->save('organization_charts/organigrama.pdf');

        return QrCode::size(300)->generate("http://127.0.0.1:8000/organization_charts/organigrama.pdf");
    }
}
