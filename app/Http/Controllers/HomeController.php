<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use DOMDocument;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function url(Request $request)
    {
        //         $ch = curl_init();
        //  // Set URL and header options
        //         curl_setopt($ch, CURLOPT_URL, $request->url);
        //         curl_setopt($ch, CURLOPT_HEADER, 0);
        //         ob_start();
        //         curl_exec($ch);
        //         $content = ob_get_clean();
        //         curl_close($ch);	
        //         // Log::info(gettype($content));
        //         Log::info($content);
        //         // Log::info(strlen($content));
            
        //         return $content ;

        $contents = file_get_contents($request->url);

            // Get rid of style, script etc
            $search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
                    '@<head>.*?</head>@siU',            // Lose the head section
                    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
                    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
            );

            $contents = preg_replace($search, '', $contents); 

            $words = array_count_values(
                        str_word_count(
                            strip_tags($contents), 1
                            )
                        );
            $latters = 
                        strlen(
                            strip_tags($contents)
                            )
                        ;
            

            Log::info(count($words));
            Log::info("words count");
            Log::info($latters);
            Log::info("Letter count");

            $html = file_get_contents($request->url);

            $doc = new DOMDocument();
            @$doc->loadHTML($html);

            $imgTags = $doc->getElementsByTagName('img');
            $externalLinks = $doc->getElementsByTagName('a');
            $numberOfParagraphs = $doc->getElementsByTagName('p');
            $numberOfH1 = $doc->getElementsByTagName('h1');
            $numberOfH2 = $doc->getElementsByTagName('h2');
            $numberOfH3 = $doc->getElementsByTagName('h3');
            $numberOfH4 = $doc->getElementsByTagName('h4');
            $numberOfH5 = $doc->getElementsByTagName('h5');
            $numberOfH6 = $doc->getElementsByTagName('h6');
            $numberOfVideos = $doc->getElementsByTagName('video');
            // $titleOfThePage = $doc->getElementsByTagName('title');
            $page = file_get_contents($request->url);
            $titleOfThePage = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $page, $match) ? $match[1] : null;
            $metaTags = get_meta_tags($request->url);
            Log::info(count($imgTags));
            Log::info("ImageTagsCount");
            Log::info(count($externalLinks));
            Log::info("Links count");
            Log::info(count($numberOfParagraphs));
            Log::info("numberOfParagraphs");
            Log::info(count($numberOfH1));
            Log::info("Number of h1 tag");
            Log::info(count($numberOfH2));
            Log::info("Number of h2 tag");
            Log::info(count($numberOfH3));
            Log::info("Number of h3 tag");
            Log::info(count($numberOfH4));
            Log::info("Number of h4 tag");
            Log::info(count($numberOfH5));
            Log::info("Number of h5 tag");
            Log::info(count($numberOfH6));
            Log::info("Number of h6 tag");
            Log::info(count($numberOfVideos));
            Log::info("Number of videos embeded");
            Log::info($titleOfThePage);
            Log::info("titleOfThePage");
            Log::info($metaTags);
            Log::info("MetaTags");
            foreach ($imgTags as $images) {
                // Log::info( $images->getAttribute('src'));
            }
            Log::info("============================");
            foreach ($externalLinks as $links){
                // Log::info($links->getAttribute('href'));
            }
          
            // print_r($result);
    }
}