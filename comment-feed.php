<?php

// CD-FEED
include ( locate_template('template-parts/cd-feed.php') );

//$teste = get_field('finalidade', 'comment_post_ID');

$args = array(
  // 'status'         => 'approve',
	// 'type'           => 'comment',
	// 'post_author'    => $current_user->ID,
	'post_type'      => 'tarefa',
	'number'         => '10',
	'order'          => 'DESC',
	'orderby'        => 'comment_date',
  // 'meta_key'        => 'finalidade',
  // 'meta_value'      => 'devento',
  //'meta_query'     => array( 'meta_key' => 'privado_interacao, comment_post_ID', 'meta_value' => '1' )
);

// The comment query
$comments_query = new WP_Comment_Query;
$comments = $comments_query->query( $args );
?>

<?php if ( !empty( $comments ) ) : ?>

  <?php foreach ( $comments as $comment ) : ?>

    <?php // $teste = get_field('finalidade', $comment->comment_post_ID); ?>
    <?php // if ($teste['value'] == 'devento') : ?>

    <a href="<?php the_permalink($comment->comment_post_ID); ?>" class="item" style="border-top: 1px solid #dedede !important;">
      <strong style="line-height: 2;"><?php the_field('unidade', $comment->comment_post_ID); echo '&nbsp;&nbsp;|&nbsp;&nbsp;' . get_the_title($comment->comment_post_ID); ?></strong><br>
      <span class="cd-disabled">
        <i class="user icon"></i><?php echo '<strong>' . $comment->comment_author . '</strong>' . ' disse:<br><i class="purple comments icon"></i><em>' . $comment->comment_content . '</em>'; ?><br>
        <?php // comment_date('d/m'); echo ', às '; comment_date('H:i') ?>
        <i class="green refresh icon"></i><?php echo 'Há ' . human_time_diff( get_comment_date('U'), current_time('timestamp') ); ?>
      </span>
    </a>

    <?php // endif; ?>

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
