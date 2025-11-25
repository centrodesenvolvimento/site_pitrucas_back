<?php

namespace App\Http\Controllers;

use App\Mail\Mail as CustomMail;
use App\Models\Info;
use GuzzleHttp\Client;
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

        //email1
        MailFacade::to($request->pw ? $request->email : $info->info['email'])->send(new CustomMail($details));

        if (MailFacade::failures()) {
            return response()->json('Sorry! Please try again latter');
        } else {
            return response()->json('Great! Successfully send in your mail');
        }
    }
    public function handleChat(Request $request)
{
    $messageContent1 = config('services.api.messagecontent1');
    $messageContent2 = config('services.api.messagecontent2');
    $model = config('services.api.model');

    $question = $request->question;

    $messages = [
        [
            'role' => 'system',
            'content' => $messageContent1 . "\nImportant: The current date is " . date('c') . ".\n" . $messageContent2,
        ],
        [
            'role' => 'user',
            'content' => $question,
        ],
    ];

    $payload = [
        'stream' => false,
        'model' => $model,
        'messages' => $messages,
    ];

    $apiUrl = config('services.api.route');
    $pwkey = config('services.api.key');

    try {
        $client = new \GuzzleHttp\Client();

        $response = $client->post($apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . $pwkey,
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
            'verify' => false
        ]);

        $responseBody = json_decode($response->getBody(), true);

        return response()->json($responseBody);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}
