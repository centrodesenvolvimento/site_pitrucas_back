<?php

namespace App\Http\Controllers;

use App\Mail\Mail as CustomMail;
use App\Models\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail as MailFacade;

class MailController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(Request $request)
    {
        $info = Info::findOrFail(1);


        $details = [
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'fromEmail' => $request->input('fromEmail'),
            'contacto' => $request->input('contacto'),
            'name' => $request->input('name'),
            'file' => $request->file('document'),
        ];

        MailFacade::to($info->info['email'])->send(new CustomMail($details));

        if (MailFacade::failures()) {
            return response()->json('Sorry! Please try again latter');
       }else{
            return response()->json('Great! Successfully send in your mail');
          }

    }
}
