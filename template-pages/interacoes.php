<?php

/*
Template Name: Interações
*/

get_header();

global $current_user;

?>

<h2 class="ui horizontal divider header cd-margem">Solicitações com interações não lidas</h2>

<?php if (is_user_logged_in() ) : ?>

<div class="ui container cd-margem">

  <?php

  // CD-FEED
  include ( locate_template('template-parts/cd-feed.php') );

  // // NOVAS TAREFAS
  //
  // $novas_args = array(
  //   'post_type'              => array( 'tarefa' ),
  //   'posts_per_page'         => -1,
  //   'order'                  => 'DESC',
  //   'meta_query'     => array(
  //     'relation' => 'AND',
  //     array(
  //     'key' => 'tarefa_lida',
  //     'value' => $current_user->ID, // Não precisa de aspas pq o valor guardado é INT (numero inteiro)
  //     'compare' => 'NOT LIKE',
  //     ),
  //     $comment_feed
  //   ),
  // );
  //
  // $novas = new WP_Query($novas_args);

  $post_args = array(
    'post_type'              => array( 'tarefa' ),
    'posts_per_page'         => -1,
    'order'                  => 'DESC',
    'fields'                 => 'ids',
    'meta_query'             => array( $comment_feed ),
  );

  $posts_array = get_posts( $post_args );

  // SE TIVER POSTS
  if ( $posts_array ) :

    $nao_lidas_args = array(
        'post__in'       => $posts_array,
        'meta_query'     => array($privado),
        // 'fields' => 'ids',
        // 'number' => 5,
        // 'count' => true,
    );

    $comments = get_comments($nao_lidas_args);

      // SE TIVER COMENTARIOS
      if ( $comments ) :

  			foreach ( $comments as $comment ) :

      			$interacao_lida = get_comment_meta( $comment->comment_ID, 'interacao_lida', true );

      			if (!in_array($current_user->ID, $interacao_lida)) :

              // NAO INSERE POSTS DUPLICADOS
              if ( !in_array($comment->comment_post_ID, $comment_post_IDs, true ) ) :
              $comment_post_IDs[] = $comment->comment_post_ID;

              // VARIAVEIS TAREFAS
              $responsavel1 = get_field('responsavel_1', $comment->comment_post_ID);
              $responsavel2 = get_field('responsavel_2', $comment->comment_post_ID);
              $responsavel3 = get_field('responsavel_portal', $comment->comment_post_ID);
              $responsavel4 = get_field('responsavel_portal_2', $comment->comment_post_ID);
              $status = get_field('status', $comment->comment_post_ID);

              switch ($status['value']) {
                  case "naoiniciado":
                      $percent = 0;
                      $corStatus = '';
                      break;
                  case "cancelado":
                      $percent = 0;
                      $corStatus = 'grey';
                      break;
                  case "incompleto":
                      $percent = 15;
                      $corStatus = 'red';
                      break;
                  case "aguardandoinformacao":
                      $percent = 35;
                      $corStatus = 'orange';
                      break;
                  case "emproducao":
                      $percent = 50;
                      $corStatus = 'yellow';
                      break;
                  case "fluxors":
                      $percent = 50;
                      $corStatus = 'yellow';
                      break;
                  case "fluxoportal":
                      $percent = 50;
                      $corStatus = 'yellow';
                      break;
                  case "publicado":
                      $percent = 70;
                      $corStatus = 'olive';
                      break;
                  case "finalizado":
                      $percent = 100;
                      $corStatus = 'green';
                      break;
              }
            ?>

						<div class="ui clearing segment" style="background: #ebf7ff; display:none">
              <span style="line-height:1.5;">
                <strong><?php the_field('unidade', $comment->comment_post_ID); echo '&nbsp;&nbsp;|&nbsp;&nbsp;' . get_the_title($comment->comment_post_ID); ?></strong>
        			</span>
              <br>
              <span class="cd-disabled" style="line-height:2;">
                <i class="purple comment icon"></i><span style="text-transform: lowercase;"><?php num_comentarios(true, $comment->comment_post_ID);?></span>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo 'Última há ' . human_time_diff( get_comment_date('U'), current_time('timestamp') ); ?>
        			</span>
              <br>
              <span style="line-height:3;">
                <?php if ($responsavel1) : ?><span class="ui avatar image" data-tooltip="<?php echo $responsavel1['display_name'] ?>"><?php echo $responsavel1['user_avatar']; ?></span><?php endif; ?>
            		<?php if ($responsavel2) : ?><span class="ui avatar image" data-tooltip="<?php echo $responsavel2['display_name'] ?>"><?php echo $responsavel2['user_avatar']; ?></span><?php endif; ?>
                <?php if ($responsavel3) : ?><span class="ui avatar image" data-tooltip="<?php echo $responsavel3['display_name'] ?>"><?php echo $responsavel3['user_avatar']; ?></span><?php endif; ?>
                <?php if ($responsavel4) : ?><span class="ui avatar image" data-tooltip="<?php echo $responsavel4['display_name'] ?>"><?php echo $responsavel4['user_avatar']; ?></span><?php endif; ?>
              </span>
              <br>
              <div style="color: #FFF; float: left; margin-top: 10px;"><div class="ui <?= $corStatus ?> label"><?php echo $status['label'] ?></div></div>
              <a href="<?php the_permalink($comment->comment_post_ID); ?>" target="_blank" class="ui blue right labeled icon button" style="float:right;"><i class="right arrow icon"></i>Veja mais</a>
            </div>

            <?php

              endif;

            endif;

					endforeach;

        else :

          echo '<div class="ui center aligned container cd-margem"><h3>Você visualizou todas as interações.</h3></div>';

        endif;

        else : ?>

        <div class="ui center aligned container cd-margem">
          <h3>Não há interações.</h3>
        </div>

  <?php endif;

  wp_reset_postdata();
?>

</div>

<?php else : ?>

<div class="ui center aligned container cd-margem">
  <h3>Faça login para visualizar.</h3>
</div>

<?php endif; ?>

<script type="text/javascript">
  $( ".ui.clearing.segment" ).first().show( 200, function showNext() {
    $( this ).next( ".ui.clearing.segment" ).show( 200, showNext );
  });
  // if ( !$('.msg-nao-lida').length ) {
  //   $('#info').html('<h3>Não há interações não lidas.</h3>');
  // } else {
  //   $('#info').html('<h3>Mostrando somente as interações não lidas.</h3>');
  // }
  // // MOSTRAR TODAS
  // $('.btn-todas').click( function() {
  //   $('.btn-nao-lidas').removeClass('blue');
  //   $('.btn-todas').addClass('blue');
  //   $('.msg-lida').show();
  //   $('#info').html('<h3>Mostrando todas as interações.</h3>');
  // });
  // // MOSTRAR NAO LIDAS
  // $('.btn-nao-lidas').click( function() {
  //   $('.btn-todas').removeClass('blue');
  //   $('.btn-nao-lidas').addClass('blue');
  //   $('.msg-lida').hide();
  //   if ( !$('.msg-nao-lida').length ) {
  //     $('#info').html('<h3>Não há interações não lidas.</h3>');
  //   } else {
  //     $('#info').html('<h3>Mostrando somente as interações não lidas.</h3>');
  //   }
  // });
  //
  // $('#carregando').hide();

</script>

<?php get_footer(); ?>
