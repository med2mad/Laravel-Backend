<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class PhotoConfirm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $photoName='';
        if($request->hasFile('photo') and $request->file('photo')->isValid())
        {                 
            $photoType = $request->file('photo')->getMimeType();
            if(!Str::startsWith($photoType,'image/')){ return response('Error: Only Images!'); }
            $photoSize = $request->file('photo')->getSize();
            if($photoSize>1024*1024*20){ return response('Error: Photo too large'); }

            $photoName = $request->file('photo')->getClientOriginalName().time(); 
            $request->file('photo')->move("/webProjects/AJAX School/vue front/public/uploads/", $photoName);//this is consedered "localhost/webprojects", without the initial slash (/) the adress is relative (webProjects folder is created in this app's "public")
        }
        else{ $photoName = $request->input('selectedPhotoName'); }

        $request->attributes->set('photoName',$photoName);
        return $next($request);
    }
}
