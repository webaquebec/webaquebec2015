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

  protected function sort_headers($a, $b){
    if($a->columns->start == $b->columns->start) return 0;
    return ($a->columns->start < $b->columns->start) ? -1 : 1;
  }

  protected function get_sessions_IDs(){
    $IDs = array();
    foreach($this->sessions as $session)
      array_push($IDs, $session->ID);
    return $IDs;
  }

  protected function array_empty_columns($count, $key=null, $timestamp=null){
    $cols = array();
    $i = 0;
    while($i<$count){
      array_push($cols, 0);
      $i++;
    }
    if(has($timestamp)) $cols['time'] = strftime('%H:%M', $timestamp);
    if(isset($key)) $cols['key'] = $key;

    return $cols;
  }


  //
  //
  // ERRORS AND MESSAGES
  protected function throw_message($str){
    if(!isset($this->messages)) $this->messages = array();
    if(!in_array($str, $this->messages)) array_push($this->messages, $str);
  }

  protected function throw_error($str){
    if(!isset($this->errors)) $this->errors = array();
    if(!in_array($str, $this->errors)) array_push($this->errors, $str);
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
// GRID
class grid extends helper{


  //
  //
  // REMOVE EMPTY ROWS IN $this->grid
  private function remove_empty_grid_rows($schedule){
    $prev_spans = $this->array_empty_columns($this->column_count);
    foreach($this->table as $timestamp=>$row){
      $empty = true;
      $c = 0;
      while($c<$this->column_count){
        if($row[$c]!=0){
          $current_session = $schedule->sessions[array_search($row[$c],$schedule->sessions_IDs)];
          $current_timestamp = $current_session->time->start;
          if($current_session->time->start == $timestamp){
            $empty = false;
            //
            if($prev_spans[$c]>0){
              $prev_spans[$c]--;
            }
            if($prev_spans[$c]>1){
              $current_time_key = array_search($current_session->time->start, $this->time_keys);
              $prev_timestamp = $this->time_keys[$current_time_key - ($prev_spans[$c])];
              $schedule->sessions[array_search($this->table[$prev_timestamp][$c],$schedule->sessions_IDs)]->time->span--;
            }
            $prev_spans[$c] = $current_session->time->span;
          }
        }
        $c++;
      }
      if($empty){
        unset($this->table[$timestamp]);
        $this->time_keys = array_keys($this->table);
      };
    }
  }



  public function build_table($schedule){

    foreach($schedule->sessions as $k=>$session){
      // build $this->grid for debugging
      if(isset($this->table[$session->time->start])){
        $t = 0;
        $time_keys = $this->time_keys;
        $start_key = array_search($session->time->start, $time_keys);
        // loop through timespan
        while($t<$session->time->span){
          $timestamp = $time_keys[$start_key + $t];
          if(isset($this->table[$timestamp][$session->columns->start-1]) && isset($this->table[$timestamp][$session->columns->end-1])){
            $c = $session->columns->start-1;
            //loop through colspan
            while($c<$session->columns->end){
              $this->table[$timestamp][$c] = $session->ID;
              $c++;
            }
          }
          else{
            $this->throw_message('Problem with columns '.$session->columns->start.' throught '.$session->columns->end.' on timeframe '.$timestamp.' while building grid for debugging.');
          }
          $t++;
        }
      }
      else{
        $this->throw_message('Timeframe '.$session->time->start.' from <a href="'.get_edit_post_link($session->ID).'" target="_blank">Session '.$session->ID.'</a> not found while building grid for debugging.');
      }
    }
    $this->remove_empty_grid_rows($schedule);
  }



  public function __construct($ID){
    $this->timeframes = get_field('time_frames', $ID);
    $this->table = array();
    $this->column_count = intval(get_field('columns_qty','options'));

    if($this->timeframes){
      foreach($this->timeframes as $k=>$frame){
        $frame = $frame['frame'][0];
        // get time-only timestamp (seconds elapsed from 0:00)
        $start = $frame['start'] % 86400;
        $end = $frame['end'] % 86400;

        if(!isset($this->table[$start])){
          $this->table[$start] = $this->array_empty_columns($this->column_count, $k, $start);
        }
        else{
          if(!isset($this->table[$start]['key'])){
            $this->table[$start]['key'] = $k;
          }
        }
        if(!isset($this->table[$end])){
          $this->table[$end] = $this->array_empty_columns($this->column_count, null, $end);
        }

      }

      // ksort($this->timeframes);
      ksort($this->table);
      $this->time_keys = array_keys($this->table);
    }
    else{
      $this->throw_error('No timeframe found for this grid');
    }
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
        'is_column_header' => $location_settings[0]['is_column_header'],
      );

      //
      // GRID
      $grid_ID = get_field('grid', $this->ID);
      $this->date = DateTime::createFromFormat('d/m/y', get_field('date', $grid_ID))->getTimestamp();
      $this->grid_title = get_the_title($grid_ID);

      $grid = new grid($grid_ID);

      //
      // TIME
      $frame = explode('.', get_field('frame_'.$grid_ID, $this->ID));
      $start = intval($frame[0]);
      $end = intval($frame[1]);
      $time_start_key = array_search( $start , $grid->time_keys);
      $time_end_key = array_search( $end , $grid->time_keys);
      $span = $time_end_key - $time_start_key;

      $this->time = (object) array(
        'start' => $start,
        'end' => $end,
        'span' => $span
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

  //
  //
  // REMOVE DUPLICATES AND THROW ERRORS
  private function remove_overlapping_sessions(){
    $counter = 1;
    $count = count($this->sessions);
    while($counter<$count){
      $session = $this->sessions[$counter];
      $prev = $this->sessions[$counter-1];
      $overlapping = false;
      if($session->time->start == $prev->time->start){
        if($session->columns->start <= $prev->columns->start){
          $overlapping = true;
          $this->throw_error('<a href="'.get_edit_post_link($session->ID).'" target="_blank">Session '.$session->ID.'</a> is overlapping another <a href="'.get_edit_post_link($prev->ID).'" target="_blank">session '.$prev->ID.'</a> at '.strftime('%k:%M',$session->time->start).', column '. $session->columns->start);
        }
      }
      if($overlapping){
        unset($this->sessions[$counter]);
        $this->sessions = array_values($this->sessions);
        $this->sessions_IDs = $this->get_sessions_IDs();
        $count = count($this->sessions);
      }
      else{
        $counter++;
      }
    }
  }

  //
  //
  // CHECK FOR NEW ROW
  private function needs_new_row(){
    return  $this->session_counter < $this->session_count
            &&(
                (
                  $this->timeframe_counter+1 < $this->timeframe_count
                  && $this->column_counter + $this->session->columns->span > $this->grid->column_count
                )
                ||(
                  isset($this->sessions[$this->session_counter])
                  && $this->sessions[$this->session_counter]->time->start > $this->grid->time_keys[$this->timeframe_counter]
                )
            );
  }

  private function print_empty_row(){
    echo "</tr>\n<tr>\n";
    if($this->options->render_time_labels) $this->print_time_label();
    $i=0;
    while($i<$this->grid->column_count){
      echo '<td class="'.$this->options->empty_class.'">'."</td>\n";
      $i++;
    }
  }



  //
  //
  // PRINT TABLE PARTS



  // time label
  private function print_time_label(){

      if(isset($this->grid->time_keys[$this->timeframe_counter])){
        if(isset($this->grid->table[$this->grid->time_keys[$this->timeframe_counter]]['key'])){
          $time = $this->grid->timeframes[$this->grid->table[$this->grid->time_keys[$this->timeframe_counter]]['key']]['frame'][0]['start'];
          echo '<th>'.strftime($this->options->time_labels_format, $time).'</th>';
        }
        else{
          $this->throw_error("Can't find key for timeframe ".$this->timeframe_counter.' on grid <a href="'.get_edit_post_link($this->grid_ID).'" target="_blank">'.get_the_title($this->grid_ID).'</a>');
          echo '<th></th>';
        }
      }
      else{
        $this->throw_error('Timeframe '.$this->timeframe_counter.' is set for <a href="'.get_edit_post_link($this->session->ID).'" target="_blank">session '.$this->session->ID.'</a> but does not exist on grid <a href="'.get_edit_post_link($this->grid_ID).'" target="_blank">'.get_the_title($this->grid_ID).'</a>');
        echo '<th></th>';
      }
  }


  // table head
  private function print_content_before(){

    if($this->session_counter>1) return;

    if(!$this->render_status->open_table){
      echo '<table'.($this->options->table_class ? ' class="'.$this->options->table_class.'"':'').'>';
      $this->render_status->open_table = true;
    }

    if( $this->options->render_thead
        && !$this->render_status->open_tbody
        && $this->header_counter==1){
      echo "<thead>\n<tr>\n";
      $this->render_status->open_thead = true;
      if($this->options->render_time_labels) echo '<td class="'.$this->options->empty_class.'"></td>';
    }

    if($this->session_counter==1 && !$this->render_status->open_tbody){
      echo "<tbody>\n";
      echo "\n<tr>";
      $this->render_status->open_tbody = true;
      if($this->options->render_time_labels) $this->print_time_label();
    }

  }
  // table foot
  private function print_content_after(){

    if( $this->options->render_thead
        && !$this->render_status->close_thead
        && $this->header_counter >= $this->header_count){
      echo '</tr></thead>';
      $this->render_status->close_thead = true;
      $this->column_counter = 0;
    }

    if($this->session_counter < $this->session_count) return;
    if(!$this->render_status->close_tbody){
      $this->print_empty_cells_after_session();
      echo '</tr>';
      echo '</tbody>';
      $this->render_status->close_tbody = true;
    }
    if(!$this->render_status->close_table){
      echo '</table>';
      $this->render_status->close_table = true;
    }
  }


  //
  //
  // PRINT EMPTY HEADER CELLS

  // before
  private function print_empty_cells_before_header(){
    $header = $this->header;
    if($header->columns->start && $header->columns->start != $this->column_counter){
      while($this->column_counter < $header->columns->start){
        $this->column_counter++;
        echo "<th></th>\n";
      }
    }
  }
  // after
  private function print_empty_cells_after_header(){
    $header = $this->header;
    if($this->header_counter<$this->header_count){
      $next_header = $this->headers[$this->header_counter];

      if($header->columns->start < $next_header->columns->start){
        $empty_until = $next_header->columns->start - 1;
      }
      else{
        $empty_until = $this->grid->column_count;
        $this->throw_error('<a href="'.get_edit_post_link($header->ID).'" target="_blank">Column header '.$header->ID.'</a> is overlapping another column header');
      }

    }
    else{
      $empty_until = $this->grid->column_count;
    }
    if($header->columns->start < $empty_until){
      while( $this->column_counter < $empty_until){
        $this->column_counter++;
        echo "<td></td>\n";
      }
    }

  }


  //
  //
  // PRINT EMPTY SESSION CELLS

  // before
  private function print_empty_cells_before_session(){
    $session = $this->session;
    if($this->session_counter>0){
      $row = $this->grid->table[$this->grid->time_keys[$this->timeframe_counter]];
      $empty_since = $session->columns->start;
      while(isset($row[$empty_since-2]) && $row[$empty_since-2]==0){
        $empty_since--;
      }

    }
    else{
      $empty_since = 0;
    }
    if($session->columns->start > $empty_since){
      $this->column_counter = $empty_since;
      while($this->column_counter < $session->columns->start){
        $this->column_counter++;
        echo '<td class="before '.$this->options->empty_class.'"></td>'."\n";
      }

    }
    $this->column_counter = $session->columns->start;
  }
  // after
  private function print_empty_cells_after_session(){
    $session = $this->session;
    if($this->session_counter<$this->session_count){
      $row = $this->grid->table[$this->grid->time_keys[$this->timeframe_counter]];
      $empty_until = $session->columns->start;
      while(isset($row[$empty_until]) && $row[$empty_until]==0){
        $empty_until++;
      }
      $empty_until--;
    }
    else{
      $empty_until = $this->grid->column_count;
    }
    if($session->columns->start < $empty_until){
      while( $this->column_counter < $empty_until){
        $this->column_counter++;
        echo '<td class="after '.$this->options->empty_class.'"></td>'."\n";
      }
    }
  }

  //
  //
  // CONSTRUCTOR

  public function __construct($args){

    $this->options = (object) array_merge(array(
      'grid_ID'=>null,
      'table_class'=> false,
      'render_thead'=>false,
      'render_time_labels'=>false,
      'render_empty_rows'=>true,
      'time_labels_format' => '%k:%M',
      'empty_class' => 'empty',
    ),$args);

    // VARIABLES
    $this->grid_ID = $this->options->grid_ID;

    // GET locations
    $locationsQuery = new WP_query(array(
        'post_type' => 'location',
        'posts_per_page' => -1,
      ));

    $this->locations = array();
    if($this->options->render_thead) $this->headers = array();

    foreach($locationsQuery->posts as $location){
      $infos = get_field('infos', $location->ID);
      $labels = $infos[0]['labels'];
      $settings = $infos[0]['settings'];
      $title = $labels[0]['alt'];
      if(!has($title)) $title = get_the_title($location->ID);

      $location_object = (object) array(
          'ID' => $location->ID,
          'hide' => $labels[0]['hide'],
          'title' => $title,
          'subtitle' => $labels[0]['subtitle'],
          // -------------------------------------
          'class' => $settings[0]['class'],
          'color' => $settings[0]['color'],
          'is_column_header' => $settings[0]['is_column_header'],
          'columns' => (object) array(
            'range' => $settings[0]['range'],
            'start' => intval($settings[0]['range']['min']),
            'end' => intval($settings[0]['range']['max']),
            'span' => intval(($settings[0]['range']['max'] - $settings[0]['range']['min']) + 1),
          ),
        );
      $this->locations[$location->ID] = $location_object;

      if($this->options->render_thead && $settings[0]['is_column_header']){
        array_push($this->headers, $location_object);
      }

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


    // SORT & REMOVE DUPLICATES
    usort($this->sessions, array('schedule','sort_sessions'));
    $this->sessions_IDs = $this->get_sessions_IDs();
    $this->remove_overlapping_sessions();

    // GET GRID AND BUILD TABLE OBJECT
    $this->grid = new grid($this->grid_ID);
    $this->grid->build_table($this);

    if($this->options->render_thead){
      usort($this->headers, array('schedule','sort_headers'));
    }

    // SET COUNTERS
    $this->session_count = count($this->sessions);
    $this->session_counter = 0;
    $this->timeframe_count = count($this->grid->table);
    $this->timeframe_counter = 0;
    $this->column_counter = 0;

    if($this->options->render_thead){
      $this->header_count = count($this->headers);
      $this->header_counter = 0;
    }

    // RENDER STATUS
    $this->render_status = (object) array(
      'open_table' => false,
        'open_thead' => false,
        'close_thead' => false,
        'open_tbody' => false,
        'close_tbody' => false,
        'open_tfoot' => false,
        'close_tfoot' => false,
      'close_table' => false,
    );

  }



  //
  //
  // LOOP THROUGH COLUMN HEADERS
  public function have_headers(){
    if($this->options->render_thead && $this->header_count)
      return ($this->header_counter < $this->header_count);
    $this->throw_error('No header found for this schedule.');
    return false;
  }
  //
  //
  // PRINT HTML BEFORE CURRENT COLUMN HEADER
  public function the_header(){
    $this->header = $this->headers[$this->header_counter];
    $this->header_counter++;
    $this->column_counter++;
    $header = $this->header;

    $this->print_content_before();

    $this->print_empty_cells_before_header();
    echo '<th'.($header->columns->span >1 ? ' colspan="'.$header->columns->span .'"' : '').'>';
    return $header;
  }
  //
  //
  // PRINT HTML AFTER CURRENT HEADER
  public function after_header(){
    $header = $this->header;
    if($header->columns->start == $this->column_counter ){
      echo "</th>\n";
      $this->column_counter += $header->columns->span-1;
      $this->print_empty_cells_after_header();
    }
    $this->print_content_after();
  }

  //
  //
  // LOOP THROUGH SESSIONS
  public function have_sessions(){
    if($this->session_count && $this->timeframe_count)
      return ($this->session_counter < $this->session_count);
    $this->throw_error('No session found for this schedule.');
    return false;
  }
  //
  //
  // PRINT HTML BEFORE CURRENT SESSION
  public function the_session(){
    $this->session = $this->sessions[$this->session_counter];
    $this->session_counter++;
    $this->column_counter++;
    $session = $this->session;
    $timestamp = $this->grid->time_keys[$this->timeframe_counter];

    $this->print_content_before();

    if( $session->time->start == $timestamp ){
      $this->print_empty_cells_before_session();
      echo '<td'.($session->time->span >1 ? ' rowspan="'.$session->time->span .'"' : '').($session->columns->span >1 ? ' colspan="'.$session->columns->span .'"' : '').">\n";
    }

    return $session;
  }
  //
  //
  // PRINT HTML AFTER CURRENT SESSION
  public function after_session(){
    $session = $this->session;
    $timestamp = $this->grid->time_keys[$this->timeframe_counter];

    if( $session->time->start == $timestamp
        && $session->columns->start == $this->column_counter ){
      echo "</td>\n";
      $this->column_counter += $session->columns->span-1;
      $this->print_empty_cells_after_session();
    }

    while($this->needs_new_row()){
      $this->timeframe_counter++;
      $this->column_counter = 0;
      if(!isset($this->grid->time_keys[$this->timeframe_counter])) die;
      $timestamp = $this->grid->time_keys[$this->timeframe_counter];
      if($this->sessions[$this->session_counter]->time->start == $timestamp){
       echo "</tr>\n<tr>\n";
       if($this->options->render_time_labels) $this->print_time_label();
      }
      else{
        if($this->options->render_empty_rows) $this->print_empty_row();
      }
    }

    $this->print_content_after();
  }
}



?>