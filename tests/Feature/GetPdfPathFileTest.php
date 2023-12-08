<?php


use App\Models\User;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\getJson;

it('get pdf path file', function () {

    User::factory()->count(10)->create();
    $fileName = str()->slug(now()->format('Y-m-d H:i:s')) . ".pdf";

    $url = asset( Storage::url("users/pdf/{$fileName}") );

    $response = getJson('api/users/pdf')
        ->assertOk();

    expect($response->content())
        ->toBeString()
        ->and($response->json('url'))
        ->toBe($url);
});
