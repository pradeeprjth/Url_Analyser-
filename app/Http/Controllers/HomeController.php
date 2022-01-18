<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
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


    function get_domain_name($url) 
    {
        $result = parse_url($url);
        return $result['scheme']."://".$result['host'];
    }


    public function url(Request $request)
    {
        if($request->url){
            Log::info($request->url);
            // Validate url
            if (filter_var($request->url, FILTER_VALIDATE_URL) == true) {
                Log::info("Url is valid");
                Log::info($request->url);
                $contents = file_get_contents($request->url);
                $search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
                            '@<head>.*?</head>@siU',            // Lose the head section
                            '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
                            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
                );
                $contents = preg_replace($search, '', $contents); 
                $words = str_word_count(strip_tags($contents),1);
                $latterCount = strlen(strip_tags($contents));
                $domainName = $this->get_domain_name($request->url);
                $whatCount = substr_count(strtolower($contents),"what");
                $howCount = substr_count(strtolower($contents),"how");
                $whyCount = substr_count(strtolower($contents),"why");
                $whenCount = substr_count(strtolower($contents),"when");
                $whereCount = substr_count(strtolower($contents),"where");
                $wordsCount = count($words);
                $html = file_get_contents($request->url);
                $doc = new DOMDocument();
                @$doc->loadHTML($html);
                $imgTags = $doc->getElementsByTagName('img');
                $externalLinks = $doc->getElementsByTagName('a');
                $Paragraphs = $doc->getElementsByTagName('p');
                $numberOfParagraphs = count($Paragraphs);
                $H1 = $doc->getElementsByTagName('h1');
                $numberOfH1 = count($H1);
                $H2 = $doc->getElementsByTagName('h2');
                $numberOfH2 = count($H2);
                $H3 = $doc->getElementsByTagName('h3');
                $numberOfH3 = count($H3);
                $H4 = $doc->getElementsByTagName('h4');
                $numberOfH4 = count($H4);
                $H5 = $doc->getElementsByTagName('h5');
                $numberOfH5 = count($H5);
                $H6 = $doc->getElementsByTagName('h6');
                $numberOfH6 = count($H6);
                $numberOfVideos = $doc->getElementsByTagName('video');
                // $titleOfThePage = $doc->getElementsByTagName('title');
                $page = file_get_contents($request->url);
                $titleOfThePage = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $page, $match) ? $match[1] : null;
                $metaTags = get_meta_tags($request->url);

                // Log::info(count($imgTags));
                $imageCount = count($imgTags);
                $numberOfVideoCount = count($numberOfVideos);
                    foreach ($imgTags as $images) {
                        $split = explode("/", $images->getAttribute('src'));
                        $imageName = $split[count($split)-1];
                        $imageNameArray[] =  $imageName ;
                    }
                    foreach ($externalLinks as $links){
                        if(strpos($links->getAttribute('href'), $domainName) !== false  ){
                        $internalLinkArray[] = $links->getAttribute('href');
                        }else{
                        $externalLinkArray[] = $links->getAttribute('href');
                        }
                    }
                $countOfInternalLinks = count($internalLinkArray);
                $countOfExternalLinks = count($externalLinkArray);
                return response()->json([
                    'Number_of_words' => $wordsCount,
                    'Number_of_characters' => $latterCount,
                    'Number_of_images' => $imageCount,
                    'List_of_images' => $imageNameArray,
                    'Number_of_Internal_Urls' => $countOfInternalLinks,
                    'List_of_Internal_Urls' => $internalLinkArray,
                    'Number_of_External_urls' => $countOfExternalLinks,
                    'List_of_External_urls' => $externalLinkArray,
                    'Number_of_paragraphs' => $numberOfParagraphs,
                    'Number_of_video' => $numberOfVideoCount,
                    'Number_of_h1'=> $numberOfH1,
                    'Number_of_h2'=> $numberOfH2,
                    'Number_of_h3'=> $numberOfH3,
                    'Number_of_h4'=> $numberOfH4,
                    'Number_of_h5'=> $numberOfH5,
                    'Number_of_h6'=> $numberOfH6,
                    'Title_of_the_page' => $titleOfThePage,
                    'Meta_key_words'=> $metaTags,
                    'Number_of_what_count' => $whatCount,
                    'Number_of_how_count' => $howCount,
                    'Number_of_why_count' => $whyCount,
                    'Number_of_when_count' => $whenCount,
                    'Number_of_where_count' => $whereCount,
                ]);
            } else {
                Log::info("Url is Invalid");
                return response()->json([
                    'Status' => "False",
                    'StatusCode' => 500,
                    'Message' => "Invalid Url"
                ], 500);

            }
        
        }else{
            Log::info("No Url Found");
            return response()->json([
                'Status' => "False",
                'StatusCode' => 404,
                'Message' => "No Url found"
            ], 404);
        }
    }
}