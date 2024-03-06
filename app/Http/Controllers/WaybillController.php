<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Waybill;
use App\Models\Activity;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\CancelWaybill;
use App\Traits\TransactionTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class WaybillController extends Controller
{
    use TransactionTrait;
    public function mywaybills()
    {
        $data['user'] = $user = Auth::user();
        $data['company'] = User::where('id', $user->company_id)->first();

        // dd($user);
        $data['active'] = 'waybill';
        if ($user->block == 1) {

            return response()->view('dashboard.unverified', $data);
        }
        // dd('here',$user);
        if ($user->pin == null) {
            return response()->view('dashboard.setpin', $data);
        } else {

            // $data['banks'] = Bank::all();

            $notification = Notification::where('user_id', $user->company_id)->where('type', 'General Notification')->first();

            if ($notification && $notification->title !== null) {
                $data['notification'] = $notification;
            }
            $data['waybills'] = Waybill::where('user_id', $user->id)->orWhere('client_id', $user->id)->latest()->get();
            //    dd($data);

            return response()->view('dashboard.mywaybills', $data);
        }
    }
    public function createwaybill()
    {
        $data['user'] = Auth::user();
        $data['active'] = 'waybill';
        return view('dashboard.createwaybill', $data);
    }
    public function makepayment($id)
    {
        $data['user'] = Auth::user();
        $data['active'] = 'waybill';
        $data['waybill'] = Waybill::where('uid', $id)->first();
        return view('dashboard.makepayment', $data);
    }

    public function retrieveclient(Request $request)
    {
        $data = $request->client_id;
        $user = User::where('username', $request->client_id)->first();

        if ($user === null) {
            return false;
        }

        return $user;
    }

    public function savewaybill(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            "client_id" => ['required'],
            "product_name" => "required",
            "subtotal" => "required",
            "charges" => "required",
            "amount" => "required",
            "paymentmode" => "required"
        ]);

        $user = Auth::user();
        $client =  User::where('username', $request->client_id)->first();
        if ($client === null) {
            return redirect()->back()->with('error', 'Client does not exist!');
        }
        $waybill = Waybill::create([
            'uid' => Str::uuid(),
            'reference' => "SWBP" . Str::random(5),
            'user_id' => $user->id,

            'client_id' => $client->id,
            'product_name' => $request->product_name,
            'charges' => $request->charges,
            'subamount' => $request->subtotal,
            'totalamount' => $request->amount,
            'payment_method' => $request->paymentmode,
        ]);

        $data['user'] = $user = Auth::user();
        $data['amount'] = $amount = $waybill->totalamount;
        $data['active'] = 'fundwallet';
        $data['waybill'] = $waybill;
        if ($waybill->paymentmode == 'Card') {
            $env = env('FLW_PUBLIC_KEY');

            $data['public_key'] = $env;
            $data['callback_url'] = 'https://securewaybill.com/payment/callback';


            return view('dashboard.pay_with_card', $data);
        } else {

            $str_name = explode(" ", $user->name);
            $first_name = $str_name[0];
            $last_name = end($str_name);
            // return view('dashboard.direct_transfer',$data);  
            // $env = User::where('email', 'fasanyafemi@gmail.com')->first()->remember_token;
            $trx_ref = $waybill->uid;

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                // 'Authorization' => 'Bearer ' . $env, // Replace with your actual secret key
                'Authorization' => 'Bearer ' . env('FLW_SECRET_KEY'), // Replace with your actual secret key
            ])
                ->post('https://api.flutterwave.com/v3/virtual-account-numbers/', [
                    'email' => $user->email,
                    'is_permanent' => false,
                    // 'bvn' => 12345678901,
                    'tx_ref' => $trx_ref,
                    'phonenumber' => $user->phone,
                    'amount' => $amount,
                    'firstname' => $first_name,
                    'lastname' => $last_name,
                    'narration' => 'Securewaybill/' . $first_name . '-' . $last_name,
                ]);

            // You can then access the response body and status code like this:
            $responseBody = $response->body(); // Get the response body as a string
            $responseStatusCode = $response->status(); // Get the HTTP status code

            // You can also convert the JSON response to an array or object if needed:
            $responseData = $response->json(); // Converts JSON response to an array
            // dd($responseData, 'here');
            $data['bank_name'] = $responseData['data']['bank_name'];
            $data['account_no'] = $responseData['data']['account_number'];
            $data['amount'] = ceil($responseData['data']['amount']);
            $data['expiry_date'] = $responseData['data']['expiry_date'];
            return view('dashboard.direct_transfer', $data);
        }
    }
    public function paywaybill(Request $request)
    {
       
        // dd($request->all());
        $user = Auth::user();
        $client =  User::where('username', $request->client_id)->first();
        if ($client === null) {
            return redirect()->back()->with('error', 'Client does not exist!');
        }
        $data['waybill'] = $waybill = Waybill::where('uid', $request->waybillId)->first();
        $data['user'] = $user = Auth::user();
        $data['amount'] = $amount = $waybill->totalamount;
        $data['active'] = 'fundwallet';
        if ($waybill->paymentmode == 'Card') {
            $env = env('FLW_PUBLIC_KEY');

            $data['public_key'] = $env;
            $data['callback_url'] = 'https://securewaybill.com/payment/callback';


            return view('dashboard.pay_with_card', $data);
        } else {

            $str_name = explode(" ", $user->name);
            $first_name = $str_name[0];
            $last_name = end($str_name);
            // return view('dashboard.direct_transfer',$data);  
            // $env = User::where('email', 'fasanyafemi@gmail.com')->first()->remember_token;
            $trx_ref = $waybill->uid;
            // dd(env('FLW_SECRET_KEY'));

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('FLW_SECRET_KEY'), // Replace with your actual secret key
            ])
                ->post('https://api.flutterwave.com/v3/virtual-account-numbers/', [
                    'email' => $user->email,
                    'is_permanent' => false,
                    // 'bvn' => 12345678901,
                    'tx_ref' => $trx_ref,
                    'phonenumber' => $user->phone,
                    'amount' => $amount,
                    'firstname' => $first_name,
                    'lastname' => $last_name,
                    'narration' => 'Securewaybill/' . $first_name . '-' . $last_name,
                ]);

            $responseBody = $response->body(); // Get the response body as a string
            $responseStatusCode = $response->status(); // Get the HTTP status code

            $responseData = $response->json(); // Converts JSON response to an array
            // dd($responseData, 'here');
            $data['bank_name'] = $responseData['data']['bank_name'];
            $data['account_no'] = $responseData['data']['account_number'];
            $data['amount'] = ceil($responseData['data']['amount']);
            $data['expiry_date'] = $responseData['data']['expiry_date'];
          
            return view('dashboard.direct_transfer', $data);
        }
    }
    public function slug($slug)
    {
        // dd($slug);
        $data['user'] = $user = Auth::user();
        $data['waybill'] = $waybill = Waybill::where('reference', $slug)->first();
        $data['active'] = 'waybill';
        $data['activities'] = Activity::where('user_id', $user->id)->where('waybill_id', $waybill->uid)->latest()->get();
            
        $cancel = CancelWaybill::where('waybill_id', $waybill->uid)->get();
        if (count($cancel) == 1) {

            if ($cancel[0]->user_id == $user->id) {
                $data['cancel'] = 'self';
            } else {
                $data['cancel'] = 'client';
            }
        } elseif (count($cancel) == 2) {
            if ($waybill->user_id == $user->id) {
                $data['cancel'] = 'withdraw';
            } else {
                $data['cancel'] = 'client-withdraw';
            }
        } else {
            $data['cancel'] = 'any';
        }
        //  dd($data);

        if ($user->id == $waybill->user_id || $user->id == $waybill->client_id) {
            return view('dashboard.waybilldetails', $data);
        } else {
            return redirect()->route('/dashboard')->with('error', 'Access Denied!');
        }
    }

    public function marksent($id)
    {
        $waybill = Waybill::where('uid', $id)->first();

        // Error handling: Check if $waybill is not null
        if (!$waybill) {
            return redirect()->back()->with('error', 'Waybill not found!');
        }
        $user = Auth::user();
        if ($user->id == $waybill->user_id || $user->id == $waybill->client_id) {
            $waybill->status = 2;
            $waybill->save();
            $title = "Waybill Sent";
            $details = "Product : " . $waybill->product_name . " (" . $waybill->reference . ") Amount :" . $waybill->totalamount;
            $this->create_activity($waybill->uid, $user->id, $title, $details, 2);
            return redirect()->back()->with('message', 'Waybill has been marked sent to your client. Once your client approve the receipient of waybill, you can then withdraw your funds!');
        } else {
            return redirect()->route('/dashboard')->with('error', 'Access Denied!');
        }
    }
    public function withdraw($id)
    {
        $waybill = Waybill::where('uid', $id)->first();
        $user = Auth::user();
        $data['active'] = 'withdraw';


        // Error handling: Check if $waybill is not null
        if (!$waybill) {
            return redirect()->back()->with('error', 'Waybill not found!');
        }
        $checkcancel = CancelWaybill::where('waybill_id', $waybill->uid)->count();

        if ($checkcancel == 2) {
            if ($waybill->user_id == $user->id) {
                $data['waybill'] = $waybill;
                $data['user'] = $user;
                return view('dashboard.withdraw', $data);
            }
        } elseif ($waybill->status == 3) {
            // dd($waybill, $user);

            if ($waybill->client_id == $user->id) {
                $data['waybill'] = $waybill;
                $data['user'] = $user;

                return view('dashboard.withdraw', $data);
            }
        } else {

            return redirect()->back()->with('message', 'Access Denied, Waybill Lack Withdrawer Permission!');
        }
    }
    public function markreceived($id)
    {
        $waybill = Waybill::where('uid', $id)->first();

        // Error handling: Check if $waybill is not null
        if (!$waybill) {
            return redirect()->back()->with('error', 'Waybill not found!');
        }
        $user = Auth::user();
        if ($user->id == $waybill->user_id || $user->id == $waybill->client_id) {
        
        $waybill->status = 3;
        $waybill->save();
        $title = "Waybill Received";
        $details = "Product : " . $waybill->product_name . " (" . $waybill->reference . ") Amount :" . $waybill->totalamount;
        $this->create_activity($waybill->uid, $user->id, $title, $details, 3);
        return redirect()->back()->with('message', 'Waybill has been marked received. Your client can now withdraw funds!');
    } else {
        return redirect()->route('/dashboard')->with('error', 'Access Denied!');
    }
    }


    public function cancelwaybill($id)
    {
        $waybill = Waybill::where('uid', $id)->first();

        // Error handling: Check if $waybill is not null
        if (!$waybill) {
            return redirect()->back()->with('error', 'Waybill not found!');
        }

        $user = Auth::user();

        if ($user->id == $waybill->user_id || $user->id == $waybill->client_id) {
            $cancel = CancelWaybill::where('user_id', $user->id)->where('waybill_id', $waybill->uid)->get();

            if (count($cancel) >= 1) {
                if ($cancel[0]->user_id == $user->id) {
                    return redirect()->back()->with('message', 'Waybill Cancelled, waiting for the approval of your client!');
                } else {
                    $title = "Waybill Cancellation Approved";
                    $details = "Product : " . $waybill->product_name .  " (" . $waybill->reference . ") Amount :" . $waybill->totalamount;
                    $this->create_activity($waybill->uid, $user->id, $title, $details, 4);

                    CancelWaybill::create(['waybill_id' => $waybill->uid, 'user_id' => $user->id]);
                    return redirect()->back()->with('message', 'Waybill Cancelled, waybill creator can now withdraw funds!');
                }
            }

            CancelWaybill::create(['waybill_id' => $waybill->uid, 'user_id' => $user->id]);
            $title = "Waybill Canceled";
            $details = "Product : " . $waybill->product_name .  " (" . $waybill->reference . ") Amount :" . $waybill->totalamount;
            $this->create_activity($waybill->uid, $user->id, $title, $details, 4);
            return redirect()->back()->with('message', 'Waybill Cancelled, waiting for the approval of your client!');
        } else {
            // Corrected redirect route
            return redirect()->route('dashboard')->with('error', 'Access Denied!');
        }
    }

    public function uncancelwaybill($id)
    {
        $waybill = Waybill::where('uid', $id)->first();

        // Error handling: Check if $waybill is not null
        if (!$waybill) {
            return redirect()->back()->with('error', 'Waybill not found!');
        }

        $user = Auth::user();

        if ($user->id == $waybill->user_id || $user->id == $waybill->client_id) {
            $cancel = CancelWaybill::where('user_id', $user->id)->where('waybill_id', $waybill->uid)->get();

            if (count($cancel) >= 1) {

                $title = "Waybill Uncancelled";
                $details = "Product : " . $waybill->product_name .  " (" . $waybill->reference . ") Amount :" . $waybill->totalamount;
                $this->create_activity($waybill->uid, $user->id, $title, $details, 5);
                CancelWaybill::where('waybill_id', $waybill->uid)->where('user_id', $user->id)->delete();

                return redirect()->back()->with('message', 'Waybill uncancelled.');
            }

            // CancelWaybill::where('waybill_id', $waybill->uid)->where('user_id', $user->id)->delete();

            // $title = "Waybill ". $waybill->reference. " uncanceled";
            // $details = "Product : ".$waybill->product_name. " Amount :". $waybill->totalamount;
            // $this->create_activity($waybill->uid, $user->id,$title, $details,5);
            return redirect()->back()->with('message', 'Waybill Uncancelled, waiting for the approval of your client!');
        } else {
            // Corrected redirect route
            return redirect()->route('dashboard')->with('error', 'Access Denied!');
        }
    }


    public function deletewaybill($id)
    {
        $waybill = Waybill::where('uid', $id)->first();
        $user = Auth::user();

        if ($waybill->user_id == $user->id) {
            $title = "Waybill Deleted";
            $details = "Product : " . $waybill->product_name .  " (" . $waybill->reference . ") Amount :" . $waybill->totalamount;
            $this->create_activity($waybill->uid, $user->id, $title, $details, 5);
            $waybill->delete();
            return redirect()->back()->with('message', 'Waybill Deleted Successfully!');
        } else {
            return redirect()->back()->with('error', 'Access Denied!');
        }
    }
}
