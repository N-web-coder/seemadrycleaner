<?php

namespace App\Http\Controllers;

use App\Services\PhoneValidator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WhatsappController extends Controller
{

    public $whatsappApiBaseUrl = 'https://nodwaqpi1.dkinfotechsolutions.in';

    public function index()
    {
        // checking the existence of the 'whatsapp' session in cache
        $whatsappSession = Cache::get('whatsapp_session');
        if (!$whatsappSession) {
            $whatsappSession = Str::random(67);
            Cache::forever('whatsapp_session', $whatsappSession);
        }

        $responseBody = $this->checkSessionStatus();

        if ($responseBody && isset($responseBody['data']['message'])) {
            $status = $responseBody['data']['message'];
            if ($status === 'Connected') {
                // session is connected
                $id = $responseBody['data']['user']['id'] ?? null;
                $id = explode(':', $id)[0] ?? null;
                return view('admin.whatsapp', ['status'=> $status ,'data' => $id, 'message' => $status]);
            } elseif ($status === 'Connecting' && Cache::has($whatsappSession)) {
                // session is not connected
                $data = Cache::get($whatsappSession);
                return view('admin.whatsapp', ['status'=> $status ,'message' => 'Connecting, please wait...', 'qr' => $data['qr-image'] ?? null, 'expiry' => $data['expiry'] ?? null]);
            } else {
                // session logout and start it.
                $response1 = Http::post($this->whatsappApiBaseUrl . '/session/logout', [
                    'session' => $whatsappSession,
                    'username' => env('WHATSAPP_USERNAME'),
                    'password' => env('WHATSAPP_PASSWORD'),
                ]);
                Log::channel('whatsapp')->info('Whatsapp session logout response: ', ['response' => $response1->json()]);
                unset($response1);
                // restart the session
                $response1 = Http::post($this->whatsappApiBaseUrl . '/session/start', [
                    'session' => $whatsappSession,
                    'username' => env('WHATSAPP_USERNAME'),
                    'password' => env('WHATSAPP_PASSWORD'),
                ]);
                Log::channel('whatsapp')->info('Whatsapp session start response: ', ['response' => $response1->json()]);
                if ($response1->successful()) {
                    Cache::remember($whatsappSession, now()->addSeconds(26), function () use ($response1) {
                        return $response1->json()['data'];
                    });
                    $status = 'Scan the QR code to connect your WhatsApp session.';
                    return view('admin.whatsapp', ['status'=> $status ,'message' => $status,'qr'=> $response1->json()['data']['qr-image'] ?? null , 'expiry' => $response1->json()['data']['expiry'] ?? null]);
                }else{
                    return view('admin.whatsapp', ['status'=> $status ,'error' => 'Unknown session status: ' . $response1->json()['message'] ?? '']);
                }
            }
        } else {
            if(isset($responseBody['error'])) {
                $message = $responseBody['error'];
            }elseif(isset($responseBody['message'])) {
                $message = $responseBody['message'];
            }else {
                $message = 'Failed to check session status.';
            }
            return view('admin.whatsapp', ['error' => $message]);
        }
    }

    public function checkSessionStatus(){
        $whatsappSession = Cache::get('whatsapp_session');
        if (!$whatsappSession) {
            return response()->json(['error' => 'WhatsApp session not found'], 404);
        }

        $response = Http::get($this->whatsappApiBaseUrl . '/session/status', [
            'session' => $whatsappSession,
            'username' => env('WHATSAPP_USERNAME'),
            'password' => env('WHATSAPP_PASSWORD'),
        ]);
        Log::channel('whatsapp')->info('Whatsapp session status check response: ', ['response' => $response->json()]);

        return json_decode($response->body(), true);
    }

    public function logout()
    {
        $whatsappSession = Cache::get('whatsapp_session');
        if (!$whatsappSession) {
            return redirect()->route('admin.whatsapp.index')->with('success', 'WhatsApp session already logged out.');
        }

        $response = Http::post($this->whatsappApiBaseUrl . '/session/logout', [
            'session' => $whatsappSession,
            'username' => env('WHATSAPP_USERNAME'),
            'password' => env('WHATSAPP_PASSWORD'),
        ]);
        Log::channel('whatsapp')->info('Whatsapp session logout response: ', ['response' => $response->json()]);

        if ($response->successful()) {
            Cache::forget($whatsappSession);
            Cache::forever('whatsapp_session', Str::random(67));
            return redirect()->route('admin.whatsapp.index')->with('success', 'WhatsApp session logged out successfully.');
        } else {
            return redirect()->route('admin.whatsapp.index')->withErrors(['error' => 'Failed to logout WhatsApp session.']);
        }
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:1100',
            'message' => 'required|string',
            'image'    => 'nullable|file|mimes:jpg,jpeg,png|max:1025'
        ]);

        $whatsappSession = Cache::get('whatsapp_session');
        if (!$whatsappSession) {
            return back()->withErrors(['error' => 'WhatsApp session not found. Please initialize session.']);
        }

        $phoneNumbers = explode(',', str_replace([' ','-','(',')','+91'], '', $request->phone));
        $validNumbers = '';
        $inValidNumbers = '';

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('whatsapp_image/'.now()->toDateString().'/', 'public');
            $url = $this->whatsappApiBaseUrl . '/message/send-image';
        }else{
            $url = $this->whatsappApiBaseUrl . '/message/send-text';
        }

        foreach ($phoneNumbers as $item) {
            if (PhoneValidator::isValid($item)) {
                $validNumbers .= ', ' . $item;

                try {

                    $body = [
                        'session' => $whatsappSession,
                        'username' => env('WHATSAPP_USERNAME'),
                        'password' => env('WHATSAPP_PASSWORD'),
                        'to' => '91'.$item,
                        'text' => $request->input('message'),
                    ];

                    if (isset($path)){
                        $body['image_url'] = asset(Storage::url($path));
                    }

                    $response = Http::timeout(90)->connectTimeout(10)
                        ->post($url, $body);
                    Log::channel('whatsapp')->info('Whatsapp message send response: ', ['response' => $response->json()]);
                    if (!$response->successful()) {
                        return back()->withErrors(['error' => 'Failed to send message']);
                    }

                    sleep(rand(2,5));
                }catch (\Exception $exception){
                    return back()->with('error','Api Error');
                }
            } else {
                $inValidNumbers .= $item;
            }
        }

        if (isset($path)){
            Storage::disk('public')->delete($path);
        }

        $msg = 'Message will be sent to ' . $validNumbers;
        if (strlen($inValidNumbers) > 2) {
            $msg .= '. Not sent to ' . $inValidNumbers;
        }
        return back()->with('success', $msg);
    }

}
