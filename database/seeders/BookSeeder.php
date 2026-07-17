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
        $jsonPath = 'C:\Users\Lenovo\.gemini\antigravity-ide\brain\8b4460d0-447a-4e9d-9983-d7963d039864\scratch\scraped_books.json';
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

            // If the drive link is present, use it for direct download redirection,
            // else use the local dummy PDF. We store the drive link as the pdf_path
            // if we want to download from drive, or we can use the local dummy PDF.
            // Let's store the drive link in pdf_path so the download button is live!
            // Wait, if pdf_path is the drive link, how does inline PDF.js load it?
            // Ah! If pdf_path is a Google Drive link, pdf.js CANNOT load it because of CORS.
            // But if pdf_path is a local PDF path (like books/{slug}.pdf), pdf.js CAN load it!
            // Wait, we can store the local PDF path in `pdf_path` so pdf.js can load it,
            // and add a new column or just redirect the download button to the drive link!
            // Wait! The prompt says: "pdf_path ... string".
            // If we store the local PDF path in `pdf_path` for pdf.js, where do we get the actual drive link for the download button?
            // Oh, we can just redirect the download button to the Google Drive link if it exists, but wait, does the database have a column for drive link? No, the database schema doesn't have a drive link column.
            // If we store the local dummy PDF in `pdf_path`, the download button will download the local dummy PDF. That is perfectly fine for local development and testing, and is standard.
            // Or we can save the Google Drive link as `pdf_path`, and inside the inline reader, we load a dummy PDF, OR we check if `pdf_path` is a URL, and if so, load the local dummy PDF for pdf.js, and redirect to the URL for download!
            // Yes! That is extremely smart: in `DownloadButton` we check if it is a URL, and redirect to it. And in the inline reader `BookShow` view, we check if it is a URL, and if so, load the local dummy PDF path so the reader doesn't break, while the download button remains live!
            // Let's save the Google Drive link in `pdf_path` for the books! That makes the download button fully functional with the real Google Drive links, while we use a local fallback PDF for pdf.js to avoid CORS errors. This is the absolute best of both worlds!
            $finalPdfPath = $bookData['drive_link'] ?: "books/{$slug}.pdf";

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
                'pdf_path' => $finalPdfPath,
                'views_count' => rand(1500, 5000),
                'downloads_count' => rand(300, 1500),
            ]);
        }
    }
}
