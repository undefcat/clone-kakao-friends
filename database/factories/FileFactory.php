<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\File;

class FileFactory extends Factory
{
    protected $model = File::class;

    public function definition()
    {
        [$mimeType, $mimeSubtype] = explode('/', $this->faker->mimeType);
        $imagePath = $this->faker->image(storage_path('test/images'));
        $ext = collect(explode('.', $imagePath))->pop();

        return [
            'size' => $this->faker->numberBetween(1024, 1024*1024),
            'tag' => $this->faker->word,
            'mime_type' => $mimeType,
            'mime_subtype' => $mimeSubtype,
            'original_name' => $this->faker->word.$ext,
            'path' => $imagePath,
        ];
    }
}
