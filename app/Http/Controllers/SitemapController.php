<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $baseUrl = url('/');

        $jobs = JobListing::where('status', 'active')
            ->orderBy('updated_at', 'desc')
            ->limit(500)
            ->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">';

        // 1. Homepage / Main Map
        $xml .= '<url>';
        $xml .= '<loc>' . htmlspecialchars($baseUrl) . '</loc>';
        $xml .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
        $xml .= '<changefreq>daily</changefreq>';
        $xml .= '<priority>1.0</priority>';
        $xml .= '</url>';

        // 2. Auth Pages
        $staticRoutes = [
            '/masuk'                => ['daily', '0.8'],
            '/daftar/pelamar'       => ['weekly', '0.9'],
            '/daftar/pemberi-kerja' => ['weekly', '0.8'],
        ];

        foreach ($staticRoutes as $path => [$freq, $priority]) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($baseUrl . $path) . '</loc>';
            $xml .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
            $xml .= '<changefreq>' . $freq . '</changefreq>';
            $xml .= '<priority>' . $priority . '</priority>';
            $xml .= '</url>';
        }

        // 3. Dynamic Active Jobs
        foreach ($jobs as $job) {
            $jobUrl = route('applicant.job.detail', $job->id);
            $lastMod = $job->updated_at ? $job->updated_at->format('Y-m-d') : date('Y-m-d');

            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($jobUrl) . '</loc>';
            $xml .= '<lastmod>' . $lastMod . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }
}
