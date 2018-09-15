<?php

namespace App\Http\Controllers;

use App\Services\TwitterService;

class TwitterController extends Controller {

    protected $service;

    public function __construct(TwitterService $service) {
        $this->service = $service;
    }

    public function search() {
        $twitterResult = $this->service->search(htmlentities('"#Kidspot" OR "@KidspotSocial" OR "Kidspot" OR "from:KidspotSocial"'));
        return response()->json($twitterResult);
    }

}
