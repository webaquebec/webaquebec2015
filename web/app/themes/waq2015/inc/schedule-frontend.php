<?php
/*------------------------------------*\
    SCHEDULE - FRONT END
\*------------------------------------*/

// COMPOSER REQUIRE
// composer require wpackagist-plugin/acf-range-field:dev-trunk 
// composer require wpackagist-plugin/acf-field-date-time-picker:dev-trunk
// composer require wpackagist-plugin/intuitive-custom-post-order:dev-trunk


//
//
// HELPER
class helper{


  protected function sort_sessions($a, $b){
    if($a->time_start == $b->time_start){
      if($a->col_start == $b->col_start) return 0;
      return ($a->col_start < $b->col_start) ? -1 : 1;
    }
    return  ($a->time_start < $b->time_start)  ? -1 : 1;
  }

  protected function array_empty_columns($count, $timestamp){
    $cols = array();
    $i = 0;
    while($i<$count){
      array_push($cols, 0);
      $i++;
    }
    if(has($timestamp)) $cols['time'] = strftime('%H:%M', $timestamp);
    return $cols;
  }

  protected function print_empty_cells($timekey){
    $str = '';
    foreach($this->grid[$timekey] as $session_ID)
      if($session_ID==0)
        $str .= '<td></td>';
    return $str;
  }

  protected function throw_message($str){
    if(!isset($this->messages)) $this->messages = array();
    array_push($this->messages, $str);
  }

  protected function throw_error($str){
    if(!isset($this->errors)) $this->errors = array();
    array_push($this->errors, $str);
  }

}


//
//
// SESSION
class session extends helper{
  
  public function __construct($ID) {
    if(isset($ID)){
      
      //
      // SESSION
      $this->ID = $ID;
      $this->title = get_the_title($this->ID);
      $this->is_linked = get_field('link_to_post', $this->ID);
      $this->permalink = get_the_permalink($this->ID);
      $this->excerpt = get_field('excerpt', $this->ID);
      $this->content = apply_filters('the_content',get_the_content($this->ID));
      $this->themes = wp_get_post_terms($this->ID, 'theme');

      //
      // SPEAKER
      $about = get_field('about', $this->ID);
      $this->speaker = (object) array(
        'image' => $about[0]['infos'][0]['image'],
        'name' => $about[0]['infos'][0]['name'],
        'job' => $about[0]['infos'][0]['job'],
        'bio' => $about[0]['bio'],
        'social' => $about[0]['infos'][0]['social']
      );

      //
      // LOCATION
      $location_ID = get_field('location', $this->ID);
      $location_query = new WP_query(array(
        'post_type' => 'location',
        'posts_per_page' => 1,
        'p' => $location_ID
      ));

      $location = $location_query->posts[0];
      $location_infos = get_field('infos', $location->ID);
      $location_labels = $location_infos[0]['labels'];
      $location_settings = $location_infos[0]['settings'];
      $title = $location_labels[0]['alt'];
      if(!has($title)) $title = get_the_title($location->ID);
      
      $this->location = (object) array(
        'ID' => $location_ID,
        'hide' => $location_labels[0]['hide'],
        'title' => $title,
        'subtitle' => $location_labels[0]['subtitle'],
        // -------------------------------------
        'class' => $location_settings[0]['class'],
        'color' => $location_settings[0]['color'],
      );

      //
      // GRID
      $grid = array();
      $grid_ID = get_field('grid', $this->ID);
      $this->date = DateTime::createFromFormat('d/m/y', get_field('date', $grid_ID))->getTimestamp();
      $this->grid = get_the_title($grid_ID);

      $timeframes = get_field('time_frames', $grid_ID);
      $column_count = get_field('columns_qty','options');
      foreach($timeframes as $frame){
        $frame = $frame['frame'][0];
        if(!isset($grid[$frame['start']]))
          $grid[$frame['start']] = $this->array_empty_columns($column_count, $frame['start']);
        if(!isset($times[$frame['end']]))
          $grid[$frame['end']] = $this->array_empty_columns($column_count, $frame['end']);
      }

      //
      // TIME
      $frame_ID = get_field('frame_'.$grid_ID, $this->ID);
      $frame = array(
        'start' => $timeframes[$frame_ID]['frame'][0]['start'],
        'end' => $timeframes[$frame_ID]['frame'][0]['end'],
      );

      $time_start_key = array_search($frame['start'], array_keys($grid));
      $time_end_key = array_search($frame['end'], array_keys($grid));
      $frame['span'] = $time_end_key - $time_start_key;

      $this->time = (object) array(
        'start' => $frame['start'],
        'end' => $frame['end'],
        'span' => $frame['span']
      );

      //
      // COLUMNS
      $this->columns = (object) array(
        'range' => $location_settings[0]['range'],
        'start' => $location_settings[0]['range']['min'],
        'end' => $location_settings[0]['range']['max'],
        'span' => ($location_settings[0]['range']['max'] - $location_settings[0]['range']['min']) + 1,
      );
    }

    return false;
  }
}


//
//
// SCHEDULE
class schedule extends helper{

  //
  //
  // CONSTRUCTOR

  function __construct($args){
  
    $options = array_merge(array(
      'grid_ID'=>null,
      'column_headers'=>false,
      'time_labels'=>false,
    ),$args);
  
    // VARIABLES
    $this->grid_ID = $options['grid_ID'];
   
    // GET locationS
    $locationsQuery = new WP_query(array(
        'post_type' => 'location',
        'posts_per_page' => -1,
      ));
    
    $this->locations = array();
    
    foreach($locationsQuery->posts as $location){
      $infos = get_field('infos', $location->ID);
      $labels = $infos[0]['labels'];
      $settings = $infos[0]['settings'];
      $title = $labels[0]['alt'];
      if(!has($title)) $title = get_the_title($location->ID);
      
      $this->locations[$location->ID] = array(
          'ID' => $location->ID,
          'hide' => $labels[0]['hide'],
          'title' => $title,
          'subtitle' => $labels[0]['subtitle'],
          // -------------------------------------
          'class' => $settings[0]['class'],
          'color' => $settings[0]['color'],
          'range' => $settings[0]['range'],
          'col_start' => $settings[0]['range']['min'],
          'col_end' => $settings[0]['range']['max'],
          'col_span' => ($settings[0]['range']['max'] - $settings[0]['range']['min']) + 1,
        );

    }

 
    // GET TIMEFRAMES
    $this->timeframes = get_field('time_frames', $this->grid_ID);
    $this->grid = array();
    $this->column_count = get_field('columns_qty','options');
    if($this->timeframes){
      foreach($this->timeframes as $frame){
        $frame = $frame['frame'][0];
        if(!isset($this->grid[$frame['start']]))
          $this->grid[$frame['start']] = $this->array_empty_columns($this->column_count, $frame['start']);
        if(!isset($times[$frame['end']]))
          $this->grid[$frame['end']] = $this->array_empty_columns($this->column_count, $frame['end']);
      }
    }
    else{
      $this->throw_message('No timeframe found for this grid');
    } 

  
    // GET SESSIONS
    $sessionsQuery = new WP_query(array(
        'post_type' => 'session',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'grid',
                'compare' => '=',
                'value' => $this->grid_ID,
            )
          ),
      ));
    
    var_dump($sessionsQuery);
    $this->sessions = array();
    foreach($sessionsQuery->posts as $session){
      $session = new session($session->ID);
      // var_dump($session);
      array_push($this->sessions, $session);
    }
      
    //   $location_ID = get_field('location', $session->ID);
    //   $frame_ID = get_field('frame_'.$this->grid_ID, $session->ID);

    //   // if(isset($location_ID) && isset($frame_ID)){

    //     $location = $this->locations[$location_ID];
    //     $frame = array(
    //         'start' => $this->timeframes[$frame_ID]['frame'][0]['start'],
    //         'end' => $this->timeframes[$frame_ID]['frame'][0]['end'],
    //       );
    //     $time_start_key = array_search($frame['start'], array_keys($this->grid));
    //     $time_end_key = array_search($frame['end'], array_keys($this->grid));
    //     $time_span = $time_end_key - $time_start_key;

    //     // POPULATE $this->grid
    //     $time_counter = $time_start_key;
    //     while($time_counter<$time_end_key){
    //       $timekey = array_keys($this->grid)[$time_counter];
    //       $location_counter = 0;
    //       while($location_counter<$this->column_count){
    //         if( ( $location_counter >= $location['col_start']-1
    //               && $location_counter <= $location['col_end']-1 )
    //             && $this->grid[$timekey][$location_counter] == 0){
    //           $this->grid[$timekey][$location_counter] = $session->ID;
    //         }
    //         $location_counter++;
    //       }
    //       $time_counter++;
    //     }
      
    //     array_push($this->sessions, new session_object(array(
    //         'ID' => $session->ID,
    //         'title' => get_the_title($session->ID),
    //         'permalink' => get_the_permalink($session->ID),
    //         'link_to_post' => get_field('link_to_post', $session->ID),
    //         'excerpt' => get_field('excerpt', $session->ID),
    //         'class' => $location['class'],
    //         'location' => $location['title'],
    //         'location_ID' => $location_ID,
    //         'location_hidden' => $location['hide'],
    //         'time_start' => $frame['start'],
    //         'time_end' => $frame['end'],
    //         'time_span' => $time_span,
    //         'col_start' => $location['col_start'],
    //         'col_end' => $location['col_end'],
    //         'col_span' => $location['col_span'],
    //       )));
    // }

    // SORT SESSIONS
    usort($this->sessions, array('schedule','sort_sessions'));
    
    // SET COUNTERS
    $this->session_count = count($this->sessions);
    $this->session_counter = 0;
    $this->timeframe_count = count($this->grid);
    $this->timeframe_counter = 0;
    $this->column_counter = 0;
  }


  //
  //
  // LOOP THROUGH SESSSONS
  public function have_sessions(){
    return (!isset($this->error) && $this->session_counter < $this->session_count);
  }


  //
  //
  // PRINT HTML BEFORE CURRENT SESSION
  public function before_session(){
    $this->current_session = $this->sessions[$this->session_counter];
    $this->session_counter++;
    $this->column_counter++;
    $session = $this->current_session;
    $timekey = array_keys($this->grid)[$this->timeframe_counter];
    while(  $session->time_start > $timekey 
            && $this->timeframe_counter < $this->timeframe_count)
    {
      echo $this->print_empty_cells($timekey) . '</tr><tr>';
      $this->timeframe_counter++;
      $timekey = array_keys($this->grid)[$this->timeframe_counter];
    }

    if($this->session_counter==1){
      echo '<table>';
      echo '<tbody>';
      echo '<tr>';
    } 

    if( $session->time_start == $timekey
        && $session->col_start == $this->column_counter)
    {
      echo '<td'.($session->time_span>1 ? ' rowspan="'.$session->time_span.'"' : '').($session->col_span>1 ? ' colspan="'.$session->col_span.'"' : '').'>';
    }
  }



  //
  //
  // SETUP CURRENT SESSION
  public function the_session(){
    return new session($this->current_session->ID);
  }
  //
  //
  // PRINT HTML AFTER CURRENT SESSION
  public function after_session(){
    $session = $this->current_session;
    $timekey = array_keys($this->grid)[$this->timeframe_counter];
    $new_row =  $this->timeframe_counter<$this->timeframe_count 
                && $this->column_counter+$session->col_span>$this->column_count;    

    if( $session->time_start == $timekey 
        && $session->col_start == $this->column_counter ){     
      echo '</td>';
    }
    if($new_row && $this->session_counter < $this->session_count){
      echo '</tr>';
      echo '<tr>';
      $this->timeframe_counter++;
      $this->column_counter = 0;
    }

    if($this->session_counter >= $this->session_count){
      echo '</tr>';
      echo '</tbody>'; 
      echo '</table>';
    } 
  }
}



?>