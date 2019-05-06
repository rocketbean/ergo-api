<?php

namespace Tests\Feature\Http;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\Feature\Http\TestHelper;
use App\Models\Photo;
class PhotoTest extends TestCase
{
    use RefreshDatabase, WithFaker, TestHelper;
    /**
     * A basic image test
     "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/PhotoTest
     * @test void
     */
    public function can_be_uploaded()
    {
        $photo = $this->uploadPhoto(UploadedFile::fake()->image('avatar.jpg', 480, 640));
        $photo->assertSuccessful();
    }
}
