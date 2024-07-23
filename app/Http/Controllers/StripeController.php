<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Stripe\Stripe;
use Stripe\Charge;

class StripeController extends Controller
{
    public function showPaymentForm()
    {
        return view('stripe.payment');
    }

    public function handlePayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'stripeToken' => 'required|string',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $charge = Charge::create([
                'amount' => $request->amount * 100,
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Test Payment',
            ]);

            $payment = new Payment();
            $payment->stripe_id = $charge->id;
            $payment->amount = $charge->amount;
            $payment->currency = $charge->currency;
            $payment->status = $charge->status;
            $payment->save();

            return redirect()->back()->with('success_message', 'Payment successful!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', $e->getMessage());
        }
    }

    public function handleWebhook(Request $request)
    {
        // You should validate the event first
        $event = $request->input();

        if ($event['type'] == 'charge.succeeded') {
            $charge = $event['data']['object'];

            $payment = Payment::where('stripe_id', $charge['id'])->first();
            if ($payment) {
                $payment->status = 'succeeded';
                $payment->save();
            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}
