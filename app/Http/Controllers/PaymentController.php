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
     * Initiate a payment and create a transaction record (Pay by Link).
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
                'redirect_url'     => url('/payment/success'),
                'cancel_url'       => url('/payment/cancel'),
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
     * Receive and process Palm Pesa callback (webhook).
     */
    public function callback(Request $request)
    {
        Log::info('Palm Pesa callback received', $request->all());

        // Get the reference or order_id from the callback data
        $reference = $request->input('reference') ?? $request->input('order_id');

        if (!$reference) {
            return response()->json(['error' => 'Reference missing'], 400);
        }

        // Find the transaction
        $transaction = PalmPesaTransaction::where('reference', $reference)->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        // Update transaction with callback data
        $transaction->update([
            'status'             => $request->input('status', 'success'), // Use actual status from Palm Pesa if available
            'transaction_id'     => $request->input('transaction_id') ?? $request->input('transid'),
            'palm_pesa_response' => $request->all(),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Initiate a payment via mobile and create a transaction record (USSD Push).
     */
    public function payViaMobile(Request $request)
    {
        $request->validate([
            'phone'  => 'required|string',
            'amount' => 'required|numeric|min:200', // Minimum is 200 TSh
        ], [
            'amount.min' => 'The minimum payment amount is 200 TSh.',
        ]);

        $user = auth()->user();

        $transaction_id = 'TXN' . uniqid();

        // Save transaction as pending
        $transaction = PalmPesaTransaction::create([
            'reference'   => $transaction_id,
            'phone'       => $request->phone,
            'amount'      => $request->amount,
            'status'      => 'pending',
            'user_email'  => $user->email ?? null,
            'first_name'  => $user->first_name ?? null,
            'last_name'   => $user->last_name ?? null,
        ]);

        $data = [
            'name'           => trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')),
            'email'          => $user->email ?? 'student@example.com',
            'phone'          => $request->phone,
            'amount'         => $request->amount,
            'transaction_id' => $transaction_id,
            'address'        => 'N/A',
            'postcode'       => '00000',
            'buyer_uuid'     => $user->id ?? rand(100000,999999),
        ];

        $response = $this->palmPesa->payViaMobile($data);

        // Save response
        $transaction->update(['palm_pesa_response' => $response]);

        if (isset($response['response']['result']) && $response['response']['result'] === 'SUCCESS') {
            return back()->with('success', $response['message'] ?? 'Payment request sent to user\'s phone.');
        }

        return back()->with('error', $response['message'] ?? 'Payment initiation failed.');
    }
}
