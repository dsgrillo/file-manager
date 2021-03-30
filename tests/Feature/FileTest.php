<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FileTest extends TestCase
{
    use RefreshDatabase;
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_list_files()
    {
        $response = $this->get(route('file.list'));

        $response->assertSuccessful();
    }

    public function test_upload_file()
    {
        $fileName = 'THE_FILE_NAME';
        $response = $this->post(route('file.new'), [
            'name' => $fileName,
            'extension' => 'jpeg',
            'size' => 1024
        ]);

        $response->assertCreated();

        $file = File::where('name', $fileName)->where('user_id', $this->user->id)->first();
        $this->assertNotNull($file);
    }
}
