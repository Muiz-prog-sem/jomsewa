<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use DB;
use Carbon\Carbon;

use App\Models\Car;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;

use Dompdf\Dompdf;
use Dompdf\Options;

use App\Mail\PaymentSuccess;
use Illuminate\Support\Facades\Mail;


class PayPalController extends Controller
{
    public function paypal(Request $request)
    {
        $bookingId = $request->booking_id;
        $request->session()->put('booking_id', $bookingId);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success'),
                "cancel_url" => route('cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->total,
                    ],
                    "payee" => [
                        "email_address" => $request->email,
                        "name" => [
                            "given_name" => $request->name,
                        ]
                    ]
                    
                ]
            ]
        ]);
        //dd($response);
        if(isset($response['id']) && $response['id'] != null)
        {
            foreach($response['links'] as $link)
            {
                if($link['rel'] === 'approve')
                {
                    session()->put('payer_name', $request->name);
                    session()->put('payer_email', $request->email);
                    session()->put('amount', $request->total);
                    return redirect()->away($link['href']);
                }
            }
        }else{
            return redirect()->route('cancel');
        }
    }

    public function success(Request $request)
{
    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $paypalToken = $provider->getAccessToken();
    $response = $provider->capturePaymentOrder($request->token);

    if(isset($response['status']) && $response['status'] == 'COMPLETED')
    {
        // Extract booking id from session or request parameters
        $bookingId = $request->session()->get('booking_id');

        foreach($bookingId as $bookingid)
        {
            $booking = Booking::findOrFail($bookingid);
            $booking->pay_status = '1';
            $booking->save();
        }

        // Save payment details
        $payment = new Payment;
        $payment->payment_id = $response['id'];
        $payment->payer_email = session()->get('payer_email');
        $payment->payer_name = session()->get('payer_name');
        $payment->amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
        $payment->payment_status = $response['status'];
        $payment->payment_method = "Paypal";
        //$payment->booking_id = $bookingId; // Associate payment with booking
        $payment->save();

        // Clear session data
        $request->session()->forget(['payer_name', 'payer_email', 'booking_id']);

        // Send email notification if status is approved
        if ($payment->payment_status === 'COMPLETED') {
            Mail::to($booking->user->email)->send(new PaymentSuccess($payment));
        }

        // Redirect to receipt page
        return redirect()->route('users.receipt', ['payment' => $payment->id]);
    } else {
        return redirect()->route('cancel');
    }
}


    public function cancel()
    {
        return "Payment is cancelled";
    }

    public function index()
    {
        $list = Payment::all();
        return view('payments.index', compact('list'));
    }

    public function show($id)
    {
        $list = Payment::findOrFail($id);
        return view('payments.show',compact('list'));
    }

    public function receipt($payment)
    {
        $payment = Payment::findOrFail($payment);
        return view('users.receipt', compact('payment'));
    }
    
    public function generateReceipt(Payment $payment)
    {
        // Fetch payment details (assuming $payment is passed from route or fetched as needed)

        // Load payment receipt view
        $view = view('users.receiptpdf', compact('payment'))->render();

        // Setup Dompdf
        $pdfOptions = new Options();
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($pdfOptions);
        $dompdf->loadHtml($view);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (important for Laravel Dompdf 1.0)
        $dompdf->render();

        // Output generated PDF to Browser (force download)
        return $dompdf->stream("payment_receipt.pdf");
    }

}
