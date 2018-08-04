<?php 
/*
*Plugin name: Lycéens sur les planches - Réservations
*Description: Cette extension permettra la réservation des places de théâtre pour les représentations du festival de théâtre francophone.
*Plugin URI: https://github.com/jacquesPichon/LyceensSurLesPlanches
*License: GPLv2 or later
*/

function add_booking_item_menu($pageid){
  $locations = get_nav_menu_locations();

  reset($locations);
  $first_key = key($locations);
  var_dump($first_key);
  $menu_id = $locations[ $first_key ] ;
  // var_dump($menu_id);
  $menu=wp_get_nav_menu_object($menu_id);
  var_dump($menu);
  $menu_item_data = array(
    'menu-item-object-id' => $pageid, // ID of the page you want to add
    'menu-item-parent-id' => 0,              // top level menu item
    'menu-item-position' => 0,               // setting position to 0 will add it to the end
    'menu-item-object' => 'page',
    'menu-item-type' => 'post_type',
    'menu-item-status' => 'publish'
  );
  wp_update_nav_menu_item( $menu->term_id, 0, $menu_item_data );
}
  //////////////////////
 //   booking page   //
//////////////////////
function get_booking_page(){
  $pages=get_pages(array('authors'=>'lslp'));
  foreach($pages as $page){
    if($page->post_title=="Billetterie") return $page->ID;
  }
  return false;
}

function delete_booking_page(){
  $pageid=get_booking_page();
  if($pageid){
    var_dump($pageid);
    var_dump(wp_delete_post($pageid,true));
  }
}

function add_booking_page(){
  $pageexist=false;
  
  if(get_booking_page()) $pageexist=true;
  
  if(!$pageexist){
    //add page
    $my_post = array(
    'post_title' => 'Billetterie',
    'post_content' => 'Ici prochainement la Billetterie ...',
    'post_status' => 'publish',
    'post_author' => 1,
    'post_type' => 'page'
    );

    $pageid=wp_insert_post( $my_post );
    echo "added page";
    if(is_int($pageid)) add_booking_item_menu($pageid);
  }
}
  //////////////////////
 //       hooks      //
//////////////////////
register_activation_hook(__FILE__, 'add_booking_page');
register_deactivation_hook(__FILE__, 'delete_booking_page');









