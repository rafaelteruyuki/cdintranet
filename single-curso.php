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


      <div class="ui hidden divider"></div>
      <div id="email-marketing">

        <h3>Criar e-mail marketing</h3>

      	<form action="<?php bloginfo('url')?>/email-marketing" method="get" target="_blank" class="ui form">

        <div class="field">
          <label>Unidade</label>
        	<?php
        	$field_key = "field_58d1a32b9f77e";
        	$field = get_field_object($field_key);

        	if( $field ) {

        		echo '<select name="unidade">';
        		echo '<option>Unidade</option>';

        		foreach( $field['choices'] as $k => $v ) {
        			if (isset($_GET['unidade']) && $v == $_GET['unidade']) {
        				echo '<option value="' . $k . '" selected>' . $v . '</option>';
        			} else {
        				echo '<option value="' . $k . '">' . $v . '</option>';
        			}
        		}

        		echo '</select>';
        	}

        	?>
        </div>

        <input type="hidden" name="modalidade" value="<?= $lblModalidade ?>">
        <input type="hidden" name="titulo" value="<?php the_title(); ?>">
        <input type="hidden" name="texto" value="<?php the_field('texto-curso'); ?>">

        <div class="field">
          <label>Link do portal</label>
          <input type="text" name="link-portal">
        </div>

        <div class="field">
          <label>Link da imagem</label>
          <input type="text" name="link-imagem">
        </div>

        <div class="fields">
          <div class="four wide field">
            <label>Corpo (Fundo)</label>
            <input type="text" name="corpo-fundo" value="#000001">
          </div>
          <div class="four wide field">
            <label>Corpo (Texto)</label>
            <input type="text" name="corpo-texto" value="#000001">
          </div>
          <div class="four wide field">
            <label>Borda</label>
            <input type="text" name="borda" value="#000001">
          </div>
        </div>

        <div class="fields">
          <div class="four wide field">
            <label>Assinatura (Fundo)</label>
            <input type="text" name="assinatura-fundo" value="#000001">
          </div>
          <div class="four wide field">
            <label>Assinatura (Texto)</label>
            <select name="assinatura-texto">
              <option value="preto">Preto</option>
              <option value="branco">Branco</option>
            </select>
          </div>
          <div class="four wide field">
            <label>Logo</label>
            <select name="logo">
              <option value="preto">Preto</option>
              <option value="branco">Branco</option>
              <option value="colorido">Colorido</option>
            </select>
          </div>
        </div>

        <div class="fields">
          <div class="four wide field">
            <label>Inscreva-se (Fundo)</label>
            <input type="text" name="inscreva-se-fundo" value="#000001">
          </div>
          <div class="four wide field">
            <label>Inscreva-se (Texto)</label>
            <input type="text" name="inscreva-se-texto" value="#000001">
          </div>
        </div>

        <!-- <h4 class="ui dividing header">Assinatura</h4> -->

        <div class="ui hidden divider"></div>
        <input type="submit" name="" value="Criar e-mail" class="ui secondary button">

      	</form>

      </div>




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
