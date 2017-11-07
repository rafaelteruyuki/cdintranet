<?php

global $current_user;

//FEED GD2 E GD4

if ( current_user_can( 'designer_gd2_gd4' ) ) {
  $segmentacao = array(
    'key'		=> 'segmentacao',
    'value'		=> 'gd2_gd4',
    'compare' => 'LIKE'
  );
}

//FEED GD1 E GD3

if ( current_user_can( 'designer_gd1_gd3' ) ) {
  $segmentacao = array(
    'key'		=> 'segmentacao',
    'value'		=> 'gd1_gd3',
    'compare' => 'LIKE'
  );
}

//FEED INSTITUCIONAL

if ( current_user_can( 'designer_institucional' ) ) {
  $segmentacao = array(
    'key'		=> 'segmentacao',
    'value'		=> 'institucional',
    'compare' => 'LIKE'
  );
}

//FEED PORTAL

if ( current_user_can( 'portal' ) ) {
  $segmentacao = array(
    'key'		=> 'segmentacao',
    'value'		=> 'evento',
    'compare' => 'LIKE'
  );
}

// PARTICIPANTE

$participante = array(
  'key' => 'participante',
  'value' => $current_user->ID,
  'compare' => '=',
);

// CD_AUTHOR

$cd_author = array(
  'key'		=> 'cd_author',
  'value'		=> $current_user->ID,
  'compare' => '='
);

// --------------------------- FEED ---------------------------- //

// MINHAS TAREFAS

$minhas_tarefas_feed = array(
'relation'		=> 'OR',
  $segmentacao,
  $participante,
  // $cd_author,
);

// MINHAS SOLICITACOES

$minhas_solicitacoes_feed = array(
'relation'		=> 'OR',
  // $segmentacao,
  $participante,
  $cd_author,
);

// COMENTARIOS

$comment_feed = array(
'relation'		=> 'OR',
  $segmentacao,
  $participante,
  $cd_author,
);

?>
