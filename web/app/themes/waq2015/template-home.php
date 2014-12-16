<?php
/*
 * Template Name: Accueil
 */

get_header_once();
?>

<?php
get_template_part('template-features');
?>

<?php 
//  PROGRAMMATION ------> ID 4
include_page_part(4);
?>

<?php 
//  COORDONNEES ------> ID 43
include_page_part(43);
?>

<?php 
//  BLOGUE ------> ID 7
include_page_part(7);
?>

<?php 
//  PARTENAIRES ------> ID 47
include_page_part(47);
?>

<?php 
//  WAQ 2015 ------> ID 45
include_page_part(45);
?>

  
<?php 
get_footer_once();
?>