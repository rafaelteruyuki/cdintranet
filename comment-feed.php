<?php

// CD-FEED
include ( locate_template('template-parts/cd-feed.php') );

// REMOVE COMENTARIOS PRIVADOS DOS USUARIOS SENAC E DE USUARIOS NAO LOGADOS
if ( current_user_can( 'senac' ) || !is_user_logged_in() ) {
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
  // 'post__in'               => $allTheIDs,
  // 'orderby'                => 'comment_date',
  // 'author'                 => $feed_rc,
  'meta_query'             => array( $comment_feed ),
);

$post_query = new WP_Query( $post_args );
$posts_array= array();
global $post;

$lastposts = get_posts( $post_args );
foreach ( $lastposts as $post ) : setup_postdata( $post );
  $posts_array[] = get_the_ID(); //Array of post ids
endforeach;
wp_reset_postdata();

if (!empty($posts_array)) : // Se não tiver posts, não inicia essa query.

  $nao_lidas_args = array(
      'order'          => 'DESC',
      'orderby'        => 'comment_date',
      'post__in'       => $posts_array, //THIS IS THE ARRAY OF POST IDS WITH META QUERY
      'meta_query'     => array( $privado ),
  );

  $comments_query = new WP_Comment_Query;
  $comments = $comments_query->query( $nao_lidas_args );

  $num_nao_lidas = 0;
  $msgs_nao_lidas = false;
  // $i = 0;

  if ( !empty( $comments ) ) :

    foreach ( $comments as $comment ) :

      // $i++;

      // Checa se há visita e quem visitou
      if( have_rows('visitas', $comment->comment_post_ID) ) {

        while ( have_rows('visitas', $comment->comment_post_ID) ) {
          the_row();
          $usuario_registrado[] = get_sub_field('usuario', $comment->comment_post_ID); // Array usuários registrados
          $acesso_registrado[] = get_sub_field('acesso', $comment->comment_post_ID); // Array acessos registrados
        }

        $key = array_search($current_user->user_login, $usuario_registrado); // Procura a posição no array de usuários registrados

        // Usuário logado visitou
        if ($key !== false) {

          $last_comment_time = get_comment_date('YmdHis', $comment->comment_ID);

          if ($last_comment_time > $acesso_registrado[$key]) {
            $num_nao_lidas++;
            $msgs_nao_lidas = true;
            // if ($i > 31 && !$msgs_nao_lidas) {
            //   $msgs_nao_lidas = true;
            // }

          }

        }

      }

      $usuario_registrado = array(); // Limpa o array
      $acesso_registrado = array(); // Limpa o array

      endforeach;

      // Todas as solicitações com interações não lidas
      if ($msgs_nao_lidas) {
      echo '<a href="';
      bloginfo('url');
      echo '/interacoes/" class="item" style="text-align: left; padding: 20px !important; border-top: 1px solid #dedede !important;"><strong><i class="ui yellow info circle icon"></i>Veja todas as solicitações com interações não lidas</strong></a>';
      }

    endif;
  endif;

// COMMENT QUERY

if (!empty($posts_array)) : // Se não tiver posts na query anterior, não inicia essa query.

  $comment_args = array(
      //'post_type'      => 'tarefa',
      'number'         => '31',
      'order'          => 'DESC',
      'orderby'        => 'comment_date',
      'post__in'       => $posts_array, //THIS IS THE ARRAY OF POST IDS WITH META QUERY
      'meta_query'     => array( $privado ),
  );

  $comments_query = new WP_Comment_Query;
  $comments = $comments_query->query( $comment_args );

  ?>

  <?php if ( !empty( $comments ) ) : ?>

    <?php foreach ( $comments as $comment ) : ?>

      <a href="<?php the_permalink($comment->comment_post_ID); ?>" class="item <?php lido_nao_lido('feed-lido', 'feed-nao-lido'); ?>" style="border-top: 1px solid #dedede !important;">

  			<span style="line-height:1.5;">
          <strong><?= $comment->comment_author ?></strong> disse:
  				<br>
  				<em><?php comment_excerpt(); ?></em>
  			</span>
  			<br>
  			<span class="cd-disabled">
          <?php // comment_date('d/m'); echo ', às '; comment_date('H:i') ?>
          <i class="purple comment icon"></i><?php echo 'Há ' . human_time_diff( get_comment_date('U'), current_time('timestamp') ); ?>
          <?php if ( get_field('privado_interacao', $comment) ) { echo ' <i class="lock icon" style="margin:0;"></i>'; } ?>
          <?php if ( have_rows('arquivos_interacao', $comment) ) { echo '<i class="attach icon"></i>'; } ?>
        	<br>
  				<i class="green file text icon"></i><?php the_field('unidade', $comment->comment_post_ID); echo '&nbsp;&nbsp;|&nbsp;&nbsp;' . get_the_title($comment->comment_post_ID); ?>
  			</span>

      </a>

    <?php endforeach; ?>

    <?php if ( current_user_can( 'edit_pages' ) ) : ?>
      <a href="<?php bloginfo('url') ?>/interacoes" class="item" style="text-align: center; padding: 20px !important; border-top: 1px solid #dedede !important;"><strong>Ver todas</strong></a>
    <?php else : ?>
      <a href="<?php bloginfo('url') ?>/interacoes" class="item" style="text-align: center; padding: 20px !important; border-top: 1px solid #dedede !important;"><strong>Ver todas</strong></a>
    <?php endif; ?>

  <?php else : ?>

  <a class="item">
    <i class="grey comment icon"></i>Não há interações
  </a>

  <?php endif; ?>

<?php endif; wp_reset_postdata(); ?>

<script type="text/javascript">var num_nao_lidas = <?php echo $num_nao_lidas ?>;</script>
