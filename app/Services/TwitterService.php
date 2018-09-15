<?php

namespace App\Services;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterService {

    protected $twitter_connection;

    public function __construct() {
        $this->twitter_connection = new TwitterOAuth(config('custom.twitter_api_key'), config('custom.twitter_api_key_secret'), config('custom.twitter_token'), config('custom.twitter_token_secret'));
    }

    public function search($text) {
        $twitterResult = $this->twitter_connection->get("search/tweets", array('q' => $text, 'count' => 100));
        //prepare return data
        $returnData = array();
        foreach ($twitterResult->statuses as $twitterVal) {
            $date = \DateTime::createFromFormat('D M d H:i:s T Y', $twitterVal->created_at);
            $returnData[] = array(
                'created_at' => ($date) ? $date->format('Y-m-d H:i:s') : $twitterVal->created_at,
                'text' => $twitterVal->text,
                'screen_name' => $twitterVal->user->screen_name,
                'image' => $twitterVal->user->profile_image_url
            );
        }
        return $returnData;
    }

}
