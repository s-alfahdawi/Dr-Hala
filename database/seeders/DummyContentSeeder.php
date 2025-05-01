<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Certificate;
use App\Models\Testimonial;
use Illuminate\Support\Str;

class DummyContentSeeder extends Seeder
{
    public function run(): void
    {
        // 📰 مقالات
        for ($i = 1; $i <= 10; $i++) {
            Article::create([
                'title' => "Article Title $i",
                'content' => "This is sample content for article number $i. " . Str::random(100),
                'images' => [
                    "https://picsum.photos/seed/article{$i}a/800/600",
                    "https://picsum.photos/seed/article{$i}b/800/600",
                ],
            ]);
        }

        // 🎓 شهادات
        for ($i = 1; $i <= 10; $i++) {
            Certificate::create([
                'title' => "Certificate $i",
                'specialty' => ['Cardiology', 'Neurology', 'Dentistry', 'Pediatrics'][rand(0, 3)],
                'year_obtained' => rand(2005, 2024),
                'image' => "https://picsum.photos/seed/cert{$i}/400/300",
            ]);
        }

        // 💬 توصيات
        for ($i = 1; $i <= 10; $i++) {
            Testimonial::create([
                'name' => "User $i",
                'text' => "“This clinic changed my life!” – User $i. " . Str::random(40),
            ]);
        }
    }
}