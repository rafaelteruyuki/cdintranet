<?php

// CD-FEED
include ( locate_template('template-parts/cd-feed.php') );

/* --------------------------

GRAVA O ID DO USUARIO LOGADO NAS INTERACOES LIDAS DO POST EM QUESTAO E NA TAREFA

---------------------------- */

if (is_singular('tarefa')) :

  // Interações

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

  // Tarefas

  $tarefa_lida = get_post_meta( get_the_ID(), 'tarefa_lida', true );

  if ($tarefa_lida) {
    // Há usuário(s) que leram essa tarefa (acrescenta o usuário a esse array)
    $tarefa_lida[] = $current_user->ID;
    $tarefa_lida = array_unique($tarefa_lida);
  } else {
    // Não há usuários que leram essa tarefa (cria um array e insere o usuário)
    $tarefa_lida = array();
    $tarefa_lida[] = $current_user->ID;
  }

  $tarefa_lida = array_unique($tarefa_lida);
  $tarefa_lida = array_map('intval', $tarefa_lida);
  update_post_meta( get_the_ID(), 'tarefa_lida', $tarefa_lida );

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

  <a href="<?php bloginfo('url')?>/interacoes/" class="item" id="interacoes-nao-lidas" style="display: none; text-align: left; padding: 16px !important;"><i class="comment icon blue"></i><span style="color:#2185d0">Ver interações não lidas</span></a>
  <a href="#" class="item" id="marcar-lidas" style="display: none; text-align: left; padding: 16px !important; border-top: 1px solid #dedede !important;"><i class="check icon blue"></i><span style="color:#2185d0">Marcar todas como lidas</span></a>

  <?php

  if ( !empty( $comments ) ) :

    foreach ( $comments as $comment ) : ?>

      <a href="<?php the_permalink($comment->comment_post_ID); ?>?comment_id=<?php comment_ID() ?>" class="item <?php echo lido_nao_lido('feed-lido', 'feed-nao-lido'); ?>" style="border-top: 1px solid #dedede !important;">

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

      <?php else : ?>

      <a class="item"><i class="grey comment icon"></i>Não há interações</a>

      <?php endif; ?>

    <?php else : ?>

    <a class="item"><i class="grey comment icon"></i>Não há interações</a>

<?php endif;

/* --------------------------

CONTA O NUMERO DE INTERACORES NAO LIDAS PELO USUARIO LOGADO

---------------------------- */

// Verifica se há posts para os args
if ($posts_array) :

  $nao_lidas_args = array(
      'post__in'       => $posts_array,
      'meta_query'     => array($privado),
      'fields' => 'ids',
      // 'number' => 5,
      // 'count' => true,
  );

  $comments = get_comments($nao_lidas_args);

  $num_nao_lidas = 0;

    foreach ($comments as $comment) {

      $interacao_lida = get_comment_meta($comment, 'interacao_lida', true);

      if (!in_array($current_user->ID, $interacao_lida, true)) {

        // echo '<div class="teste">';
        //
        // echo 'Current user: ' . $current_user->ID;
        // echo 'Não tem no array';
        // echo 'IDs que visitaram a interação:'; var_dump($interacao_lida);
        //
        // echo '</div>';

        $num_nao_lidas++;

      }

    }

else :

  $num_nao_lidas = 0;

endif;

wp_reset_postdata();

?>

<span style="display:none;" id="num_nao_lidas"><?= $num_nao_lidas ?></span>
