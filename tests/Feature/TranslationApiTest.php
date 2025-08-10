<?php

namespace Tests\Feature;

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Locale;
use App\Models\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TranslationApiTest extends TestCase
{
    use RefreshDatabase;

    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test user with API token
        $this->token = 'testtoken123';
        User::factory()->create([
            'api_token' => $this->token
        ]);

        // Create some locales for testing
        Locale::factory()->create(['code' => 'en', 'name' => 'English']);
    }

    /** @test */
    public function it_creates_a_translation_via_api()
    {
        $locale = Locale::first();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->postJson('/api/translations', [
            'key' => 'welcome_message',
            'locale_id' => $locale->id,
            'content' => 'Welcome!',
            'tags' => 'mobile'
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['key' => 'welcome_message']);

        $this->assertDatabaseHas('translations', ['key' => 'welcome_message']);
    }

    public function it_updates_a_translation_via_api()
    {
        $locale = Locale::first();

        $translation = Translation::factory()->create([
            'locale_id' => $locale->id,
            'key' => 'old_key',
            'content' => 'Old content',
            'tags' => 'mobile'
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->putJson("/api/translations/{$translation->id}", [
            'key' => 'updated_key',
            'locale_id' => $locale->id,
            'content' => 'Updated content',
            'tags' => 'desktop'
        ]);

        $response->assertStatus(200)
                ->assertJsonFragment(['key' => 'updated_key']);

        $this->assertDatabaseHas('translations', [
            'id' => $translation->id,
            'key' => 'updated_key',
            'content' => 'Updated content',
            'tags' => 'desktop'
        ]);
    }

    /** @test */
    public function it_returns_translations_with_filters()
    {
        $locale = Locale::first();

        Translation::factory()->count(2)->create(['locale_id' => $locale->id, 'tags' => 'mobile']);
        Translation::factory()->count(3)->create(['locale_id' => $locale->id, 'tags' => 'desktop']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->getJson('/api/translations?tag=mobile');

        $response->assertStatus(200);
        $this->assertCount(2, $response->json());
    }

    /** @test */
    public function it_exports_translations_as_json()
    {
        $locale = Locale::first();
        Translation::factory()->count(5)->create(['locale_id' => $locale->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->getJson('/api/translations/export');

        $response->assertStatus(200)
                 ->assertJsonCount(5);
    }
}
