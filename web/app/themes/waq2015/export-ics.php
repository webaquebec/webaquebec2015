<?php
global $user_ID;
$favorites_str = get_field('favorites','user_'.$user_ID);
if(has($favorites_str)):
  $today = new DateTime();
  $now = $today->getTimestamp();
  $session_IDs = explode('|', $favorites_str);

  // create sessions array width grid IDs and session objects
  $sessions = [];
  foreach($session_IDs as $session_ID){
    if(has($session_ID)){
      $session = new session(intval($session_ID));
      if(!isset($sessions[$session->grid_ID])) $sessions[$session->grid_ID] = [];
      $sessions[$session->grid_ID][] = $session;
    }
  }
  // sort sessions by start time
  function sortByStartTime($a, $b){
    if($a->time->start == $b->time->start) return 0;
    return ($a->time->start < $b->time->start) ? -1 : 1;
  }
  function safeEscape($str){
    $str = strip_tags($str);
    $str = str_replace(array("\r", "\n", "'", "’", ";", ":", ","), array('','','\'','\’','\;','\:','\,'), $str);
    return $str;
  }

  $schedules = new WP_query(array(
      'post_type' => 'grid',
      'posts_per_page' => -1,
      'orderby'=> 'menu_order',
    ));
  if($schedules->have_posts()):
?>
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//Web a Quebec v1.0//NONSGML Mon horaire//FR
CALSCALE:GREGORIAN
METHOD:PUBLISH
<?php
    while($schedules->have_posts()):
      $schedules->the_post();
      $date = DateTime::createFromFormat('d/m/y', get_field('date', $post->ID))->getTimestamp();
      if(isset($sessions[$post->ID])):
        usort($sessions[$post->ID], 'sortByStartTime');
        foreach($sessions[$post->ID] as $session):
?>
BEGIN:VEVENT
DTSTART:<?= strftime('%Y%m%d', $date) ?>T<?= strftime('%H%I%S', $session->time->start)."\r\n" ?>
DTEND:<?= strftime('%Y%m%d', $date) ?>T<?= strftime('%H%I%S', $session->time->end)."\r\n" ?>
DTSTAMP:<?= strftime('%Y%m%d', $now) ?>T<?= strftime('%H%I%S', $now)."\r\n" ?>
UID:<?= $session->ID ?>@webaquebec.org
DESCRIPTION:<?= safeEscape($session->title)."\r\n" ?>
SUMMARY:<?= safeEscape($session->excerpt)."\r\n" ?>
END:VEVENT
<?php
        endforeach;
      endif;
    endwhile;
?>
END:VCALENDAR
<?php
  endif;
endif; ?>