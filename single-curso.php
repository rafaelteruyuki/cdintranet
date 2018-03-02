<?php get_header(); ?>

<!-- Single Curso -->

<?php

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

      <div class="ui disabled sub header"><?= $lblModalidade; ?></div>
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

      <!-- FORM EMAIL MARKETING -->

      <style media="screen">
      .ui.form select {
        height: 2.62em;
      }
      </style>

      <div id="form-email-marketing">

        <h3>Criar e-mail marketing</h3>

      	<form action="<?php bloginfo('url')?>/email-marketing" method="get" target="_blank" class="ui form">

        <!-- UNIDADE -->
        <div class="field">
          <label>Unidade</label>
        	<?php
        	$field_key = "field_58d1a32b9f77e";
        	$field = get_field_object($field_key);

        	if( $field ) {

        		echo '<select name="unidade">';

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

        <!-- CURSO -->
        <input type="hidden" name="modalidade" value="<?= $lblModalidade ?>">
        <input type="hidden" name="titulo" value="<?php the_title(); ?>">
        <input type="hidden" name="texto" value="<?php the_field('texto-curso'); ?>">
        <div class="field">
          <label>Link do portal</label>
          <input type="text" name="link-portal">
        </div>
        <div class="field">
          <label>Link da imagem</label>
          <input type="text" name="link-imagem" value="http://www1.sp.senac.br/hotsites/msg/">
        </div>

        <!-- CORPO -->
        <div class="fields">
          <div class="four wide field">
            <label>Corpo (Fundo) <i class="ui eyedropper icon"></i><a class="ui black empty circular label"></a><a class="ui grey empty circular label"></a></label>
            <input type="text" name="corpo-fundo" value="#000001" class="eyedropper-color">
          </div>
          <div class="four wide field">
            <label>Corpo (Texto) <i class="ui eyedropper icon"></i><a class="ui black empty circular label"></a><a class="ui grey empty circular label"></a></label>
            <input type="text" name="corpo-texto" value="#000001" class="eyedropper-color">
          </div>
          <div class="four wide field">
            <label>Borda <i class="ui eyedropper icon"></i><a class="ui black empty circular label"></a><a class="ui grey empty circular label"></a></label>
            <input type="text" name="borda" value="#000001" class="eyedropper-color">
          </div>
        </div>

        <!-- ASSINATURA -->
        <div class="fields">
          <div class="four wide field">
            <label>Assinatura (Fundo) <i class="ui eyedropper icon"></i><a class="ui black empty circular label"></a><a class="ui grey empty circular label"></a></label>
            <input type="text" name="assinatura-fundo" value="#000001" class="eyedropper-color">
          </div>
          <div class="four wide field">
            <label>Assinatura (Texto)</label>
            <select name="assinatura-texto">
              <option value="#000001">Preto</option>
              <!-- http://www1.sp.senac.br/hotsites/msg/gcr/tel_preto.png -->
              <!-- http://www1.sp.senac.br/hotsites/msg/gcr/pin_preto.png -->
              <option value="#FFFFFF">Branco</option>
              <!-- http://www1.sp.senac.br/hotsites/msg/gcr/tel_branco.png -->
              <!-- http://www1.sp.senac.br/hotsites/msg/gcr/pin_branco.png -->
            </select>
          </div>
          <div class="four wide field">
            <label>Logo</i></label>
            <select name="logo">
              <option value="http://www1.sp.senac.br/hotsites/msg/gcr/senac70_preto.png">Preto</option>
              <option value="http://www1.sp.senac.br/hotsites/msg/gcr/senac70_branco.png">Branco</option>
              <option value="http://www1.sp.senac.br/hotsites/msg/gcr/senac70_cor.png">Colorido</option>
            </select>
          </div>
        </div>

        <!-- INSCREVA-SE -->
        <div class="fields">
          <div class="four wide field">
            <label>Inscreva-se (Fundo) <i class="ui eyedropper icon"></i><a class="ui black empty circular label"></a><a class="ui grey empty circular label"></a></label>
            <input type="text" name="inscreva-se-fundo" value="#000001" class="eyedropper-color">
          </div>
          <div class="four wide field">
            <label>Inscreva-se (Texto) <i class="ui eyedropper icon"></i><a class="ui black empty circular label"></a><a class="ui grey empty circular label"></a></label>
            <input type="text" name="inscreva-se-texto" value="#000001" class="eyedropper-color">
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

<script type="text/javascript">

// $(function() {
//
//   $('img').mousemove(function(e) {
//
//       if(!this.canvas) {
//           this.canvas = $('<canvas />')[0];
//           this.canvas.width = this.width;
//           this.canvas.height = this.height;
//           this.canvas.getContext('2d').drawImage(this, 0, 0, this.width, this.height);
//       }
//
//       var pixelData = this.canvas.getContext('2d').getImageData(event.offsetX, event.offsetY, 1, 1).data;
//
//       function rgb2hex(rgb){
//        rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
//        return "#" +
//         ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
//         ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
//         ("0" + parseInt(rgb[3],10).toString(16)).slice(-2);
//       }
//
//       var hex = rgb2hex( 'rgba(' + pixelData[0] + ', ' + pixelData[1] + ', ' + pixelData[2] + ', ' + pixelData[3] + ')' );
//       $(':focus').val(hex);
//
//   });
//
// });

$(".ui.black.empty.circular.label").click(function(){
  $(this).parent().nextAll('input').val('#000001');
})

$(".ui.grey.empty.circular.label").click(function(){
  $(this).parent().nextAll('input').val('#FFFFFF');
})

$(".ui.eyedropper.icon").css('cursor', 'pointer');

$( ".ui.eyedropper.icon" ).click(function() {

  $('img').mousemove(function(e) {

      if(!this.canvas) {
          this.canvas = $('<canvas />')[0];
          this.canvas.width = this.width;
          this.canvas.height = this.height;
          this.canvas.getContext('2d').drawImage(this, 0, 0, this.width, this.height);
      }

      var pixelData = this.canvas.getContext('2d').getImageData(event.offsetX, event.offsetY, 1, 1).data;

      function rgb2hex(rgb){
       rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
       return "#" +
        ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[3],10).toString(16)).slice(-2);
      }

      var hex = rgb2hex( 'rgba(' + pixelData[0] + ', ' + pixelData[1] + ', ' + pixelData[2] + ', ' + pixelData[3] + ')' );
      $('.eyedropper-color:focus').val(hex);

  });

  $(this).parent().nextAll('input').focus();

});

// $(document).ready(function(){
//   $('.ui.eyedropper.icon').click(function(){
//     $('body').css('cursor', 'crosshair');
//   });
// });

</script>

<span class="ui horizontal divider header cd-margem">
  <a href="javascript:history.back()">
    <i class="left arrow icon"></i>
    Voltar
  </a>
</span>

<?php get_footer(); ?>
