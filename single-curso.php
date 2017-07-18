<?php get_header(); ?>

<!-- Single Curso -->

<?php
    /* Carregando os campos */

    //modalidade
    $modalidade = get_field_object('modalidade');
    $value = $modalidade['value'];
    $lblModalidade = $modalidade['choices'][ $value ];

    //area
    $area= get_field_object('area');
    $lblArea = $area['choices'][$area['value']];

    //subarea
    $subarea= get_field_object('subarea-' . $area['value'] );
    $lblSubarea = $subarea['choices'][$subarea['value']];

//    //imagem url
//    if (has_post_thumbnail()) {
//        $urlImg = get_the_post_thumbnail_url();
//    }else{
//        $urlImg = "";
//    }

    //info-curso
    $infoCurso = get_field('info-curso') ? get_field('info-curso') : "";

?>

<div class="ui vertical basic segment cd-margem">

  <div class="ui grid container stackable">

      <div class="six wide column">

      	<!-- IMAGEM REDES SOCIAIS -->

      	<?php if(has_post_thumbnail()):?>
      	<div class="ui disabled sub header">Imagem Redes Sociais</div>
        <?php the_post_thumbnail('full', array( 'class' => 'imagem-single-curso' ) ); ?>
        <div class="ui fitted hidden divider"></div>
        <a href="<?php the_post_thumbnail_url('full'); ?>" class="ui labeled icon primary fluid button botao-imagem" target="_blank" download><i class="download icon"></i>Baixar</a>
        <?php endif; ?>

        <!-- IMAGEM BANNER PORTAL -->

				<?php $bannerportal = get_field('banner_portal');

				if( !empty($bannerportal) ): ?>

        <div class="ui hidden divider"></div>
        <div class="ui disabled sub header">Banner Portal</div>
        <img src="<?php echo $bannerportal['url']; ?>" alt="<?php echo $bannerportal['alt']; ?>" class="imagem-single-curso"/>
        <div class="ui fitted hidden divider"></div>
        <a href="<?php echo $bannerportal['url']; ?>" class="ui labeled icon primary fluid button botao-imagem" target="_blank" download><i class="download icon"></i>Baixar</a>

				<?php endif; ?>

      </div>



    <div class="ten wide column">

      <div class="ui disabled sub header"><?php echo $lblModalidade; ?></div>
      <div style="margin-bottom:15px;"><h1><?php the_title(); ?></h1></div>
      <div>
        <h3>
          <?php echo $lblArea; if($lblSubarea): ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $lblSubarea; endif; ?>
				</h3>
      </div>
      <br>
      <?php edit_post_link('Editar', '', '', '', 'ui button'); ?>

      <div class="ui divider"></div>


        <div class="texto-curso">
          <div style="margin-bottom:5px;"><strong>Texto aprovado</strong></div>
          <p><?php
					if(get_field('texto-curso')) {
						the_field('texto-curso');
					} else { echo '<i class="warning circle icon"></i>Não há texto cadastrado.';
					}?></p>
        </div>
      <br>
      <?php if($infoCurso): ?>
        <div>
            <i class="info circle yellow icon"></i>
            <em><?php echo $infoCurso; ?></em>
        </div>
        <div class="ui hidden divider"></div>
      <?php endif; ?>

      	<div class="ui divider"></div>
        <div style="margin-bottom:5px;"><strong>E-mail marketing</strong></div>
              <?php if( have_rows('emails-curso') ): ?>

        <div class="lista-url">
          <dl style="margin:0;">
            <?php while( have_rows('emails-curso') ): the_row();

              $unidade = get_sub_field_object('unidade-curso-url');
              $lblUnidade = $unidade['choices'][$unidade['value']];

              $url = get_sub_field('email-curso-url');
            ?>
              <dt><?php echo $lblUnidade; ?></dt>
              <dd><a href="<?php echo $url; ?>" target="_blank"><?php echo $url; ?></a></dd>
              <br>

            	<?php endwhile; ?>
          </dl>

        </div>
      <?php else : ?>
      <i class="warning circle icon"></i>Não há e-mail cadastrado.
      <?php endif; ?>
      <div class="ui hidden divider"></div>
      <a href="http://cd.intranet.sp.senac.br/solicitacao/" class="ui right labeled icon button">
        <i class="right arrow icon"></i>
        Solicitar adaptação da peça.
      </a>
    </div>
  </div>
</div>

<span class="ui horizontal divider header cd-margem">
  <a href="javascript:history.back()">
    <i class="left arrow icon"></i>
    Voltar
  </a>
</span>

<?php get_footer(); ?>
