<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\Package;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class PackageController extends Controller
{
    private $client;

    public function __construct()
    {
        $environment = new SandboxEnvironment(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'));
        $this->client = new PayPalHttpClient($environment);
    }

    public function index()
    {
        $packages = Package::all();
        return response()->json($packages);
    }

    public function getDetails()
    {
        $user = Auth::user();
        $subscription = $user->subscriptions()->latest()->first();

        if (!$subscription) {
            return response()->json(['error' => 'No active subscription found'], 404);
        }

        return response()->json([
            'package_name' => $subscription->package->name,
            'duration' => $subscription->package->duration,
            'expires_at' => $subscription->expires_at->format('Y-m-d H:i:s'),
        ]);
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
        ]);

        $user = Auth::user();
        $package = Package::findOrFail($request->package_id);

        // Create PayPal order
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "reference_id" => "PUHF",
                    "amount" => [
                        "value" => $package->price,
                        "currency_code" => "USD"
                    ]
                ]
            ],
            "application_context" => [
                "cancel_url" => env('FRONTEND_URL') . '/subscription/cancel',
                "return_url" => env('FRONTEND_URL') . '/subscription/success'
            ]
        ];

        try {
            $response = $this->client->execute($request);

            // Create subscription
            $subscription = new Subscription([
                'user_id' => $user->id,
                'package_id' => $package->id,
                'paypal_order_id' => $response->result->id,
                'status' => 'pending',
                'expires_at' => $this->calculateExpiryDate($package),
            ]);
            $subscription->save();

            return response()->json([
                'order_id' => $response->result->id,
                'approve_link' => $this->getApproveLink($response),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function calculateExpiryDate($package): Carbon|null
    {
        if ($package->duration === 'lifetime') {
            return null;
        }

        $now = now();

        switch (strtolower($package->duration)) {
            case 'month':
                return $now->addMonths(1);
            case 'year':
                return $now->addYears(1);
            default:
                throw new \InvalidArgumentException("Unsupported duration unit: $durationUnit");
        }
    }

    private function getApproveLink($response)
    {
        foreach ($response->result->links as $link) {
            if ($link->rel === 'approve') {
                return $link->href;
            }
        }
    }

    // Add more methods for handling webhooks, cancellations, etc.
}