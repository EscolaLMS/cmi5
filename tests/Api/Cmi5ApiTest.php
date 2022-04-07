<?php

namespace EscolaLms\Cmi5\Tests\Api;

use EscolaLms\Cmi5\Database\Seeders\Cmi5PermissionSeeder;
use EscolaLms\Cmi5\Models\Cmi5;
use EscolaLms\Cmi5\Models\Cmi5Au;
use EscolaLms\Cmi5\Tests\TestCase;
use EscolaLms\Core\Tests\CreatesUsers;
use EscolaLms\Lrs\Database\Seeders\LrsSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;

class Cmi5ApiTest extends TestCase
{
    use DatabaseTransactions, CreatesUsers;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(Cmi5PermissionSeeder::class);
        $this->seed(LrsSeeder::class);
    }

    public function cmiFileProvider(): array
    {
        return [
            [
                'file' => 'cmi5.zip',
                'au_amount' => 1
            ],
            [
                'file' => 'cmi5_multi_au_framed.zip',
                'au_amount' => 8
            ],
        ];
    }

    /**
     * @dataProvider cmiFileProvider
     */
    public function testUploadCmi5(string $fileName, int $auAmount): void
    {
        Storage::fake();
        $file = $this->getCmi5UploadedFile($fileName);
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin, 'api')
            ->json('POST', '/api/admin/cmi5', ['file' => $file]);

        $response->assertCreated();
        $response->assertJsonCount($auAmount, 'data.au');
        $response->assertJsonStructure([
            'data' => [
                'id',
                'iri',
                'title',
                'au' => [[
                    'id',
                    'title',
                    'url'
                ]]
            ]
        ]);
    }

    public function testUploadInvalidCmi5(): void
    {
        Storage::fake();
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin, 'api')
            ->json(
                'POST',
                '/api/admin/cmi5',
                ['file' => UploadedFile::fake()->create('cmi5.zip', 100, 'application/zip')]
            );

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['file' => 'Invalid cmi5 file.']);
    }

    public function testUploadCmi5Unauthorized(): void
    {
        $response = $this->json('POST','/api/admin/cmi5');
        $response->assertUnauthorized();
    }

    public function testUploadCmi5Forbidden(): void
    {
        $student = $this->makeStudent();
        $response = $this->actingAs($student, 'api')->json('POST','/api/admin/cmi5');
        $response->assertForbidden();
    }

    public function testIndexCmi5(): void
    {
        Cmi5::factory()
            ->has(Cmi5Au::factory()->count(2), 'aus')
            ->count(5)
            ->create();

        $admin = $this->makeAdmin();
        $response = $this
            ->actingAs($admin, 'api')
            ->json('GET','/api/admin/cmi5');

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
        $response->assertJsonCount(2, 'data.0.au');

        $this->assertJsonStructure($response);
    }

    public function testPaginationIndexCmi5(): void
    {
        Cmi5::factory()
            ->has(Cmi5Au::factory(), 'aus')
            ->count(25)
            ->create();

        $admin = $this->makeAdmin();

        $response = $this
            ->actingAs($admin, 'api')
            ->json('GET','/api/admin/cmi5?per_page=10');

        $response->assertOk();
        $response->assertJsonCount(10, 'data');
        $this->assertJsonStructure($response);

        $response = $this
            ->actingAs($admin, 'api')
            ->json('GET','/api/admin/cmi5?page=3&per_page=10');

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
        $this->assertJsonStructure($response);
    }

    public function testGetPlayer(): void
    {
        $user = $this->makeAdmin();
        $token = $user->createToken("EscolaLMS User Token")->accessToken;

        $file = $this->getCmi5UploadedFile('cmi5.zip');
        $response = $this
            ->withHeaders([
                'Authorization' => "Bearer {$token}"
            ])
            ->json('POST', '/api/admin/cmi5', ['file' => $file]);
        $cmi5IdAu = $response->getData()->data->au[0]->id;

        $response = $this
            ->withHeaders([
                'Authorization' => "Bearer {$token}"
            ])
            ->json('GET', '/api/admin/cmi5/player/' . $cmi5IdAu);
        $response->assertOk();
        $response->assertViewIs('cmi5::player');
    }

    private function getCmi5UploadedFile(string $fileName): UploadedFile
    {
        $filepath = realpath(__DIR__ . '/../mocks/' . $fileName);
        $storagePath = Storage::path($fileName);

        copy($filepath, $storagePath);

        return new UploadedFile($storagePath, $fileName, 'application/zip', null, true);
    }

    private function assertJsonStructure(TestResponse $response): void
    {
        $response->assertJsonStructure([
            'data' => [[
                'id',
                'iri',
                'title',
                'au' => [[
                    'id',
                    'title',
                    'url'
                ]]
            ]]
        ]);
    }
}
