<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\TranslationManagementService;
use App\Models\Translation;
use App\Models\Locale;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TranslationManagementServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TranslationManagementService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(TranslationManagementService::class);
    }

    /** @test */
    public function it_creates_a_translation()
    {
        $locale = Locale::factory()->create(['code' => 'en', 'name' => 'English']);

        $translation = $this->service->create([
            'key' => 'welcome_message',
            'locale_id' => $locale->id,
            'content' => 'Welcome!',
            'tags' => 'mobile'
        ]);

        $this->assertInstanceOf(Translation::class, $translation);
        $this->assertDatabaseHas('translations', ['key' => 'welcome_message']);
    }

    /** @test */
    public function it_updates_a_translation()
    {
        $locale = Locale::factory()->create(['code' => 'en', 'name' => 'English']);
        $translation = Translation::factory()->create(['locale_id' => $locale->id]);

        $updated = $this->service->update($translation->id, [
            'key' => 'updated_key',
            'locale_id' => $locale->id,
            'content' => 'Updated Content',
            'tags' => 'desktop'
        ]);

        $this->assertEquals('updated_key', $updated->key);
        $this->assertDatabaseHas('translations', ['key' => 'updated_key']);
    }

    /** @test */
    public function it_filters_translations_by_tag()
    {
        $locale = Locale::factory()->create(['code' => 'en', 'name' => 'English']);
        Translation::factory()->count(2)->create(['locale_id' => $locale->id, 'tags' => 'mobile']);
        Translation::factory()->count(3)->create(['locale_id' => $locale->id, 'tags' => 'desktop']);

        $results = $this->service->getAll(['tag' => 'mobile']);

        $this->assertCount(2, $results);
    }
}
