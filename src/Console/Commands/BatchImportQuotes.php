<?php
namespace MyVendor\Quotes\Console\Commands;

use Illuminate\Console\Command;
use MyVendor\Quotes\Services\QuoteService;
use MyVendor\Quotes\Exceptions\RateLimitExceededException;

class BatchImportQuotes extends Command
{
    protected $signature = 'quotes:batch-import {count}';
    protected $description = 'Fetch batch quotes';

    public function handle(QuoteService $service)
    {
        $count = (int) $this->argument('count');
        $fetched = 0;
        $unique = [];

        while ($fetched < $count) {
            try {
                $quote = $service->getQuote(rand(1,100));
                if (!in_array($quote['id'], $unique)) {
                    $unique[] = $quote['id'];
                    $fetched++;
                    $this->info("Fetched {$fetched}/{$count}");
                }
            } catch (RateLimitExceededException $e) {
                $this->warn("Rate limit hit. Waiting for ".config('quotes.time_window')."s...");
                sleep(config('quotes.time_window'));
            }
        }

        $this->info("Imported {$count} quotes successfully.");
    }
}
