<?php

/*
Template Name: Mensagens não lidas
*/

get_header();

global $current_user;

?>

<style media="screen">
  .msg-lida {
    display: none;
  }
  .msg-nao-lida {
    background-color: #ebf7ff !important;
  }
</style>

<h2 class="ui horizontal divider header cd-margem">Interações</h2>

<div class="ui center aligned container cd-margem">

  <div class="ui hidden divider"></div>
  <button class="ui button btn-nao-lidas" style="display:none;">Mostrar somente não lidas</button>
  <button class="ui button btn-todas" style="display:none;">Mostrar todas as interações</button>
  <div class="ui hidden divider"></div>
  <div id="msg" style="display:none;">Não há interações não lidas.</div>
  <div id="info"></div>

</div>

<div class="ui container cd-margem">

  <?php

  // CD-FEED
  include ( locate_template('template-parts/cd-feed.php') );

  /* ---------------------------------------

  PEGO OS POSTS COM O FEED DE CADA USUARIO

  --------------------------------------- */

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

  /* ---------------------------------------

  FACO A QUERY DE COMENTARIOS, CONSIDERANDO O FEED DE POSTS ACIMA

  --------------------------------------- */

  // REMOVE COMENTARIOS PRIVADOS DOS USUARIOS SENAC E DE USUARIOS NAO LOGADOS
  if ( current_user_can( 'senac' ) || !is_user_logged_in() ) {
    $privado = array(
    'key' => 'privado_interacao',
    'value' => '1',
    'compare' => '!=',
    );
  }

  if (!empty($posts_array)) : // Se não tiver posts na query anterior, não inicia essa query.

    $comment_args = array(
        //'post_type'      => 'tarefa',
        // 'number'         => '31',
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

        <div class="ui clearing segment <?php lido_nao_lido('msg-lida', 'msg-nao-lida'); ?>">

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

        <a href="<?php the_permalink($comment->comment_post_ID); ?>" target="_blank" class="ui blue right labeled icon button" style="float:right;"><i class="right arrow icon"></i>Veja mais</a>

        </div>

      <?php endforeach; ?>

    <?php endif; ?>

    <?php else : ?>

    <div class="item">
      <i class="grey refresh icon"></i>Não há interações
    </div>

  <?php endif; ?>


</div>

<script type="text/javascript">

  if ( !$('.msg-nao-lida').length ) {

    $('#msg').show();
    $('.btn-nao-lidas').hide();
    $('.btn-todas').show();

    $('.btn-nao-lidas').click( function() {
      $('#msg').show();
    });

  } else {
    // $('.btn-nao-lidas').show();
    $('.btn-todas').show();
    $('#info').html('<h3>Mostrando interações não lidas.</h3>');
  }

  $('.btn-todas').click( function() {
    $('.msg-lida').show();
    $('.btn-todas').hide();
    $('.btn-nao-lidas').show();
    $('#msg').hide();
    $('#info').html('<h3>Mostrando todas as interações.</h3>');
  });
  $('.btn-nao-lidas').click( function() {
    $('.msg-lida').hide();
    $('.btn-todas').show();
    $('.btn-nao-lidas').hide();
  });

</script>

<?php get_footer(); ?>
