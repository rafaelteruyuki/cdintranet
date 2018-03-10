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

  if ( current_user_can( 'senac' ) ) {
    $privado = array(
    'key' => 'privado_interacao',
    'value' => '1',
    'compare' => '!=',
    );
  }

  // CD-FEED
  include ( locate_template('template-parts/cd-feed.php') );

  $post_args = array(
    'post_type'              => array( 'tarefa' ),
    'posts_per_page'         => -1,
    'order'                  => 'DESC',
    'meta_query'             => array( $comment_feed ),
  );

  // QUERY DOS POSTS DE ACORDO COM CADA FEED
  $post_query = new WP_Query( $post_args );
  $posts_array= array();
  global $post;
  $lastposts = get_posts( $post_args );

  foreach ( $lastposts as $post ) : setup_postdata( $post );
    $posts_array[] = get_the_ID();
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

    $interacao = 0;

    if (!empty($comments)) :

  					foreach($comments as $comment) {

              if( have_rows('visitas', $comment->comment_post_ID) ) {

        				while ( have_rows('visitas', $comment->comment_post_ID) ) {
        					the_row();
        					$usuario_registrado[] = get_sub_field('usuario', $comment->comment_post_ID); // Array usuários registrados
        					$acesso_registrado[] = get_sub_field('acesso', $comment->comment_post_ID); // Array acessos registrados
        				}

        				$key = array_search($current_user->user_login, $usuario_registrado); // Procura a posição no array de usuários registrados

        				// Usuário logado visitou
        				if ($key !== false) :

    						$last_comment_time = get_comment_date('YmdHis', $comment->comment_ID);

    						if ($last_comment_time > $acesso_registrado[$key]) :

                  // NAO INSERE POSTS DUPLICADOS
                  if ( !in_array($comment->comment_post_ID, $comment_post_IDs, true ) ) {
                  $comment_post_IDs[] = $comment->comment_post_ID;

                  $interacao++;

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
    							<div class="ui clearing segment" style="background: #ebf7ff;">
                    <span style="line-height:1.5;">
                      <strong><?php the_field('unidade', $comment->comment_post_ID); echo '&nbsp;&nbsp;|&nbsp;&nbsp;' . get_the_title($comment->comment_post_ID); ?></strong>
              			</span>
                    <br>
                    <span class="cd-disabled" style="line-height:2;text-transform: lowercase;">
                      <i class="purple comment icon"></i><?php num_comentarios(true, $comment->comment_post_ID);?>
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

                <?php } ?>

    						<?php endif;

                else :

                  // NAO INSERE POSTS DUPLICADOS
                  if ( !in_array($comment->comment_post_ID, $comment_post_IDs, true ) ) {
                  $comment_post_IDs[] = $comment->comment_post_ID;

                  $interacao++;

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
    							<div class="ui clearing segment" style="background: #ebf7ff;">
                    <span style="line-height:1.5;">
                      <strong><?php the_field('unidade', $comment->comment_post_ID); echo '&nbsp;&nbsp;|&nbsp;&nbsp;' . get_the_title($comment->comment_post_ID); ?></strong>
              			</span>
                    <br>
                    <span class="cd-disabled" style="line-height:2;text-transform: lowercase;">
                      <i class="purple comment icon"></i><?php num_comentarios(true, $comment->comment_post_ID);?>
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

                <?php }

                endif;

                $usuario_registrado = array(); // Limpa o array
                $acesso_registrado = array(); // Limpa o array

  					}

  				}

          if ($interacao == 0) :
            echo '<div class="ui center aligned container cd-margem"><h3>Você visualizou todas as interações.</h3></div>';
          endif;

          else : ?>

          <div class="ui center aligned container cd-margem">
            <h3>Não há interações.</h3>
          </div>

  		<?php endif;

    endif;

  wp_reset_postdata();
?>

</div>

<?php else : ?>

<div class="ui center aligned container cd-margem">
  <h3>Faça login para visualizar.</h3>
</div>

<?php endif; ?>

<script type="text/javascript">

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
