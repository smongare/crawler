<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use App\Models\Data;

class ScraperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $client = new Client();

        // Send request to the website
        $crawler = $client->request('GET', 'https://repository.maseno.ac.ke/discover?query=building');
        //https://www.maseno.ac.ke/school-of-agriculture-research
       
        //Custom search specific text
        
        //https://repository.maseno.ac.ke/discover?query=building
        $publications = $crawler->filter('.col-sm-9')->each(function ($node) {
        
        //dump($node->filter('.col-sm-9')->text());
        $title = $node->filter('.col-sm-9')->text();
        
        //$title=$node->filter('h4')->attr('href');
                  return [
                            'title'=>$title
                         ];
              
        });
        
     
        // Data::Insert(foreach ($publications as $key => $value) {
        //      $p = new Data;
        //      $p->title=$value;
        //      $p->save();
        // }

        $publications = array_values(array_filter($publications));

        return view('welcome')->with('publications', $publications);
    }


}