<?php

namespace App\Http\Controllers;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use App\qr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class QRController extends Controller
{
    //
    public function index()
    {

        $qrs = qr::all();
   
        return view('pages.qr.qr',compact('qrs'));
    }

    public function insert(Request $request)
    {
       $title = $request->title;

       $body = $request->body;

       $code = Str::slug($title).'.svg';


        $qr = QrCode::format('svg')->generate($body,public_path('qrcode/'.$code));

        //$qr = QrCode::format('svg')->generate($body);

        qr::create([
            'title'=>$title,
            'body'=>$body,
            'qr'=>$code
        ]);

        return view('pages.qr.qr',compact('code'));
    }
}
