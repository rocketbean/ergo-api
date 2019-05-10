<?php

namespace Tests\Feature\Http;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\Feature\Http\TestHelper;
use App\Models\File;

class FileTest extends TestCase
{
    use RefreshDatabase, WithFaker, TestHelper;
    /**
     * A basic video test
     "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/FileTest
     * @test void
     */
    public function can_be_uploaded()
    {
        $this->withoutExceptionHandling();
        $file = $this->uploadFile(UploadedFile::fake()->create('doc.txt', 1202));
        $file->assertSuccessful();
        $file = $file->decodeResponseJson();
        $this->assertDatabaseHas('fileables', [
            'file_id' => $file['id']
        ]);
    }
}
