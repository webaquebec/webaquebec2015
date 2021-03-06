<?php

//
//
// POST OBJECT
class social_post{

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
class social_feed{
  private $data;

  public function __get($key) {
    return isset($this->data[$key]) ? $this->data[$key] : false;
  }


  function __construct($args=array()) {
    $this->count = isset($args['count']) ? $args['count'] : 10;
    $this->tag = isset($args['tag']) ? $args['tag'] : 'WAQ15';
    $this->social_feed();

  }

  private function sort_posts($a, $b){
    if( $a['timestamp'] == $b['timestamp']) return 0;
    return $a['timestamp']>$b['timestamp'] ? -1 : 1;
  }

  private function get_twitter(){
    $twitter = new TwitterAPIExchange(array(
        'consumer_key' => getenv('TWITTER_CONSUMER_KEY'),
        'consumer_secret' => getenv('TWITTER_CONSUMER_SECRET'),
        'oauth_access_token' => getenv('TWITTER_OAUTH_ACCESS_TOKEN'),
        'oauth_access_token_secret' => getenv('TWITTER_OAUTH_ACCESS_TOKEN_SECRET')
      ));

    $url = 'https://api.twitter.com/1.1/search/tweets.json';
    if(gettype($this->tag)=='string'){
      $getfield = '?q=#'.$this->tag.'-filter:retweets&result_type=recent&count='.$this->count;
    }
    elseif(gettype($this->tag)=='array'){
      $q = '';
      foreach($this->tag as $k=>$tag){

        if($k>0) $q .= '+OR+';
        $q .= '#'.$tag;
      }
      $getfield = '?q='.$q.'+exclude:retweets&result_type=recent&count='.$this->count;
      // var_dump($getfield);
    }
    $requestMethod = 'GET';

    $tweets = $twitter->setGetfield($getfield)
      ->buildOauth($url, $requestMethod)
      ->performRequest();

    return $tweets;
  }

  private function get_instagram(){
    $instagram = new MetzWeb\Instagram\Instagram(getenv('INSTAGRAM_API_KEY'));
    if(gettype($this->tag)=='string'){
      $pics = $instagram->getTagMedia($this->tag, $this->count)->data;
    }
    elseif(gettype($this->tag)=='array'){
      $pics = array();
      foreach($this->tag as $tag){
        $pics = array_merge($pics, $instagram->getTagMedia($tag, $this->count)->data);
      }
    }
    return $pics;

  }

  public function rich_text($text, $type){
    $text = preg_replace(
        '@(https?://([-\w\.]+)+(/([\w/_\.]*(\?\S+)?(#\S+)?)?)?)@',
         '<a href="$1">$1</a>',
        $text);
    if($type=='tweet'){
      $text = preg_replace(
          '/@(\w+)/',
          '<a href="http://twitter.com/$1">@$1</a>',
          $text);
      $text = preg_replace(
          '/\s+#([A-zÀ-ú0-9_]+)/',
          ' <a href="http://twitter.com/search?q=%23$1">#$1</a>',
          $text);
    }
    else{
      $text = preg_replace(
          '/@(\w+)/',
          '<a href="http://instagram.com/$1">@$1</a>',
          $text);
      // $text = preg_replace(
      //     '/\s+#(\w+)/',
      //     ' <a href="http://instagram.com/search?q=%23$1">#$1</a>',
      //     $text);
    }

    return $text;
  }

  public function social_feed(){
    // RESULT FEED
    $this->feed = array();


    // TWITTER
    $twitter_json = $this->get_twitter();
    $this->twitter_feed = json_decode($twitter_json);
    foreach($this->twitter_feed->statuses as $post){

      // print_r($post);
      array_push( $this->feed, array(
          'id' => $post->id,
          'type' => 'tweet',
          'timestamp' => intval(strtotime($post->created_at)),
          'name' => $post->user->name,
          'username' => $post->user->screen_name,
          'profile_picture' => $post->user->profile_image_url,
          'profile_url' => 'https://twitter.com/'.$post->user->screen_name,
          'text' => $post->text,
        )
      );
    }


    // INSTAGRAM
    $this->instagram_feed = $this->get_instagram();

    foreach($this->instagram_feed as $post){

     // print_r($post);

      array_push( $this->feed, array(
          'type' => $post->type,
          'timestamp' => intval($post->created_time),
          'name' => $post->user->full_name,
          'username' => $post->user->username,
          'profile_picture' => $post->user->profile_picture,
          'profile_url' => 'http://instagram.com/'.$post->user->username,
          'text' => $post->caption->text,
          'images' => $post->images,
          'videos' => isset($post->videos) ? $post->videos : null,

        )
      );



    }


    usort( $this->feed, array('social_feed','sort_posts'));
    $this->feed = array_slice($this->feed, 0, $this->count);

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
    return new social_post($this);
  }


}


?>