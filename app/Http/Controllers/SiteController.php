<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use DB;


class SiteController extends Controller
{
    //index
    public function index(){

        // $dataSite = Site::all();
        $dataSite = DB::select('
        select s.area
            from site s 
            join task t on t.site_id = s.id 
            group by s.area 
            order  by s.area');
                      
        $area = array();
        $area_str ="";
        foreach($dataSite as $i=>$val){
            $area[$i] = $val->area;

            // $area_l[$i] = "'".$val->area."'";
        }

        // get data by vendor
        $data_vendor = DB::select('
        select s.area , t.vendor, count(t.id) as jumlah_task
        from site s 
        join task t on t.site_id = s.id 
        group by t.vendor , s.area 
        order  by s.area');

        $dv_result= array();
        foreach($data_vendor as $j=>$dv){
            // $dv_val=0;
            $dv_result[$j] = 0;
            if($dv->vendor == "NE"){
                $dv_result[$j] = $dv->jumlah_task;
            }
        }
        
        $area_str = implode('#', $area);
        // dd($dv_result);
        
        $results = array("area"=>$area_str);

        return view('chart',$results);
    }
}
