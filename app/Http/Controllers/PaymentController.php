<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PalmPesaTransaction;
use App\Services\PalmPesaService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $palmPesa;

    public function __construct(PalmPesaService $palmPesa)
    {
        $this->palmPesa = $palmPesa;
    }

    /**
     * Show the payment form.
     */
    public function showPayForm()
    {
        return view('palm_pesa.pay');
    }

    /**
     * Initiate a payment and create a transaction record.
     */
    public function pay(Request $request)
    {
        $request->validate([
            'phone'  => 'required|string',
            'amount' => 'required|numeric|min:1',
            'name'   => 'required|string',
            'email'  => 'required|email',
        ]);

        $reference = Str::uuid()->toString();

        // Save transaction with status 'pending'
        $transaction = PalmPesaTransaction::create([
            'reference' => $reference,
            'phone'     => $request->phone,
            'amount'    => $request->amount,
            'status'    => 'pending',
        ]);

        try {
            $paymentData = [
                'order_id'         => $reference,
                'buyer_email'      => $request->email,
                'buyer_name'       => $request->name,
                'buyer_phone'      => $request->phone,
                'amount'           => $request->amount,
                'redirect_url'     => url('/payment/success'), // or route('payment.success')
                'cancel_url'       => url('/payment/cancel'),  // or route('payment.cancel')
                'webhook'          => config('palm_pesa.callback_url'),
                'buyer_remarks'    => 'Student Payment',
                'merchant_remarks' => 'Student Clearance',
                'no_of_items'      => 1,
            ];

            $response = $this->palmPesa->initiatePaymentLink($paymentData);

            // Save the response
            $transaction->update([
                'palm_pesa_response' => $response,
            ]);

            if (isset($response['raw']['payment_gateway_url'])) {
                // Redirect student to payment page
                return redirect($response['raw']['payment_gateway_url']);
            }

            $transaction->update(['status' => 'failed']);
            return back()->with('error', $response['message'] ?? 'Payment initiation failed.');
        } catch (\Exception $e) {
            $transaction->update(['status' => 'failed']);
            return back()->with('error', 'Payment initiation failed: ' . $e->getMessage());
        }
    }

    /**
     * Receive and process Palm Pesa callback.
     */
    public function callback(Request $request)
    {
        // Log the callback for debugging
        \Log::info('Palm Pesa callback received', $request->all());

        // Get the reference or order_id from the callback data
        $reference = $request->input('reference') ?? $request->input('order_id');

        if (!$reference) {
            return response()->json(['error' => 'Reference missing'], 400);
        }

        // Find the transaction
        $transaction = \App\Models\PalmPesaTransaction::where('reference', $reference)->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        // Update transaction with callback data
        $transaction->update([
            'status'             => $request->input('status', 'success'), // or use the actual status field from Palm Pesa
            'transaction_id'     => $request->input('transaction_id') ?? $request->input('transid'),
            'palm_pesa_response' => $request->all(),
        ]);

        return response()->json(['success' => true]);
    }
}
