
  <?php

  // CD-FEED
  include ( locate_template('template-parts/cd-feed.php') );

  $args = array(
    'post_type'              => array( 'tarefa' ),
    'posts_per_page'         => '30',
    'order'                  => 'DESC',
    'orderby'                => 'modified',
    'author'                 => $feed_rc,
    'meta_query'             => array( $feed_cd ),
  );

  $query = new WP_Query( $args );

  ?>

  <i class="refresh icon" style="margin:0;"></i>
  <div class="floating ui red label contador"></div>

  <div class="menu">

  <?php if ( $query->have_posts() ) : ?>

    <?php while ( $query->have_posts() ) : $query->the_post();

      // VARIAVEIS TAREFAS
      include ( locate_template('template-parts/var-tarefas.php') ); ?>

      <a href="<?php the_permalink();?>" class="item <?php lido_nao_lido('feed-lido', 'feed-nao-lido') ?>" style="border-top: 1px solid #dedede !important;">
        <strong style="line-height: 2;"><?php the_field('unidade'); echo '&nbsp;&nbsp;|&nbsp;&nbsp;'; the_title(); ?></strong><br>
        <span class="cd-disabled">
          <i class="purple comments icon"></i><?php comments_number('0 interações', '1 interação', '% interações' );?><br>
          <i class="green refresh icon"></i><?php echo human_time_diff( get_the_modified_time('U'), current_time('timestamp') ) . ' atrás'; ?>
        </span>
      </a>

    <?php endwhile; ?>

    <?php if ( current_user_can( 'edit_pages' ) ) : ?>
      <a href="http://cd.intranet.sp.senac.br/index.php/minhas-tarefas/" class="item" style="text-align: center; padding: 20px !important; border-top: 1px solid #dedede !important;"><strong>Ver todas</strong></a>
    <?php else : ?>
      <a href="http://cd.intranet.sp.senac.br/index.php/minhas-solicitacoes/" class="item" style="text-align: center; padding: 20px !important; border-top: 1px solid #dedede !important;"><strong>Ver todas</strong></a>
    <?php endif; ?>

  <?php else : ?>

    <div class="item">
      <i class="grey refresh icon"></i>Não há notificações
    </div>

  <?php endif; wp_reset_postdata(); ?>

  </div>
