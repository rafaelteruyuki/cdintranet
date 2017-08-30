<?php

// CD-FEED
include ( locate_template('template-parts/cd-feed.php') );

$post_args = array(
  'post_type'              => array( 'tarefa' ),
  'posts_per_page'         => -1,
  'order'                  => 'DESC',
  //'orderby'                => 'comment_date',
  'author'                 => $feed_rc,
  'meta_query'             => array( $feed_cd ),
);

$post_query = new WP_Query( $post_args );
$posts_array= array();
if ( $post_query->have_posts() ) {
    while ( $post_query->have_posts() ) {
        $post_query->the_post();
        $posts_array[] = get_the_ID(); //Array of post ids
    }
    wp_reset_postdata();
}
// Se o usuário for Senac, não mostra os comentários privados
if ( current_user_can('senac') ) {
  $privado = array(
  'key' => 'privado_interacao',
  'value' => '1',
  'compare' => '!=',
  );
}

$comment_args = array(
    //'post_type'      => 'tarefa',
    'number'         => '31',
    'order'          => 'DESC',
    'orderby'        => 'comment_date',
    'post__in'       => $posts_array, //THIS IS THE ARRAY OF POST IDS WITH META QUERY
    'post_author'    => $feed_rc,
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
    <a href="http://cd.intranet.sp.senac.br/minhas-tarefas/" class="item" style="text-align: center; padding: 20px !important; border-top: 1px solid #dedede !important;"><strong>Ver todas</strong></a>
  <?php else : ?>
    <a href="http://cd.intranet.sp.senac.br/minhas-solicitacoes/" class="item" style="text-align: center; padding: 20px !important; border-top: 1px solid #dedede !important;"><strong>Ver todas</strong></a>
  <?php endif; ?>

<?php else : ?>

  <div class="item">
    <i class="grey refresh icon"></i>Não há interações
  </div>

<?php endif; ?>
