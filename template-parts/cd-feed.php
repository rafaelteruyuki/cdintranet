<?php

global $current_user;

//FEED GD2 E GD4

if ( current_user_can( 'designer_gd2_gd4' ) ) {
  $segmentacao = array(
    'key'		=> 'segmentacao',
    'value'		=> 'gd2_gd4',
    'compare' => 'LIKE' // Para procurar o valor em múltiplos valores salvos (Array)
  );
}

//FEED GD1 E GD3

if ( current_user_can( 'designer_gd1_gd3' ) ) {
  $segmentacao = array(
    'key'		=> 'segmentacao',
    'value'		=> 'gd1_gd3',
    'compare' => 'LIKE' // Para procurar o valor em múltiplos valores salvos (Array)
  );
}

//FEED INSTITUCIONAL

if ( current_user_can( 'designer_institucional' ) ) {
  $segmentacao = array(
    'key'		=> 'segmentacao',
    'value'		=> 'institucional',
    'compare' => 'LIKE' // Para procurar o valor em múltiplos valores salvos (Array)
  );
}

//FEED PORTAL

if ( current_user_can( 'portal' ) ) {
  $segmentacao = array(
    'key'		=> 'segmentacao',
    'value'		=> 'evento',
    'compare' => 'LIKE' // Para procurar o valor em múltiplos valores salvos (Array)
  );
}

if ( current_user_can( 'redes_sociais' ) ) {
  $segmentacao = array(
    'key'		=> 'segmentacao',
    'value'		=> 'redes_sociais',
    'compare' => 'LIKE' // Para procurar o valor em múltiplos valores salvos (Array)
  );
}

// PARTICIPANTE

$participante = array(
  'key' => 'participante',
  'value' => '"' . $current_user->ID . '"', // Aspas evitam falsos positivos, ex: ID 43 e ID 143
  'compare' => 'LIKE', // Para procurar o valor em múltiplos valores salvos (Array)
);

// CD_AUTHOR

$cd_author = array(
  'key'		=> 'cd_author',
  'value'		=> $current_user->ID, // Não precisa de aspas aspas, o valor é único
  'compare' => '=' // Para procurar o valor em valor único salvo
);

// RESPONSAVEL 1

$responsavel1 = array(
  'key' => 'responsavel_1',
  'value'		=> $current_user->ID,
  'compare' => '='
);

// RESPONSAVEL 2

$responsavel2 = array(
  'key' => 'responsavel_2',
  'value'		=> $current_user->ID,
  'compare' => '='
);

// RESPONSAVEL PORTAL 1

$responsavel_portal1 = array(
  'key' => 'responsavel_portal',
  'value'		=> $current_user->ID,
  'compare' => '='
);

// RESPONSAVEL PORTAL 2

$responsavel_portal2 = array(
  'key' => 'responsavel_portal2',
  'value'		=> $current_user->ID,
  'compare' => '='
);

// REMOVE COMENTARIOS PRIVADOS DOS USUARIOS SENAC E DE USUARIOS NAO LOGADOS
if ( current_user_can( 'senac' ) || !is_user_logged_in() ) {
  $privado = array(
  'key' => 'privado_interacao',
  'value' => '1',
  'compare' => '!=',
  );
}

// --------------------------- FEED ---------------------------- //

// MINHAS TAREFAS

$minhas_tarefas_feed = array(
'relation'		=> 'OR',
  $segmentacao,
  $participante,
  $responsavel1,
  $responsavel2,
  $responsavel_portal1,
  $responsavel_portal2,
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
  $responsavel1,
  $responsavel2,
  $responsavel_portal1,
  $responsavel_portal2,
  $cd_author,
);

?>
