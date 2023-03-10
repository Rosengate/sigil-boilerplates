<?php

namespace App\Http\Controllers\Samples;

use App\Http\Controllers\Controller;
use App\Services\StripeService;
use Exedra\Routeller\Attributes\Path;
use Illuminate\Http\Request;

#[Path('/stripe')]
class StripeSamplesController extends Controller
{
    public function middleware(Request $request, $next)
    {
        app()->instance(StripeService::class, StripeService::create());

        return $next($request);
    }

    #[Path('/checkout')]
    public function getCheckout(StripeService $stripeService)
    {

        $session = $stripeService->stripe->checkout->sessions->create([
            'payment_method_types' => ['card', 'fpx'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'myr',
                    'product_data' => [
                        'name' => 'Test Product',
                        'description' => 'Product Description',
                        'images' => ['https://example.com/image.jpg'],
                    ],
                    'unit_amount' => 3000,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'https://example.com/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => 'https://example.com/cancel',
        ]);

        echo $session->url;
    }
}
