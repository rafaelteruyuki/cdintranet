
<?php get_header(); ?>
bla bla bla
<h1>SINGLE NORMAL</h1>

<div class="ui four column grid container stackable cd-margem">

<!-- loop -->
<!-- Lista de parametros para chamar custom post type -->
	<?php
		$args = array(
			'post_type'		=> 'curso',
			'show_posts'	=> -1,
			'order'			=> 'DESC',
			'orderby'		=> 'date'
		);
	?>
	<!-- chamo os parametros da variavel args -->
	<?php $query = new WP_Query($args); ?>

	<!-- verifico se tenho posts, se tiver, exibo eles -->
 	<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>

	<!-- CARD -->
      <div class="column">
        <div class="ui fluid card">
          <div class="image">
            <div class="ui dimmer">
              <div class="content">
                <div class="center">
                  <a href="<?php the_permalink(); ?>" class="ui inverted button">Detalhes</a>
                </div>
              </div>
            </div>
            <?php the_post_thumbnail(); ?>
          </div>
          <div class="content">
            <a href="<?php the_permalink(); ?>" class="header"><?php the_title(); ?></a>
            <div class="meta"><?php the_field('modalidade'); ?></div>
          </div>
        </div>
      </div>

	<?php endwhile; else: ?>
		<h3>Não possui nenhum curso cadastrado.</h3>
	<?php endif; ?>
	<!-- fim loop -->

</div>





<!-- Single Curso -->

<div class="ui hidden divider"></div>

<div class="ui vertical basic segment cd-margem">

  <div class="ui grid container stackable">

    <div class="six wide column">
      <a href="#"><img class="ui fluid rounded image" src="images/20160831_OperadorTelemarketing_600px.jpg"></a>
    </div>

    <div class="ten wide column">

      <div class="ui disabled sub header">Curso Livre</div>
      <div><h1>Operador de Telemarketing</h1></div>

      <div class="ui hidden divider"></div>

      <div><h3>Gestão e Negócios&nbsp;&nbsp;|&nbsp;&nbsp;Marketing</h3></div>

      <div class="ui divider"></div>

      <div><strong>Designers: </strong>Rafael Franchin&nbsp;&nbsp;|&nbsp;&nbsp;Genildo Marcelo</div>

      <div class="ui divider"></div>

      <div><strong>Texto aprovado: </strong>Trabalhe como operador de telemarketing e atenda diferentes perfis de clientes. Esteja preparado para realizar vendas de produtos e serviços por telefone, SAC, help-desk, atendimento receptivo, entre outras funções. Invista em sua carreira!</div>

      <div class="ui hidden divider"></div>

      <div><i class="info circle yellow large icon"></i> O público-alvo são pessoas que procuram inserção ou reposicionamento no mercado profissional.</div>

      <div class="ui hidden divider"></div>

      <button class="ui labeled icon primary large button"><i class="download icon"></i>Imagem Redes Sociais</button>

      <div class="ui hidden divider"></div>

      <div><strong>E-mail marketing:</strong></div>
      <div>
        <a href="#" target="blank">http://www.sp.senac.br/msg/jbq/20160908_JBQ_nome_do_curso.html</a>
        <a href="#" target="blank">http://www.sp.senac.br/msg/acl/20160503_ACL_nome_do_curso.html</a>
        <a href="#" target="blank">http://www.sp.senac.br/msg/pen/20160401_PEN_nome_do_curso.html</a>
      </div>

      <div class="ui hidden divider"></div>

    </div>

  </div>

</div>

<span class="ui horizontal divider header cd-margem">
  <a href="index.php">
    <i class="left arrow icon"></i>
    Voltar
  </a>
</span>

<?php get_footer(); ?>
