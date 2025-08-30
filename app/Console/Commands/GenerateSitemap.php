<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Carrental;
use App\Models\Tourpackage;
use App\Models\Blog;
use App\Models\Blogcat;

class GenerateSitemap extends Command
{
    protected $signature = 'app:generate-sitemap';
    protected $description = 'Generate the sitemap.xml for the website.';

    public function handle()
    {
        $this->info('Generating sitemap...');

        // Membuat objek sitemap tanpa argumen
        $sitemap = Sitemap::create();

        // Dapatkan URL dasar dari konfigurasi
        $baseUrl = config('app.url');

        // Tambahkan halaman statis dari web.php menggunakan URL absolut
        $sitemap->add(Url::create($baseUrl . '/'));
        $sitemap->add(Url::create($baseUrl . '/rental-mobil'));
        $sitemap->add(Url::create($baseUrl . '/paket-wisata'));
        $sitemap->add(Url::create($baseUrl . '/blog'));

        // Tambahkan URL dinamis dari model Carrental
        Carrental::get()->each(function (Carrental $carrental) use ($sitemap, $baseUrl) {
            $sitemap->add(
                Url::create("{$baseUrl}/rental-mobil/{$carrental->slug}")
                    ->setLastModificationDate($carrental->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        });

        // Tambahkan URL dinamis dari model Tourpackage
        Tourpackage::get()->each(function (Tourpackage $tourpackage) use ($sitemap, $baseUrl) {
            $sitemap->add(
                Url::create("{$baseUrl}/paket-wisata/{$tourpackage->slug}")
                    ->setLastModificationDate($tourpackage->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        });

        // Tambahkan URL dinamis dari model Blog
        Blog::get()->each(function (Blog $blog) use ($sitemap, $baseUrl) {
            $sitemap->add(
                Url::create("{$baseUrl}/blog/{$blog->slug}")
                    ->setLastModificationDate($blog->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        });

        // Tambahkan URL dinamis dari kategori blog
        Blogcat::get()->each(function (Blogcat $blogcat) use ($sitemap, $baseUrl) {
            $sitemap->add(
                Url::create("{$baseUrl}/blog/category/{$blogcat->slug}")
                    ->setLastModificationDate($blogcat->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.7)
            );
        });

        // Simpan sitemap.xml di folder 'public'
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully!');
    }
}
