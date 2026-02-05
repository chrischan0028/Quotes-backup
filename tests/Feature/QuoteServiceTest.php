<?php
use MyVendor\Quotes\Services\QuoteService;
use MyVendor\Quotes\Exceptions\RateLimitExceededException;

it('throws exception on rate limit', function() {
    Cache::put('quotes_request_count', config('quotes.request_limit'), 60);
    $service = new QuoteService();
    $service->getQuote(1);
})->throws(RateLimitExceededException::class);
