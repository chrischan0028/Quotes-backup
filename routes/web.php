<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use MyVendor\Quotes\Services\QuoteService;

Route::get('/api/quotes', function(QuoteService $service) {
    $quotes = Cache::get('quotes_cache', []);
    $page = request()->query('page', 1);
    $perPage = request()->query('per_page', 5);
    $total = count($quotes);
    $items = array_slice($quotes, ($page - 1) * $perPage, $perPage);
    return response()->json([
        'data' => $items,
        'page' => (int) $page,
        'per_page' => (int) $perPage,
        'total' => $total
    ]);
});

Route::get('/api/quotes/{id}', function(int $id, QuoteService $service) {
    return response()->json($service->getQuote($id));
});

Route::get('/quotes-ui', function() {
    return view('quotes-ui');
});
