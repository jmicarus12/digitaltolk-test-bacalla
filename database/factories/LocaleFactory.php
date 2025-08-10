<?php

namespace Database\Factories;

use App\Models\Locale;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocaleFactory extends Factory
{
    protected $model = Locale::class;

    public function definition()
    {
        return [
            'code' => 'en',
            'name' => 'English',
        ];
    }
}
