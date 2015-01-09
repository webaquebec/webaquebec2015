<?php

require_once(__DIR__.'/../vendor/twitter-api-php/TwitterAPIExchange.php');
require_once(__DIR__.'/../vendor/Instagram-PHP-API/src/Instagram.php');


//
//
// POST OBJECT
class socialpost{
  
  public function __construct($feed) {
    $props = $feed->feed[$feed->post_counter-1];
    foreach($props as $k => $v){
      $this->$k = $v;
    }
  }


}

//
//
// FEED
class socialfeed{
  private $data;

  public function __get($key) {
    return isset($this->data[$key]) ? $this->data[$key] : false;
  } 

  function __construct($args) {
    $this->count = isset($args['count']) ? $args['count'] : 10;
    $this->tag = isset($args['tag']) ? $args['tag'] : 'o2web';
    $this->socialFeed();

  }

  private function get_twitter(){
    $twitter = new TwitterAPIExchange(array(
        'consumer_key'=>'***REMOVED***',
        'consumer_secret'=>'***REMOVED***',
        'oauth_access_token'=>'***REMOVED***',
        'oauth_access_token_secret'=>'***REMOVED***'
      ));
    
    $url = 'https://api.twitter.com/1.1/search/tweets.json';
    $getfield = '?q=#'.$this->tag.'&count='.$this->count;
    $requestMethod = 'GET';
    
    $tweets = $twitter->setGetfield($getfield)
      ->buildOauth($url, $requestMethod)
      ->performRequest();

    return $tweets;
  }

  private function get_instagram(){
    $instagram = new MetzWeb\Instagram\Instagram('***REMOVED***');
    $pics = $instagram->getTagMedia($this->tag, $this->count);
    return $pics;

  }



  public function socialFeed(){
    // RESULT FEED
    $this->feed = array();



    // TWITTER
    $twitter_json = $this->get_twitter();
    $this->twitter_feed = json_decode($twitter_json);
    $i=0;
    foreach($this->twitter_feed->statuses as $post){
      array_push( $this->feed, array(
          'type' => 'tweet',
          'timestamp' => strtotime($post->created_at),
          'name' => $post->user->name,
          'username' => $post->user->screen_name,
          'profile_picture' => $post->user->profile_image_url,
          'profile_url' => 'https://twitter.com/'.$post->user->screen_name,
          'text' => $post->text,
        )
      );
      $i++;
    // $this->feed = array_slice($this0)
      
    }
    

    // INSTAGRAM
    $this->instagram_feed = $this->get_instagram();
    foreach($this->instagram_feed->data as $post){
    
     // print_r($post);

      array_push( $this->feed, array(
          'type' => $post->type,
          'timestamp' => $post->created_time,
          'name' => $post->user->full_name,
          'username' => $post->user->username,
          'profile_picture' => $post->user->profile_picture,
          'profile_url' => 'http://instagram.com/'.$post->user->username,
          'text' => $post->caption->text,
          'images' => $post->images,
          'video' => isset($post->videos) ? $post->videos : null,

        )
      );

    }
    // die;
    // SET COUNTERS
    $this->post_count = count($this->feed);
    $this->post_counter = 0;
  }

  //
  //
  // LOOP THROUGH POSTS
  public function have_posts(){
    return ($this->post_counter < $this->post_count);
  }

  //
  //
  // LOOP THROUGH POSTS
  public function the_post(){
    $this->post_counter++;
    return new socialpost($this);
  }
  

}


?>