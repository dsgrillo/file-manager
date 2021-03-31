<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\FileService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;


class FileServiceTest extends TestCase
{
    use RefreshDatabase;

    private $service;
    private $exampleFile;
    private $fileName;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake();
        $this->service = new FileService($this->user);
        $this->exampleFile = new File(resource_path('files/baby-yoda.jpg'));
        $this->fileName = "May the force be with you.";
    }

    public function test_upload_file()
    {
        $this->service->saveFile($this->fileName, $this->exampleFile);

        $fileModel = \App\Models\File::where('name', $this->fileName)->first();

        $this->assertNotNull($fileModel, 'the file was not saved on db');
        $this->assertEquals($fileModel->extension, $this->exampleFile->getExtension(), 'failed to match extension');
        $this->assertEquals($fileModel->size, $this->exampleFile->getSize(), 'failed to match size');
    }

    public function test_download_file()
    {
        $model = $this->service->saveFile($this->fileName, $this->exampleFile);

        $response = $this->service->downloadFile($model->id);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_exception_is_thrown_for_unauthorized_access()
    {
        $this->expectException(FileNotFoundException::class);
        $model = $this->service->saveFile($this->fileName, $this->exampleFile);

        $user2 = User::factory()->create();
        $service2 = new FileService($user2);

        $service2->downloadFile($model->id);
    }

    public function test_exception_is_thrown_for_non_existent_file()
    {
        $this->expectException(FileNotFoundException::class);

        $this->service->downloadFile(-1);
    }

    public function test_rename_file()
    {
        $model = $this->service->saveFile($this->fileName, $this->exampleFile);

        $newFileName = "And also with you.";
        $this->service->rename($model->id, $newFileName);

        $dbModel = \App\Models\File::findOrFail($model->id);
        $this->assertEquals($newFileName, $dbModel->name);
    }
}
