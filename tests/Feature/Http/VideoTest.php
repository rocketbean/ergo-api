<?php

namespace Tests\Feature\Http;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\Feature\Http\TestHelper;
use App\Models\Video;
class VideoTest extends TestCase
{
    use RefreshDatabase, WithFaker, TestHelper;
    /**
     * A basic video test
     "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/VideoTest
     * @test void
     */
    public function can_be_uploaded()
    {
      $this->withoutExceptionHandling();
        $video = $this->uploadVideo(UploadedFile::fake()->create('avatar.mp4',11204));
        $video->assertSuccessful();
    }
}
