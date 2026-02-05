<?php
use MyVendor\Quotes\Services\QuoteService;

it('can find quote by id', function() {
    $service = new QuoteService();
    $arr = [
        ['id'=>1,'quote'=>'a'],
        ['id'=>2,'quote'=>'b'],
        ['id'=>5,'quote'=>'c']
    ];
    expect($service->binarySearch($arr, 2)['quote'])->toBe('b');
    expect($service->binarySearch($arr, 3))->toBeNull();
});
