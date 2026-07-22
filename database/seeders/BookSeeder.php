<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/scraped_books.json');
        if (!file_exists($jsonPath)) {
            $this->command->error("Scraped JSON file not found!");
            return;
        }

        $scrapedBooks = json_decode(file_get_contents($jsonPath), true);
        
        // Ensure storage books directory exists
        Storage::disk('public')->makeDirectory('books');

        // Create a minimal valid 1-page PDF string
        $dummyPdfContent = "%PDF-1.4\n" .
            "1 0 obj <</Type/Catalog/Pages 2 0 R>> endobj\n" .
            "2 0 obj <</Type/Pages/Kids[3 0 R]/Count 1>> endobj\n" .
            "3 0 obj <</Type/Page/Parent 2 0 R/MediaBox[0 0 595 842]/Resources<</Font<</F1 4 0 R>>>>/Contents 5 0 R>> endobj\n" .
            "4 0 obj <</Type/Font/Subtype/Type1/BaseFont/Helvetica>> endobj\n" .
            "5 0 obj <</Length 44>> stream\n" .
            "BT /F1 24 Tf 100 700 Td (Fayez Al-Zahrani Library - Book Sample) Tj ET\n" .
            "endstream\n" .
            "endobj\n" .
            "xref\n" .
            "0 6\n" .
            "0000000000 65535 f \n" .
            "0000000009 00000 n \n" .
            "0000000058 00000 n \n" .
            "0000000115 00000 n \n" .
            "0000000223 00000 n \n" .
            "0000000290 00000 n \n" .
            "trailer <</Size 6/Root 1 0 R>>\n" .
            "startxref\n" .
            "383\n" .
            "%%EOF\n";

        foreach ($scrapedBooks as $slug => $bookData) {
            $title = $bookData['title'];
            $snippet = $bookData['snippet'];
            
            // Generate clean description by removing title repetition
            $description = str_replace($title, '', $snippet);
            $description = trim(preg_replace('/^\s*|\s*$/u', '', $description));
            if (empty($description)) {
                $description = $snippet;
            }

            // Default fallback image path
            $coverPath = "books/{$slug}.jpg";
            
            // Try downloading cover image from live site
            if (!empty($bookData['cover'])) {
                $coverUrl = $bookData['cover'];
                $imageContent = @file_get_contents($coverUrl);
                if ($imageContent !== false) {
                    Storage::disk('public')->put($coverPath, $imageContent);
                    $this->command->info("Downloaded cover for: {$title}");
                } else {
                    $this->command->warn("Could not download cover for: {$title}, fallback to gradient.");
                    $coverPath = ""; // Indicates local view will fall back to gradient
                }
            } else {
                $coverPath = "";
            }

            // Write dummy PDF locally
            $pdfPath = "books/{$slug}.pdf";
            Storage::disk('public')->put($pdfPath, $dummyPdfContent);

            // Parse metadata out of the snippet where possible
            $pages = 150; // default
            if (preg_match('/عدد الصفحات:\s*(\d+)/u', $snippet, $matches)) {
                $pages = (int)$matches[1];
            } else {
                $pages = rand(50, 350);
            }

            $dimensions = "14 × 21";
            if (preg_match('/حجم الكتاب:\s*([^\n|.]+)/u', $snippet, $matches)) {
                $dimensions = trim($matches[1]);
            }

            $edition = "الطبعة الأولى";
            if (preg_match('/الطبعة:\s*([^\n|.]+)/u', $snippet, $matches)) {
                $edition = trim($matches[1]);
            }

            Book::create([
                'title' => $title,
                'slug' => $slug,
                'description' => $description,
                'edition' => $edition,
                'pages_count' => $pages,
                'dimensions' => $dimensions,
                'publisher' => 'مكتبة فايز الزهراني الرقمية',
                'published_at' => now()->subMonths(rand(1, 12)),
                'cover_path' => $coverPath,
                'pdf_path' => $pdfPath,
                'views_count' => rand(1500, 5000),
                'downloads_count' => rand(300, 1500),
            ]);
        }
    }
}
