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

<style media="screen">
  .cd-label-branco {
    border: 1px solid !important;
    border-color: #dadada !important;
    background-color: #ffffff !important;
  }
  .cd-label-preto {
    border: 1px solid !important;
    border-color: #000000 !important;
    background-color: #000000 !important;
  }
</style>

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
      <div style="margin-bottom:15px;"><h1 class="main-title"><?php the_title(); ?></h1></div>
      <div>
        <h3>
          <?php echo $lblArea; if($lblSubarea): ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $lblSubarea; endif; ?>
				</h3>
      </div>
      <br>
      <?php edit_post_link('Editar', '', '', '', 'ui button'); ?>

      <?php if (current_user_can('edit_pages') && ($value == 'curso-livre' || $value == 'extensao-universitaria')) : ?>
        <div id="criar-email" class="ui secondary button">Criar e-mail marketing</div>
      <?php endif; ?>

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
      <a href="<?php bloginfo('url') ?>/solicitacao/?post_id=<?php the_ID(); ?>" class="ui right labeled icon button">
        <i class="right arrow icon"></i>
        Solicitar adaptação da peça.
      </a>

      <div class="ui hidden divider"></div>

      <style media="screen">
      .ui.form select {
        height: 2.62em;
      }
      </style>

    </div>
  </div>
</div>

<?php

$save_imagem = get_post_meta( get_the_ID(), 'save_imagem', true );
$save_fundo = get_post_meta( get_the_ID(), 'save_fundo', true );
$save_botao = get_post_meta( get_the_ID(), 'save_botao', true );
$save_linha = get_post_meta( get_the_ID(), 'save_linha', true );
$save_texto = get_post_meta( get_the_ID(), 'save_texto', true );
$save_assinatura = get_post_meta( get_the_ID(), 'save_assinatura', true );

?>

<div class="ui basic segment cd-padding" style="background-color:#F6F6F6; display:none" id="section-email">

<div class="ui grid container">

  <div class="six wide column">

    <!-- FORM EMAIL MARKETING -->

    <div id="form-email-marketing">

      <h2>Criar e-mail marketing</h2>

      <div class="ui form">

      <!-- IMAGEM -->
      <div class="field">
        <label>Link da imagem</label>
        <input type="text" value="<?php if($save_imagem) : echo $save_imagem; else : echo 'http://www1.sp.senac.br/hotsites/msg/'; endif; ?>" id="input-imagem">
      </div>

      <!-- PORTAL -->
      <div class="field">
        <label>Link do portal</label>
        <input type="text" id="input-portal">
      </div>

      <!-- UNIDADE -->
      <div class="field">
        <label>Unidade</label>
        <?php
        $field_key = "field_58d1a32b9f77e";
        $field = get_field_object($field_key);

        if( $field ) {

          echo '<select id="select-unidade">';

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

      <div class="ui hidden divider"></div>

      <!-- CORPO -->
      <div class="fields">

        <!-- FUNDO -->
        <div class="six wide field emk-fundo">
          <label>Cor de fundo<br><i class="ui eyedropper icon eyedropper-tip" data-content="Coloque o mouse sobre uma imagem para capturar a cor" data-variation="very wide mini inverted"></i><a class="ui empty circular label cd-label-preto"></a><a class="ui empty circular label cd-label-branco"></a></label>
          <input id="input-fundo" type="text" value="<?php if ($save_fundo) : echo $save_fundo; else : echo '#F6F6F6'; endif; ?>" class="eyedropper-color">
        </div>

        <!-- BOTAO -->
        <div class="six wide field emk-cta">
          <label>Cor do botão<br><i class="ui eyedropper icon eyedropper-tip" data-content="Coloque o mouse sobre uma imagem para capturar a cor" data-variation="very wide mini inverted"></i><a class="ui empty circular label cd-label-preto"></a><a class="ui empty circular label cd-label-branco"></a></label>
          <input id="input-botao" type="text" value="<?php if ($save_botao) : echo $save_botao; else : echo '#000001'; endif; ?>" class="eyedropper-color">
        </div>

        <!-- LINHA -->
        <div class="six wide field emk-linha">
          <label>Cor da borda<br><i class="ui eyedropper icon eyedropper-tip" data-content="Coloque o mouse sobre uma imagem para capturar a cor" data-variation="very wide mini inverted"></i><a class="ui empty circular label cd-label-preto"></a><a class="ui empty circular label cd-label-branco"></a></label>
          <input id="input-linha" type="text" value="<?php if ($save_linha) : echo $save_linha; else : echo '#CCCCCC'; endif; ?>" class="eyedropper-color">
        </div>

      </div>

      <div class="fields">

        <!-- TEXTO -->
        <div class="eight wide field">
          <label>Texto</label>
          <select id="select-texto" data-texto="<?php echo $save_texto; ?>">
            <option value="preto">Preto</option>
            <option value="branco">Branco</option>
          </select>
        </div>

        <!-- ASSINATURA -->
        <div class="eight wide field">
          <label>Assinatura</label>
          <select id="select-assinatura" data-assinatura="<?php echo $save_assinatura; ?>">
            <option value="preto">Preto</option>
            <option value="branco">Branco</option>
            <option value="colorido">Colorida</option>
          </select>
        </div>

      </div>

      <!-- <div class="ui form">
        <div class="grouped fields">
          <label>Cor do texto</label>
          <div class="field">
            <div class="ui radio checkbox">
              <input type="radio" name="cor-do-texto" checked="checked" id="texto-preto">
              <label style="cursor:pointer" for="texto-preto">Preto</label>
            </div>
          </div>
          <div class="field">
            <div class="ui radio checkbox">
              <input type="radio" name="cor-do-texto" id="texto-branco">
              <label style="cursor:pointer" for="texto-branco">Branco</label>
            </div>
          </div>
        </div>
      </div> -->

      <!-- <h4 class="ui dividing header">Assinatura</h4> -->

      <div class="ui hidden divider"></div>

      <a class="ui labeled icon primary fluid button" id="salvar-email" data-id=<?php the_ID(); ?>><i class="download icon"></i>Baixar</a>

    </div>

    </div>

    <!-- // FORM EMAIL MARKETING -->

  </div>

  <div class="ten wide column">

    <!-- EMAIL MARKETING -->

    <div id="email-marketing">

    <div align="center">
      <table id="container" width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F6F6F6" style="border: 1px solid #CCCCCC">
        <tr>
          <td>
            <img id="imagem" alt="<?php echo $lblModalidade . ' - ' . get_the_title(); ?>" width="600" style="display:block; border:0;" src="<?php bloginfo('template_url') ?>/images/placeholder.png" crossorigin="anonymous"/>
          </td>
        </tr>
        <tr>
          <td>
            <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
              <tr>
                <td width="50">&nbsp;</td>
                <td width="500" align="left">&nbsp;</td>
                <td width="50">&nbsp;</td>
              </tr>
              <tr>
                <td width="50">&nbsp;</td>
                <td width="500" align="left">&nbsp;</td>
                <td width="50">&nbsp;</td>
              </tr>
              <tr>
                <td width="50">&nbsp;</td>
                <td width="500" align="left" style="font-family: Arial, Helvetica, sans-serif; font-size: 18px;" id="texto">
                  <?php if(get_field('texto-curso')) echo get_field('texto-curso'); ?>
                </td>
                <td width="50">&nbsp;</td>
              </tr>
              <tr>
                <td width="50">&nbsp;</td>
                <td width="500" align="left">&nbsp;</td>
                <td width="50">&nbsp;</td>
              </tr>
              <tr>
                <td width="50">&nbsp;</td>
                <td width="500" align="center" id="cta-bg" bgcolor="#000001">
                    <a id="portal" target="_blank" style="font-family: Arial, Helvetica, sans-serif; font-size:18px; line-height:18px; font-weight:bold; display:block; text-decoration:none;"><br /><span>Inscreva-se.</span><br /><br /></a>
                </td>
                <td width="50">&nbsp;</td>
              </tr>
              <tr>
                <td width="50">&nbsp;</td>
                <td width="500">&nbsp;</td>
                <td width="50">&nbsp;</td>
              </tr>
              <tr>
                <td width="50">&nbsp;</td>
                <td width="500"><img title="Senac S&atilde;o Paulo" src="http://www1.sp.senac.br/hotsites/msg/gcr/2017_Desconto_30_500px_01.gif" alt="Descontos 30% - Em todos os cursos presenciais - livres, t&eacute;cnicos e idiomas. - Veja o percentual que seu curso oferece."  border="0" /></td>
                <td width="50">&nbsp;</td>
              </tr>
              <tr>
                <td width="50">&nbsp;</td>
                <td width="500">&nbsp;</td>
                <td width="50">&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <table id="assinatura" width="600" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td valign="middle">&nbsp;</td>
                <td valign="middle">&nbsp;</td>
                <td valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td width="20" >&nbsp;</td>
                <td align="right" valign="bottom" style="font-family: Arial, Helvetica, sans-serif; font-size:16px;">
                  <strong>APRENDIZADO E CONHECIMENTO PARA SEMPRE.</strong><br /><br />
                  Acesse <a id="link-unidade" target="_blank"><strong></strong></a> e conhe&ccedil;a a programa&ccedil;&atilde;o completa da unidade.<br /><br />
                  <img id="tel-icon" width="20" style="border:0;" />
                  <span id="tel-text" style="margin-left: 5px;"></span><br />
                  <img id="pin-icon" height="20" style="border:0;" />
                  <a id="pin-text" target="_blank" style="text-decoration: underline; margin-left: 5px;"></a>
                </td>
                <td width="20" valign="middle">&nbsp;</td>
                <td width="121" valign="middle">
                  <img id="logo-senac" title="Senac S&atilde;o Paulo" alt="Senac S&atilde;o Paulo"  border="0" width="121" height="135" />
                </td>
                <td width="20" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td valign="middle">&nbsp;</td>
                <td valign="middle">&nbsp;</td>
                <td valign="middle">&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <table id="redes-sociais" width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="right" valign="middle" style="font-family: Verdana, Geneva, sans-serif; font-size:12px; color: #666666;">&nbsp;</td>
          <td align="right" valign="middle">&nbsp;</td>
        </tr>
        <tr>
          <td width="510" align="right" valign="middle" style="font-family: Verdana, Geneva, sans-serif; font-size:12px; color: #666666;">Senac nas redes:&nbsp;</td>
          <td width="90" align="right" valign="middle">
            <a href="http://www.twitter.com/senacsaopaulo" target="_blank"> <img src="http://www1.sp.senac.br/hotsites/gcr/cd/twitter_1.gif" alt="Twitter do Senac S&atilde;o Paulo" title="Twitter do Senac S&atilde;o Paulo" width="22" height="22" border="0" /></a>&nbsp; <a href="http://www.facebook.com/pages/Senac-Sao-Paulo/341729352806" target="_blank"> <img src="http://www1.sp.senac.br/hotsites/gcr/cd/facebook_1.gif" alt="Facebook do Senac S&atilde;o Paulo" title="Facebook do Senac S&atilde;o Paulo" width="22" height="22" border="0" /></a>&nbsp; <a href="http://www.youtube.com/senacsaopaulo" target="_blank"> <img src="http://www1.sp.senac.br/hotsites/gcr/cd/youtube_1.gif" alt="YouTube do Senac S&atilde;o Paulo" title="YouTube do Senac S&atilde;o Paulo" width="22" height="22" border="0" /></a>&nbsp;
          </td>
        </tr>
      </table>
      <table id="footer" width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td style="font-family: Verdana, Geneva, sans-serif; font-size:12px; color: #666666;">
            Este e-mail est&aacute; sendo enviado porque voc&ecirc; teve algum contato conosco.  <br />
            <br />
            <strong>Atendimento corporativo</strong>, solu&ccedil;&otilde;es para empresas: 0800 707 1027 ou <a href="http://www.sp.senac.br/jsp/default.jsp?newsID=a20605.htm&amp;testeira=696&amp;sub=0&amp;utm_source=Portal&amp;utm_medium=email&amp;utm_campaign=CRM" target="_blank" style="color:#666666">www.sp.senac.br/corporativo</a>. <br />
            <br />
            <strong>Educa&ccedil;&atilde;o a Dist&acirc;ncia Senac:</strong> conhe&ccedil;a a programa&ccedil;&atilde;o no site <a href="http://www.ead.senac.br?utm_source=Portal&amp;utm_medium=email&amp;utm_campaign=CRM" target="_blank" style="color:#666666">www.ead.senac.br</a>. <br />
            <br />
            A pol&iacute;tica de descontos pode ser alterada a qualquer momento, sem aviso pr&eacute;vio. Para mais informa&ccedil;&otilde;es sobre nossa pol&iacute;tica de descontos, entre em contato com uma unidade.  <br />
            <br />
            <strong>Obs.:</strong> O Senac reserva-se o direito de alterar as datas ou cancelar o curso, caso o n&uacute;mero de participantes n&atilde;o atinja o m&iacute;nimo previsto.
            <br />
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      </div>

      <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-513261-14']);
        _gaq.push(['_trackPageview']);

        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

      </script>

    </div>

    <!-- // EMAIL MARKETING -->

  </div>

</div>

</div>

<div class="ui hidden divider"></div>

<script src="<?php bloginfo('template_url') ?>/js/he.js"></script>

<script type="text/javascript">

var unidades = {
  'ACA': {
    'sigla'       : 'ACA',
    'nome'        : 'Araçatuba',
    'nome_url'    : 'aracatuba',
    'endereco'    : 'Av. João Arruda Brasil, 500',
    'bairro'      : 'São Joaquim',
    'CEP'         : '16050-400',
    'telefone'    : '(18) 3117-1000',
    'url'         : 'http://www.sp.senac.br/jsp/default.jsp?newsID=a529.htm&testeira=352&unit=A%C7A&sub=1',
    'google_maps' : 'https://www.google.com.br/maps/place/Senac+Ara%C3%A7atuba/@-21.2011865,-50.4459439,17z/data=!3m1!4b1!4m2!3m1!1s0x949643f3d8a31887:0xec4d448031b7e3fd?shorturl=1',
  },
  'ACL': {
    'sigla'       : 'ACL',
    'nome'        : 'Aclimação',
    'nome_url'    : 'aclimacao',
    'endereco'    : 'Rua Pires da Mota, 838',
    'bairro'      : 'Aclimação',
    'CEP'         : '01529-000',
    'telefone'    : '(11) 3795-1299',
    'url'         : 'http://www.sp.senac.br/jsp/default.jsp?newsID=a18070.htm&testeira=1737&unit=ACL&sub=1',
    'google_maps' : 'https://www.google.com.br/maps/place/Senac+Aclima%C3%A7%C3%A3o/@-23.5686172,-46.6383325,17z/data=!3m1!4b1!4m5!3m4!1s0x94ce599f467de6b9:0x221608c031490e7d!8m2!3d-23.5686172!4d-46.6361438',
  },
}

$(function() {

  // Imagem
  $('#input-imagem').keyup(function() {
    $('#imagem').attr('src', $(this).val());
  });

  // Fundo
  $('#input-fundo').keyup(function() {
    $('#container').attr('bgcolor', $(this).val());
  }).val(function () {
      return this.value.toUpperCase();
  });

  // Botão
  $('#input-botao').keyup(function() {
    $('#cta-bg').attr('bgcolor', $(this).val());
  }).val(function () {
      return this.value.toUpperCase();
  });

  // Borda
  $('#input-linha').keyup(function() {
    $('#container').attr('style', 'border: 1px solid ' + $(this).val() + '; border-collapse: collapse;');
  }).val(function () {
      return this.value.toUpperCase();
  });

  var pin_text = $('#pin-text').attr('style');

  // Unidade
  $('#select-unidade').change(function() {

    var unidade = $(this).val();
    var sigla = unidades[unidade]['sigla'];
    var nome = unidades[unidade]['nome'];
    var nome_url = unidades[unidade]['nome_url'];
    var endereco = unidades[unidade]['endereco'];
    var telefone = unidades[unidade]['telefone'];
    var url = unidades[unidade]['url'];
    var google_maps = unidades[unidade]['google_maps'];

    var parametro1 = '&utm_source=Email_Marketing&utm_medium=email&utm_campaign=' + sigla;
    var parametro2 = '<?= $lblModalidade ?>';

    if (parametro2 == 'Curso Livre') {
      parametro2 = '_Livres';
    } else if (parametro2 == 'Extensão Universitária') {
      parametro2 = '_Extensao';
    }

    var tagueamento = parametro1 + parametro2;

    var portal = $('#input-portal').val();
    $('#portal').attr('href', portal + tagueamento);

    $('#link-unidade strong').html('www.sp.senac.br/' + nome_url);
    $('#link-unidade').attr('href', url + tagueamento);
    $('#pin-text').html(endereco).attr('href', google_maps);
    $('#tel-text').html('&nbsp;' + telefone);

    // Portal
    $('#input-portal').keyup(function() {
      var portal = $(this).val();
      $('#portal').attr('href', portal + tagueamento);
    });

    // Texto e CTA
    var texto = $('#texto').attr('style');
    var portal = $('#portal').attr('style');
    $('#select-texto').change(function() {
      if ( $(this).val() == 'preto' ) {
        $('#portal span').attr('style', 'color: ' + $('#input-fundo').val()); // cta-texto
        $('#texto').attr('style', texto + ' color: #000001;');
      } else if ( $(this).val() == 'branco' ) {
        $('#portal span').attr('style', 'color: ' + $('#input-fundo').val()); // cta-texto
        $('#texto').attr('style', texto + ' color: #FFFFFF;');
      }
    });

    // Assinatura
    $('#select-assinatura').change(function() {

      var url_img = 'http://www1.sp.senac.br/hotsites/msg/gcr/';

      if ( $(this).val() == 'preto' ) {
        $('#link-unidade').attr('style', 'color: #000001');
        $('#assinatura').attr('bgcolor', '');
        $('#assinatura').attr('style', 'color: #000001');
        $('#tel-icon').attr('src', url_img + 'tel_preto.png');
        $('#pin-icon').attr('src', url_img + 'pin_preto.png');
        $('#pin-text').attr('style', pin_text +  ' color: #000001');
        $('#logo-senac').attr('src', url_img + 'senac70_preto.png');

      } else if ( $(this).val() == 'branco' ) {
        $('#link-unidade').attr('style', 'color: #FFFFFF');
        $('#assinatura').attr('bgcolor', '');
        $('#assinatura').attr('style', 'color: #FFFFFF');
        $('#tel-icon').attr('src', url_img + 'tel_branco.png');
        $('#pin-icon').attr('src', url_img + 'pin_branco.png');
        $('#pin-text').attr('style', pin_text +  ' color: #FFFFFF');
        $('#logo-senac').attr('src', url_img + 'senac70_branco.png');

      } else if ( $(this).val() == 'colorido' ) {
        $('#link-unidade').attr('style', 'color: #000001');
        $('#assinatura').attr('bgcolor', '#F6F6F6');
        $('#assinatura').attr('style', 'color: #000001');
        $('#tel-icon').attr('src', url_img + 'tel_preto.png');
        $('#pin-icon').attr('src', url_img + 'pin_preto.png');
        $('#pin-text').attr('style', pin_text +  ' color: #000001');
        $('#logo-senac').attr('src', url_img + 'senac70_cor.png');

      }
    });

  });

  $('#select-unidade').trigger('change');
  if ($('#input-imagem').val() != 'http://www1.sp.senac.br/hotsites/msg/') $('#input-imagem').trigger('keyup');
  $('#input-fundo').trigger('keyup');
  $('#input-botao').trigger('keyup');
  $('#input-linha').trigger('keyup');

  var data_texto = $('#select-texto').data('texto');
  if (data_texto == 'preto') {
    $('#select-texto').val('preto');
  }
  else if (data_texto == 'branco') {
    $('#select-texto').val('branco');
  }
  $('#select-texto').trigger('change');

  var data_assinatura = $('#select-assinatura').data('assinatura');
  if (data_assinatura == 'preto') {
    $('#select-assinatura').val('preto');
  }
  else if (data_assinatura == 'branco') {
    $('#select-assinatura').val('branco');
  }
  else if (data_assinatura == 'colorido') {
    $('#select-assinatura').val('colorido');
  }
  $('#select-assinatura').trigger('change');


});

$(".cd-label-preto").click(function(){
  $(this).parent().nextAll('input').val('#000001').trigger('keyup');
  var color = $('#input-fundo').val();
  $('#portal span').attr('style', 'color: ' + color);
  // Cancela o eyedropper
  $('.imagem-single-curso, #imagem').css('cursor', 'default').off('mousemove');
})

$(".cd-label-branco").click(function(){
  $(this).parent().nextAll('input').val('#FFFFFF').trigger('keyup');
  var color = $('#input-fundo').val();
  $('#portal span').attr('style', 'color: ' + color);
  // Cancela o eyedropper
  $('.imagem-single-curso, #imagem').css('cursor', 'default').off('mousemove');
})

// Eyedropper

function eyedropper() {

  $('.imagem-single-curso, #imagem').mousemove(function(e) {

      // if(!this.canvas) {
          this.canvas = $('<canvas />')[0];
          this.canvas.width = this.width;
          this.canvas.height = this.height;
          this.canvas.getContext('2d').drawImage(this, 0, 0, this.width, this.height);
      // }

      var pixelData = this.canvas.getContext('2d').getImageData(event.offsetX, event.offsetY, 1, 1).data;

      function rgb2hex(rgb){
       rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
       return "#" +
        ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[3],10).toString(16)).slice(-2);
      }

      var hex = rgb2hex( 'rgba(' + pixelData[0] + ', ' + pixelData[1] + ', ' + pixelData[2] + ', ' + pixelData[3] + ')' );

      $('.eyedropper-color:focus').val(hex).val(function () {
          return this.value.toUpperCase();
      });


      $('#container').attr('bgcolor', $('#input-fundo').val());
      // $('#container').attr('style', 'border: 1px solid ' + $('#input-fundo').val() + '; border-collapse: collapse;');
      $('#portal span').attr('style', 'color: ' + $('#input-fundo').val());
      $('#cta-bg').attr('bgcolor', $('#input-botao').val());
      $('#container').attr('style', 'border: 1px solid ' + $('#input-linha').val() + '; border-collapse: collapse;');

  });

}

$( ".ui.eyedropper.icon" ).css('cursor', 'pointer').click(function() {

  eyedropper();

  $('.imagem-single-curso, #imagem').css('cursor', 'crosshair');

  $(this).parent().nextAll('input').focus();

  $('.imagem-single-curso, #imagem').click(function(){
    $(this).css('cursor', 'default').off('mousemove');
  });
  $(document).keyup(function(e) {
      if (e.keyCode == 27) { // escape key maps to keycode `27`
        $('.imagem-single-curso, #imagem').css('cursor', 'default').off('mousemove');
      }
  });

});

// $(document).ready(function(){
//   $('.ui.eyedropper.icon').click(function(){
//     $('body').css('cursor', 'crosshair');
//   });
// });


$('#salvar-email').click(function(e) {

  if( !$('#input-portal').val() ) {
    alert('Preencha o campo "Link do portal"');
    return false;
  }

  $('#imagem').removeAttr('crossorigin', 'anonymous'); // Remove o atributo para salvar. Este atributo serve para permitir capturar os pixel de imagem de URL externo.

  // Email marketing
  var doc_type = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' + '\n';
  var open_html = '<html xmlns="http://www.w3.org/1999/xhtml">' + '\n';
  var head = '<head>' + '\n' + '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />' + '\n' + '<title>' + '<?php convert_string_to_html( $lblModalidade . ' - ' . get_the_title() ); ?>' + '</title>' + '\n' + '</head>' + '\n';
  var open_body = '<body>'
  var email = $('#email-marketing')[0].innerHTML;
  var close_body = '</body>' + '\n';
  var close_html = '</html>';

  var email_final = doc_type + open_html + head + open_body + email + close_body + close_html;
  var email_encoded = he.encode(email_final, {
    'useNamedReferences': true,
    'allowUnsafeSymbols': true
  });

  var found = $(email_encoded).find("#pin-text").attr('href');
  console.log(found);

  var unidade = $('#select-unidade').val();
  var google_maps = unidades[unidade]['google_maps'];
  console.log(google_maps);

  var pin_text = $(email_encoded).find("#pin-text");
  pin_text.attr('href', 'http://teste.com');
  console.log(pin_text.attr('href'));

  // Data
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth()+1; //January is 0!

  var yyyy = today.getFullYear();
  if(dd<10){
      dd='0'+dd;
  }
  if(mm<10){
      mm='0'+mm;
  }

  // Substituir caracteres acentuados
  function removeDiacritics(input)
  {
      var output = "";

      var normalized = input.normalize("NFD");
      var i=0;
      var j=0;

      while (i<input.length)
      {
          output += normalized[j];

          j += (input[i] == normalized[j]) ? 1 : 2;
          i++;
      }

      return output;
  }

  var data_hoje = yyyy + mm + dd;
  var sigla = $('#select-unidade').val();
  var titulo = removeDiacritics($('.main-title').html()).replace(/[_\W]+/g, "_").toLowerCase();

  var filename = data_hoje + '_' + sigla + '_' + titulo + '.html';

  e.originalEvent.currentTarget.href = 'data:text/html,' + email_encoded;
  e.originalEvent.currentTarget.download = filename;

  var post_id = $(this).data('id');
  var save_imagem = $('#input-imagem').val();
  var save_fundo = $('#input-fundo').val();
  var save_botao = $('#input-botao').val();
  var save_linha = $('#input-linha').val();
  var save_texto = $('#select-texto').val();
  var save_assinatura = $('#select-assinatura').val();

  $.ajax({
    method: 'POST',
    url: ajaxurl,
    data: {
      action: 'salvar_email',
      post_id : post_id,
      save_imagem : save_imagem,
      save_fundo : save_fundo,
      save_botao : save_botao,
      save_linha : save_linha,
      save_texto : save_texto,
      save_assinatura : save_assinatura
    },
    beforeSend: function() {
      // $('.participar').html('Saindo...');
    },
    success: function() {
      // $('.participar').html('Você saiu').removeClass('blue').addClass('grey').unbind("click");
    }
  });

});

$('#criar-email').click(function(){
  $(this).hide();
  $('#section-email').show();
  $('html, body').animate({
      scrollTop: $("#section-email").offset().top
  }, 500);
});

$('.ui.checkbox').checkbox();

</script>

<?php get_footer(); ?>
