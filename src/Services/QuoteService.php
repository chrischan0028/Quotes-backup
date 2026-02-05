<?php
namespace MyVendor\Quotes\Services;

use Illuminate\Support\Facades\Cache;
use MyVendor\Quotes\Exceptions\RateLimitExceededException;

class QuoteService
{
    protected string $cacheKey = 'quotes_cache';

    protected function checkRateLimit()
    {
        $count = Cache::get('quotes_request_count', 0);
        $windowStart = Cache::get('quotes_window_start', now());

        if (now()->diffInSeconds($windowStart) > config('quotes.time_window')) {
            Cache::put('quotes_request_count', 0, config('quotes.time_window'));
            Cache::put('quotes_window_start', now(), config('quotes.time_window'));
            $count = 0;
        }

        if ($count >= config('quotes.request_limit')) {
            throw new RateLimitExceededException('API rate limit exceeded');
        }

        Cache::increment('quotes_request_count');
    }

    public function getQuote(int $id)
    {
        $this->checkRateLimit();

        $cached = Cache::get($this->cacheKey, []);
        $quote = $this->binarySearch($cached, $id);

        if ($quote) return $quote;

        $response = file_get_contents(config('quotes.base_url') . "/$id");
        $quote = json_decode($response, true);

        $cached[] = $quote;
        usort($cached, fn($a,$b) => $a['id'] <=> $b['id']);
        Cache::put($this->cacheKey, $cached, 3600);

        return $quote;
    }

    public function binarySearch(array $arr, int $id)
    {
        $low = 0;
        $high = count($arr) - 1;

        while ($low <= $high) {
            $mid = intdiv($low + $high, 2);
            if ($arr[$mid]['id'] === $id) return $arr[$mid];
            if ($arr[$mid]['id'] < $id) $low = $mid + 1;
            else $high = $mid - 1;
        }

        return null;
    }
}
