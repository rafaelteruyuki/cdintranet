<?php

include ( locate_template('template-parts/cd-feed.php') );

$args = array(
  'post_type'              => array( 'tarefa' ),
  'posts_per_page'         => '31',
  'order'                  => 'DESC',
  'orderby'                => 'modified',
  'author'                 => $feed_rc,
  'meta_query'             => array( $minhas_tarefas_feed ),
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) : ?>

<?php while ( $query->have_posts() ) : $query->the_post();

  // VARIAVEIS TAREFAS
  include ( locate_template('template-parts/var-tarefas.php') ); ?>

  <a href="<?php the_permalink();?>" class="item <?php lido_nao_lido('feed-lido', 'feed-nao-lido') ?>" style="border-top: 1px solid #dedede !important;">
    <strong style="line-height: 2;"><?php the_field('unidade'); echo '&nbsp;&nbsp;|&nbsp;&nbsp;'; the_title(); ?></strong><br>
    <span class="cd-disabled">
      <i class="green refresh icon"></i><?php echo 'Há ' . human_time_diff( get_the_modified_time('U'), current_time('timestamp') ); ?><?php if ( get_post_meta(get_post()->ID, '_edit_last') ) { echo ', por '; the_modified_author(); } ?><br>
      <i class="purple comments icon"></i><?php comments_number('0 interações', '1 interação', '% interações' );?><br>
      <i class="power icon"></i><?= $status['label'] ?>
    </span>
  </a>

<?php endwhile; ?>

<?php if ( current_user_can( 'edit_pages' ) ) : ?>
  <a href="http://cd.intranet.sp.senac.br/minhas-tarefas/" class="item" style="text-align: center; padding: 20px !important; border-top: 1px solid #dedede !important;"><strong>Ver todas</strong></a>
<?php else : ?>
  <a href="http://cd.intranet.sp.senac.br/minhas-solicitacoes/" class="item" style="text-align: center; padding: 20px !important; border-top: 1px solid #dedede !important;"><strong>Ver todas</strong></a>
<?php endif; ?>

<?php else : ?>

<div class="item">
  <i class="grey refresh icon"></i>Não há notificações
</div>

<?php endif; wp_reset_postdata(); ?>

<?php update_field( 'field_595feb818431d', false,'user_' . $current_user->ID); // Atualizar feed == unchecked ?>
