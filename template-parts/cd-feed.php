<?php

global $current_user;

if ( current_user_can( 'edit_pages' ) ) {
  $cd_author = $current_user->ID;
}

//FEED GD2 E GD4

if ( current_user_can( 'designer_gd2_gd4' ) ) {

  $feed_cd = array(

  'relation'		=> 'OR',

    array(
      'key'		=> 'segmentacao',
      'value'		=> 'gd2_gd4',
      'compare' => 'LIKE'
    ),

    array(
      'key' => 'participante',
      'value' => $current_user->ID,
      'compare' => 'LIKE',
    ),

  );

}

//FEED GD1 E GD3

if ( current_user_can( 'designer_gd1_gd3' ) ) {

  $feed_cd = array(

  'relation'		=> 'OR',

    array(
      'key'		=> 'segmentacao',
      'value'		=> 'gd1_gd3',
      'compare' => 'LIKE'
    ),

    array(
      'key' => 'participante',
      'value' => $current_user->ID,
      'compare' => 'LIKE',
    ),

  );

}

//FEED INSTITUCIONAL

if ( current_user_can( 'designer_institucional' ) ) {

  $feed_cd = array(

  'relation'		=> 'OR',

    array(
      'key'		=> 'segmentacao',
      'value'		=> 'institucional',
      'compare' => 'LIKE'
    ),

    array(
      'key' => 'participante',
      'value' => $current_user->ID,
      'compare' => 'LIKE',
    ),

  );

}

//FEED PORTAL

if ( current_user_can( 'portal' ) ) {

  $feed_cd = array(

  'relation'		=> 'OR',

    array(
      'key'		=> 'segmentacao',
      'value'		=> 'evento',
      'compare' => 'LIKE'
    ),

    array(
      'key'		=> 'segmentacao',
      'value'		=> 'pauta',
      'compare' => 'LIKE'
    ),

    array(
      'key' => 'participante',
      'value' => $current_user->ID,
      'compare' => 'LIKE',
    ),

  );

}

// FEED REPRESENTANTES

if ( current_user_can( 'senac' ) ) {

  $args_query1 = array(
  		'post_type'		=> 'tarefa',
  		'posts_per_page' => -1,
      'fields' => 'ids',
      'meta_query'  =>  array(
        array(
        'key' => 'participante',
        'value' => $current_user->ID,
        'compare' => 'LIKE',
        ),
      ),
  );

  $query1 = new WP_Query($args_query1);

  $args_query2 = array(
  		'post_type'		=> 'tarefa',
  		'posts_per_page' => -1,
      'fields' => 'ids',
  		'author'		=> $current_user->ID,
  );

  $query2 = new WP_Query($args_query2);

  $allTheIDs = array_merge($query1->posts,$query2->posts);

  if (empty($allTheIDs)) {
       $cd_author = $current_user->ID;
       $feed_rc = $current_user->ID;
  }

  $privado = array(
  'key' => 'privado_interacao',
  'value' => '1',
  'compare' => '!=',
  );

};

?>
