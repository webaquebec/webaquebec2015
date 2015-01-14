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
    if($a->time->start == $b->time->start){
      if($a->columns->start == $b->columns->start) return 0;
      return ($a->columns->start < $b->columns->start) ? -1 : 1;
    }
    return  ($a->time->start < $b->time->start)  ? -1 : 1;
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

  public function print_messages(){
    if(!isset($this->messages)) return;
    echo '<div class="messages">' . join('<br>', $this->messages) . '</div>';
  }
  public function print_errors(){
    if(!isset($this->errors)) return;
    echo '<div class="errors">' . join('<br>', $this->errors) . '</div>';
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
        'start' => intval($frame['start']),
        'end' => intval($frame['end']),
        'span' => $frame['span']
      );

      //
      // COLUMNS
      $this->columns = (object) array(
        'range' => $location_settings[0]['range'],
        'start' => intval($location_settings[0]['range']['min']),
        'end' => intval($location_settings[0]['range']['max']),
        'span' => intval($location_settings[0]['range']['max'] - $location_settings[0]['range']['min']) + 1,
      );
    }

    return false;
  }
}


//
//
// SCHEDULE
class schedule extends helper{

  private function remove_overlapping_sessions(){
    $counter = 1;
    $count = count($this->sessions);
    while($counter<$count){
      $session = $this->sessions[$counter];
      $prev =$this->sessions[$counter-1];
      $overlapping = false;
      if($session->time->start == $prev->time->start){
        if($session->columns->start <= $prev->columns->start){
          $overlapping = true;
          $this->throw_message('<a href="'.get_edit_post_link($session->ID).'">Session '.$session->ID.'</a> is overlapping another session');
        }
      }
      if($overlapping){
        unset($this->sessions[$counter]);
        $this->sessions = array_values($this->sessions);
        $count = count($this->sessions);
      }
      else{
        $counter++;
      }
    }
  }

  private function print_empty_cells_before_session(){
    $session = $this->session;
    if($session->columns->start && $session->columns->start != $this->column_counter){
      while($this->column_counter < $session->columns->start){
        $this->column_counter++;
        // print_r("\n empty cell before \n");
        echo '<td></td>';
      }
    }
  }

  private function print_empty_cells_after_session(){
    $session = $this->session;
    if($this->session_counter<$this->session_count){
      $next_session = $this->sessions[$this->session_counter];
      if($session->time->start != $next_session->time->start){
        // echo "\n new row, fill rest of the row ";
        $empty_until = $this->column_count;
      }
      else{
        if($session->columns->start < $next_session->columns->start){
          // echo "\n fill until next session";
          $empty_until = $next_session->columns->start - 1;             
        }
        else{
          // echo "\n last row, fill rest of the row ";
          $empty_until = $this->column_count;
          $this->throw_message('<a href="'.get_edit_post_link($session->ID).'">Session '.$session->ID.'</a> is overlapping another session');
        }
      }
    }
    else{
      $empty_until = $this->column_count;
    }
    if($session->columns->start < $empty_until){
      while( $this->column_counter < $empty_until){
        $this->column_counter++;
        // print_r("\n empty cell after \n");
        echo '<td></td>';
      }
    }

  }

  //
  //
  // CONSTRUCTOR

  public function __construct($args){
  
    $this->options = array_merge(array(
      'grid_ID'=>null,
      'table_class'=> false,
      'column_headers'=>false,
      'time_labels'=>false,
    ),$args);
  
    // VARIABLES
    $this->grid_ID = $this->options['grid_ID'];
   
    // GET locations
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
    $this->column_count = intval(get_field('columns_qty','options'));
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

    $this->sessions = array();
    foreach($sessionsQuery->posts as $k=>$session){
      $session = new session($session->ID);
      array_push($this->sessions, $session);
    }
   

    // SORT SESSIONS
    usort($this->sessions, array('schedule','sort_sessions'));
    $this->remove_overlapping_sessions();
    
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
  public function the_session(){
    $this->session = $this->sessions[$this->session_counter];
    $this->session_counter++;
    $this->column_counter++;
    $session = $this->session;
    $timekey = array_keys($this->grid)[$this->timeframe_counter];

    if($this->session_counter==1){
      echo '<table'.($this->options['table_class'] ? ' class="'.$this->options['table_class'].'"':'').'>';
      echo '<tbody>';
      echo '<tr>';
    }
    

    if($session->time->start > $timekey){
      while( $session->time->start > $timekey 
              && $this->timeframe_counter < $this->timeframe_count)
      {
        $this->print_empty_cells_after_session();
        echo '</tr><tr>';
        $this->timeframe_counter++;
        $timekey = array_keys($this->grid)[$this->timeframe_counter];
      }
    }
    // var_dump($session);
    
    if( $session->time->start == $timekey ){
      $this->print_empty_cells_before_session();
      echo '<td'.($session->time->span >1 ? ' rowspan="'.$session->time->span .'"' : '').($session->columns->span >1 ? ' colspan="'.$session->columns->span .'"' : '').'>';
    }
    return $session;
  }

  //
  //
  // PRINT HTML AFTER CURRENT SESSION
  public function after_session(){
    $session = $this->session;
    $timekey = array_keys($this->grid)[$this->timeframe_counter];

    if( $session->time->start == $timekey 
        && $session->columns->start == $this->column_counter ){     
      echo '</td>';
      $this->column_counter += $session->columns->span-1;
      $this->print_empty_cells_after_session();
    }
    $new_row =  $this->timeframe_counter<$this->timeframe_count 
                && $this->column_counter+$session->columns->span >$this->column_count;    
    if($new_row && $this->session_counter <= $this->session_count){
      echo '</tr><tr>';
      $this->print_empty_cells_after_session();
      $this->timeframe_counter++;
      $this->column_counter = 0;
    }

    if($this->session_counter >= $this->session_count){
      $this->print_empty_cells_after_session();
      echo '</tr>';
      echo '</tbody>'; 
      echo '</table>';
    } 
  }
}



?>