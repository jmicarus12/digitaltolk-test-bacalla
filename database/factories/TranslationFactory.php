<?php

namespace Database\Factories;

use App\Models\Translation;
use App\Models\Locale;
use Illuminate\Database\Eloquent\Factories\Factory;

class TranslationFactory extends Factory
{
    protected $model = Translation::class;

    public function definition()
    {
        return [
            'key' => $this->faker->unique()->slug,
            'locale_id' => Locale::inRandomOrder()->first()->id ?? Locale::factory(),
            'content' => $this->faker->sentence(),
            'tags' => $this->faker->randomElement(config('translation.tags')),
        ];
    }
}
