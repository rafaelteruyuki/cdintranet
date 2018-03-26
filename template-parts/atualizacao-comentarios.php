<?php

function atualizacao_comentarios($user_ID = 0, $user_login = '') {

//FEED GD2 E GD4

if ( user_can( $user_ID, 'designer_gd2_gd4' ) ) {
  $segmentacao = array(
    'key'		=> 'segmentacao',
    'value'		=> 'gd2_gd4',
    'compare' => 'LIKE' // Para procurar o valor em múltiplos valores salvos (Array)
  );
}

//FEED GD1 E GD3

if ( user_can( $user_ID, 'designer_gd1_gd3' ) ) {
  $segmentacao = array(
    'key'		=> 'segmentacao',
    'value'		=> 'gd1_gd3',
    'compare' => 'LIKE' // Para procurar o valor em múltiplos valores salvos (Array)
  );
}

//FEED INSTITUCIONAL

if ( user_can( $user_ID, 'designer_institucional' ) ) {
  $segmentacao = array(
    'key'		=> 'segmentacao',
    'value'		=> 'institucional',
    'compare' => 'LIKE' // Para procurar o valor em múltiplos valores salvos (Array)
  );
}

//FEED PORTAL

if ( user_can( $user_ID, 'portal' ) ) {
  $segmentacao = array(
    'key'		=> 'segmentacao',
    'value'		=> 'evento',
    'compare' => 'LIKE' // Para procurar o valor em múltiplos valores salvos (Array)
  );
}

// PARTICIPANTE

$participante = array(
  'key' => 'participante',
  'value' => '"' . $user_ID . '"', // Aspas evitam falsos positivos, ex: ID 43 e ID 143
  'compare' => 'LIKE', // Para procurar o valor em múltiplos valores salvos (Array)
);

// CD_AUTHOR

$cd_author = array(
  'key'		=> 'cd_author',
  'value'		=> $user_ID, // Não precisa de aspas aspas, o valor é único
  'compare' => '=' // Para procurar o valor em valor único salvo
);

// RESPONSAVEL 1

$responsavel1 = array(
  'key' => 'responsavel_1',
  'value'		=> $user_ID,
  'compare' => '='
);

// RESPONSAVEL 2

$responsavel2 = array(
  'key' => 'responsavel_2',
  'value'		=> $user_ID,
  'compare' => '='
);

// RESPONSAVEL PORTAL 1

$responsavel_portal1 = array(
  'key' => 'responsavel_portal',
  'value'		=> $user_ID,
  'compare' => '='
);

// RESPONSAVEL PORTAL 2

$responsavel_portal2 = array(
  'key' => 'responsavel_portal2',
  'value'		=> $user_ID,
  'compare' => '='
);

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

// REMOVE COMENTARIOS PRIVADOS DOS USUARIOS SENAC E DE USUARIOS NAO LOGADOS
if ( user_can( $user_ID, 'senac' ) ) {
  $privado = array(
  'key' => 'privado_interacao',
  'value' => '1',
  'compare' => '!=',
  );
}

// META_QUERY DOS POSTS IDS
$post_args = array(
  'post_type'              => array( 'tarefa' ),
  'posts_per_page'         => -1,
  'order'                  => 'DESC',
  'fields'                 => 'ids',
  'meta_query'             => array( $comment_feed ),
);

$posts_array = get_posts( $post_args );
wp_reset_postdata();

// Interaçoes

if ( !empty($posts_array) ) : // Se não tiver posts, não inicia essa query.

  $nao_lidas_args = array(
      'order'          => 'DESC',
      'orderby'        => 'comment_date',
      'post__in'       => $posts_array,
      'meta_query'     => array( $privado ),
  );

  $comments_query = new WP_Comment_Query;
  $comments = $comments_query->query( $nao_lidas_args );

  if ( !empty( $comments ) ) :

    foreach ( $comments as $comment ) :

      // Checa se há visita e quem visitou
      if( have_rows('visitas', $comment->comment_post_ID) ) {

        while ( have_rows('visitas', $comment->comment_post_ID) ) {
          the_row();
          $usuario_registrado[] = get_sub_field('usuario', $comment->comment_post_ID); // Array usuários registrados
          $acesso_registrado[] = get_sub_field('acesso', $comment->comment_post_ID); // Array acessos registrados
        }

        $key = array_search($user_login, $usuario_registrado); // Procura a posição no array de usuários registrados
        $interacao_lida = get_comment_meta( $comment->comment_ID, 'interacao_lida', true );

        // Usuário logado visitou a tarefa
        if ($key !== false) {

          $comment_time = get_comment_date('YmdHis', $comment->comment_ID);

          if ($comment_time <= $acesso_registrado[$key]) { // AQUI É SINAL DE MAIOR/IGUAL = LIDA

            if ($interacao_lida) {
              // Há usuário(s) que leram essa interação (acrescenta o usuário a esse array)
              $interacao_lida[] = $user_ID;
              $interacao_lida = array_unique($interacao_lida);
            } else {
              // Não há usuários que leram essa interação (cria um array e insere o usuário)
              $interacao_lida = array();
              $interacao_lida[] = $user_ID;
            }

          }

        }

        $interacao_lida = array_unique($interacao_lida);
        $interacao_lida = array_map('intval', $interacao_lida);
        update_comment_meta( $comment->comment_ID, 'interacao_lida', $interacao_lida );
        $interacao_lida = array();

        $usuario_registrado = array(); // Limpa o array
        $acesso_registrado = array(); // Limpa o array

      }

    endforeach;

    echo '*----- ' . $user_login . ' Updated -----*<br>';

  endif;

endif;


// Tarefas

if ( !empty($posts_array) ) : // Se não tiver posts, não inicia essa query.

  foreach ($posts_array as $post) {

    $tarefa_lida = get_post_meta( $post, 'tarefa_lida', true );

    if ( have_rows('visitas', $post) ) {
	      while ( have_rows('visitas', $post) ) { the_row();
	          $usuario_registrado[] = get_sub_field('usuario', $post);
	          $acesso_registrado[] = get_sub_field('acesso', $post);
	      }

	    // Procura o usuário no array de usuários registrados
	    if ( in_array($user_login, $usuario_registrado) ) {

        if ($tarefa_lida) {
          // Há usuário(s) que leram essa tarefa (acrescenta o usuário a esse array)
          $tarefa_lida[] = $user_ID;
          $tarefa_lida = array_unique($tarefa_lida);
        } else {
          // Não há usuários que leram essa tarefa (cria um array e insere o usuário)
          $tarefa_lida = array();
          $tarefa_lida[] = $user_ID;
        }

	    }
	  }

    $tarefa_lida = array_unique($tarefa_lida);
    $tarefa_lida = array_map('intval', $tarefa_lida);
    update_post_meta( $post, 'tarefa_lida', $tarefa_lida );

    $tarefa_lida = array();

  }

  echo '*----- ' . $user_login . ' Updated -----*<br>';

endif;

wp_reset_postdata();

}

?>
