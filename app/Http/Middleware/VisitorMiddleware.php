<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;

class VisitorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // save visitor ketika ada middleware ini
        // get informasi visitor
        $ipaddress      = get_client_ip_2();
        $browser        = get_client_browser();
        $tglvisitor     = tgl_sekarang();

        
        // cek visitor
        $cekvisitor = Visitor::where([['tgl_visitor',$tglvisitor],['ip_address',$ipaddress]])->first();
        if ($cekvisitor) {
            // jika visitor ada, maka hits ditambahkan 1 lalu di update

            $hits   = $cekvisitor->hits + 1;
            Visitor::where('id',$cekvisitor->id)->update([
                'hits' => $hits
                ]);
        } else {
            // jika tidak ada maka visitor ditambahkan baru
            Visitor::create([
                'ip_address' => $ipaddress,
                'browser' => $browser,
                'hits' => 1,
                'tgl_visitor' => $tglvisitor,
            ]);
        }
        return $next($request);
    }
}
