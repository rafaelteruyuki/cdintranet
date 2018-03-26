<?php

// CD-FEED
include ( locate_template('template-parts/cd-feed.php') );

/* --------------------------

GRAVA O ID DO USUARIO LOGADO NAS INTERACOES LIDAS DO POST EM QUESTAO

---------------------------- */

if (is_singular('tarefa')) :

$lidas_args = array(
  'post_id' => get_the_ID(),
  'fields' => 'ids',
  'meta_query' => array( $privado ),
);

$comments_query = new WP_Comment_Query;
$comments = $comments_query->query( $lidas_args );

  if ( !empty( $comments ) ) :

    foreach ( $comments as $comment ) :

    $interacao_lida = get_comment_meta( $comment, 'interacao_lida', true );

    if ($interacao_lida) {
      // Há usuário(s) que leram essa interação (acrescenta o usuário a esse array)
      $interacao_lida[] = $current_user->ID;
      $interacao_lida = array_unique($interacao_lida);
    } else {
      // Não há usuários que leram essa interação (cria um array e insere o usuário)
      $interacao_lida = array();
      $interacao_lida[] = $current_user->ID;
    }

    $interacao_lida = array_unique($interacao_lida);
    $interacao_lida = array_map('intval', $interacao_lida);
    update_comment_meta( $comment, 'interacao_lida', $interacao_lida );

    $interacao_lida = array();

    endforeach;

  endif;

endif;

/* --------------------------

PEGA TODOS OS POSTS QUE TEM RELACAO COM O USUARIO LOGADO

---------------------------- */

// META_QUERY DOS POSTS IDS
$post_args = array(
  'post_type'              => array( 'tarefa' ),
  'posts_per_page'         => -1,
  'order'                  => 'DESC',
  'fields'                 => 'ids',
  'meta_query'             => array( $comment_feed ),
);

$posts_array = get_posts( $post_args );

if (!empty($posts_array)) : // Se não tiver posts, não inicia essa query.

  $comments_args = array(
      'order'          => 'DESC',
      'orderby'        => 'comment_date',
      'number'         => '31',
      'post__in'       => $posts_array, //THIS IS THE ARRAY OF POST IDS WITH META QUERY
      'meta_query'     => array( $privado ),
  );

  $comments_query = new WP_Comment_Query;
  $comments = $comments_query->query( $comments_args );

  ?>

  <a href="<?php bloginfo('url')?>/interacoes/" class="item" id="interacoes-nao-lidas" style="display: none; text-align: left; padding: 20px !important; border-top: 1px solid #dedede !important;"><strong><i class="ui yellow info circle icon"></i>Veja todas as solicitações com interações não lidas</strong></a>

  <?php

  if ( !empty( $comments ) ) :

    foreach ( $comments as $comment ) : ?>

      <a href="<?php the_permalink($comment->comment_post_ID); ?>" class="item <?php echo lido_nao_lido('feed-lido', 'feed-nao-lido'); ?>" style="border-top: 1px solid #dedede !important;">

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

      <a href="<?php bloginfo('url') ?>/interacoes" class="item" style="text-align: center; padding: 20px !important; border-top: 1px solid #dedede !important;"><strong>Ver todas</strong></a>

      <?php else : ?>

      <a class="item"><i class="grey comment icon"></i>Não há interações</a>

      <?php endif; ?>

    <?php else : ?>

    <a class="item"><i class="grey comment icon"></i>Não há interações</a>

<?php endif;

/* --------------------------

CONTA O NUMERO DE INTERACORES NAO LIDAS PELO USUARIO LOGADO

---------------------------- */

$nao_lidas_args = array(
    'post__in'       => $posts_array,
    'count' => true,
    'meta_query'     => array(
      'relation' => 'AND',
      array(
      'key' => 'interacao_lida',
      'value' => $current_user->ID, // Não precisa de aspas pq o valor guardado é INT (numero inteiro)
      'compare' => 'NOT LIKE',
      ),
      $privado
    ),
);

$comments_query = new WP_Comment_Query;
$comments = $comments_query->query( $nao_lidas_args );
wp_reset_postdata();
?>

<span style="display:none;" id="num_nao_lidas"><?= $comments ?></span>
