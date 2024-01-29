<?php

namespace App\Http\Controllers;
use App\Models\Post;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class MasterApi extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }

    public function hotel(Request $r)
    {
        $p= $r['p'] ? $r['p'] : 10;
/*
        [LV_MSHotel]
        @cari nvarchar(2500), 
        @country nvarchar(50),
        @state nvarchar(50),
        @city nvarchar(50),
        @area nvarchar(max),
        @rateOffice nvarchar(10),
        @rateHotel nvarchar(10)

*/

$page = $r['page'] ? $r['page'] : 1;
$size = $page;
$data = DB::select("exec [LV_MSHotel] '".$r['cari']."','".$r['country']."','".$r['state']."','".$r['city']."','".$r['area']."','".$r['rateOffice']."','".$r['rateHotel']."';");       
$collect = collect($data);


$paginationData = new LengthAwarePaginator(
                         $collect->forPage($page, $size),
                         $collect->count(), 
                         $size, 
                         $page
                       );

        //->paginate($p);

        return response()->json($paginationData, 200);
    
    }

}
