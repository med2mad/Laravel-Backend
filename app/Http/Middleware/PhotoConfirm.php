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
            if($photoSize>1024*1024*10){ return response('Error: Photo too large'); }

            $photoName = $request->file('photo')->getClientOriginalName().time(); 
            move_uploaded_file($_FILES['photo']['tmp_name'], "C:\Users\MED\Desktop\AJAX Paradise\public\uploads/".$photoName);
        }
        else{ $photoName = $request->input('selectedPhotoName'); }

        $request->attributes->set('photoName',$photoName);
        return $next($request);
    }
}
