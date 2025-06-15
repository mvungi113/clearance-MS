<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PalmPesaService
{
    protected $userId;
    protected $apiToken;
    protected $baseUrl;
    protected $callbackUrl;

    public function __construct()
    {
        $this->userId = config('palm_pesa.user_id', env('PALMPESA_USER_ID'));
        $this->apiToken = config('palm_pesa.api_token', env('PALMPESA_API_TOKEN'));
        $this->baseUrl = config('palm_pesa.base_url', env('PALMPESA_BASE_URL'));
        $this->callbackUrl = config('palm_pesa.callback_url', env('PALMPESA_CALLBACK_URL'));
    }

    /**
     * Initiate a sharable payment link request.
     */
    public function initiatePaymentLink(array $data)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ])->post("{$this->baseUrl}/api/process-payment", [
            'user_id'          => $this->userId,
            'vendor'           => 'TILL61103867',
            'order_id'         => $data['order_id'],
            'buyer_email'      => $data['buyer_email'],
            'buyer_name'       => $data['buyer_name'],
            'buyer_phone'      => $data['buyer_phone'],
            'amount'           => $data['amount'],
            'currency'         => 'TZS',
            'redirect_url'     => $data['redirect_url'],
            'cancel_url'       => $data['cancel_url'],
            'webhook'          => $data['webhook'],
            'buyer_remarks'    => $data['buyer_remarks'],
            'merchant_remarks' => $data['merchant_remarks'],
            'no_of_items'      => $data['no_of_items'],
        ]);

        return $response->json();
    }

    /**
     * Initiate a direct mobile money/USSD push payment.
     */
    public function payViaMobile(array $data)
    {
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ])->post("{$this->baseUrl}/api/pay-via-mobile", [
            'user_id'        => $this->userId,
            'name'           => $data['name'],
            'email'          => $data['email'],
            'phone'          => $data['phone'],
            'amount'         => $data['amount'],
            'transaction_id' => $data['transaction_id'],
            'address'        => $data['address'],
            'postcode'       => $data['postcode'],
            'buyer_uuid'     => $data['buyer_uuid'],
        ]);

        return $response->json();
    }
}