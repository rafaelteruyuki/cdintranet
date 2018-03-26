<?php
/*
Template Name: Atualizar
*/
get_header();
// $current_user =  wp_get_current_user();
?>
<h2 class="ui horizontal divider header cd-margem">Atualizar</h2>
<div class="ui container cd-margem">


<?php

$user_args = array(
  'number' => 200,
  'fields' => array('ID', 'user_login'),
  // 'offset' => 20,
  // 'role' => 'designer_gd2_gd4', // Mudar aqui
 );
$cd_users = get_users( $user_args );

// delete_metadata( 'comment', 0, 'interacao_lida', '', true );

include ( locate_template('template-parts/atualizacao-comentarios.php') );
foreach ( $cd_users as $cd_user ) :
  $cd_user_ID = $cd_user->ID;
  $cd_user_login = $cd_user->user_login;
  // atualizacao_comentarios($cd_user_ID, $cd_user_login);
endforeach;

// // VISUALIZAR COMENTARIOS NAO LIDOS PELO USUARIO LOGADO

// include ( locate_template('template-parts/cd-feed.php') );
// $post_args = array(
//   'post_type'              => array( 'tarefa' ),
//   'posts_per_page'         => -1,
//   'order'                  => 'DESC',
//   'fields'                 => 'ids',
//   'meta_query'             => array( $comment_feed ),
// );
//
// $posts_array = get_posts( $post_args );
// wp_reset_postdata();
//
// $nao_lidas_args = array(
//     'order'          => 'DESC',
//     'orderby'        => 'comment_date',
//     'post__in'       => $posts_array, //THIS IS THE ARRAY OF POST IDS WITH META QUERY
//     // 'count' => true,
//     'meta_query'     => array(
//       array(
//       'key' => 'interacao_lida',
//       'value' => $current_user->ID, // Não precisa de aspas pq o valor guardado é INT (numero inteiro)
//       'compare' => 'NOT LIKE',
//       ),
//     ),
// );
//
// $comments_query = new WP_Comment_Query;
// $comments = $comments_query->query( $nao_lidas_args );
// // var_dump($comments);
// foreach ($comments as $comment) {
//   echo '<pre>';
//   var_dump($comment->comment_ID);
//   $post = get_post($comment->comment_post_ID);
//   var_dump($post->guid);
//   echo '</pre>';
// }

?>

</div>
<?php get_footer(); ?>
