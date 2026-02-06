<?php

use Illuminate\Support\Facades\Cache;

it('returns paginated quotes', function () {

    $response = $this->getJson('/api/quotes?page=1&per_page=2');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data',
            'total',
            'page',
            'per_page'
        ]);
});

it('returns a single quote by id', function () {

    $response = $this->getJson('/api/quotes/20');
    
    $response->assertStatus(200)
        ->assertJson([
            'id' => 20,
            'quote' => 'The less of the World, the freer you live.',
            'author' => 'Umar ibn Al-Khattāb (R.A)'
        ]);
});
