<?php

namespace App\Services;

use App\Exceptions\Exception;
use Stripe\StripeClient;

class StripeService
{
    public function __construct(public readonly StripeClient $stripe){}

    public static function create()
    {
        if (!config('stripe.secret_key'))
            throw new Exception('STRIPE_SECRET_KEY env is missing from .env');

        return new static(new StripeClient([
            'api_key' => config('stripe.secret_key')
        ]));
    }

    public function products()
    {
        return $this->stripe->products->all();
    }
}
