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
      <div id="criar-email" class="ui secondary button">Criar e-mail marketing</div>

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

<div class="ui grid container" id="section-email" style="display:none;">

  <div class="six wide column">

    <!-- FORM EMAIL MARKETING -->

    <div id="form-email-marketing">

      <h3>Criar e-mail marketing</h3>

      <div class="ui form">

      <!-- CURSO -->
      <input type="hidden" name="modalidade" value="<?= $lblModalidade ?>">
      <input type="hidden" name="titulo" value="<?php the_title(); ?>">
      <input type="hidden" name="texto" value="<?php the_field('texto-curso'); ?>">

      <!-- IMAGEM -->
      <div class="field">
        <label>Link da imagem</label>
        <input type="text" value="<?php if (get_post_meta('save_imagem')) echo 'Oi'; ?> http://www1.sp.senac.br/hotsites/msg/" id="input-imagem">
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

      <!-- CORPO -->
      <div class="fields">

        <div class="four wide field">
          <label>Cor de fundo <i class="ui eyedropper icon"></i><a class="ui black empty circular label"></a><a class="ui grey empty circular label"></a></label>
          <input id="input-fundo" type="text" value="#FFFFFF" class="eyedropper-color">
        </div>

        <div class="four wide field">
          <label>Cor do texto</label>
          <select id="select-texto">
            <option value="preto">Preto</option>
            <option value="branco">Branco</option>
          </select>
        </div>

        <div class="four wide field">
          <label>Assinatura</label>
          <select id="select-assinatura">
            <option value="preto">Preto</option>
            <option value="branco">Branco</option>
            <option value="colorido">Colorida</option>
          </select>
        </div>

      </div>

      <!-- <h4 class="ui dividing header">Assinatura</h4> -->

      <div class="ui hidden divider"></div>

      <div class="ui secondary button" id="salvar-email" data-id=<?php the_ID(); ?>>Salvar</div>
      <a class="ui secondary button" id="baixar-email" style="display:none;">Baixar e-mail</a>

    </div>

    </div>

    <!-- // FORM EMAIL MARKETING -->

  </div>

  <div class="ten wide column">

    <!-- EMAIL MARKETING -->

    <div id="email-marketing">

    <div align="center">
      <table id="container" width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <img id="imagem" alt="<?php echo $lblModalidade . ' - ' . get_the_title(); ?>" width="600" style="display:block; border:0;" src="http://placehold.it/640x480" />
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
                <td width="500" align="center" id="cta-bg">
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
                  <img id="tel-icon" width="20" style="border:0;" /><span id="tel-text" style="margin-left: 5px;"></span><br />
                  <a id="pin-icon" target="_blank">
                    <img height="20" style="border:0;" />
                    <span id="pin-text" style="text-decoration: underline; margin-left: 5px;"></span>
                  </a>
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

    </div>

    <!-- // EMAIL MARKETING -->

  </div>

</div>

<span class="ui horizontal divider header cd-margem">
  <a href="javascript:history.back()">
    <i class="left arrow icon"></i>
    Voltar
  </a>
</span>

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
    'google_maps' : 'https://www.google.com.br/maps/place/Senac+Ara%C3%A7atuba/@-21.201429,-50.4467907,17z/data=!3m1!4b1!4m5!3m4!1s0x949643f3d8a31887:0xec4d448031b7e3fd!8m2!3d-21.201429!4d-50.444602',
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
    } else if (parametro2 == 'Extensão') {
      parametro2 = '_Extensao';
    }

    var tagueamento = parametro1 + parametro2;

    var portal = $('#input-portal').val();
    $('#portal').attr('href', portal + tagueamento);

    $('#link-unidade strong').html('www.sp.senac.br/' + nome_url);
    $('#link-unidade').attr('href', url + tagueamento);
    $('#pin-text').html(endereco);
    $('#pin-icon').attr('href', google_maps);
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
        $('#cta-bg').attr('bgcolor', '#000001');
        $('#portal span').attr('style', 'color: ' + $('#input-fundo').val()); // cta-texto
        $('#texto').attr('style', texto + ' color: #000001;');
      } else if ( $(this).val() == 'branco' ) {
        $('#cta-bg').attr('bgcolor', '#FFFFFF');
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
        $('#pin-icon img').attr('src', url_img + 'pin_preto.png');
        $('#pin-icon').attr('style', 'color: #000001');
        $('#logo-senac').attr('src', url_img + 'senac70_preto.png');

      } else if ( $(this).val() == 'branco' ) {
        $('#link-unidade').attr('style', 'color: #FFFFFF');
        $('#assinatura').attr('bgcolor', '');
        $('#assinatura').attr('style', 'color: #FFFFFF');
        $('#tel-icon').attr('src', url_img + 'tel_branco.png');
        $('#pin-icon img').attr('src', url_img + 'pin_branco.png');
        $('#pin-icon').attr('style', 'color: #FFFFFF');
        $('#logo-senac').attr('src', url_img + 'senac70_branco.png');

      } else if ( $(this).val() == 'colorido' ) {
        $('#link-unidade').attr('style', 'color: #000001');
        $('#assinatura').attr('bgcolor', '#EFEFEF');
        $('#assinatura').attr('style', 'color: #000001');
        $('#tel-icon').attr('src', url_img + 'tel_preto.png');
        $('#pin-icon img').attr('src', url_img + 'pin_preto.png');
        $('#pin-icon').attr('style', 'color: #000001');
        $('#logo-senac').attr('src', url_img + 'senac70_cor.png');

      }
    });

  });

  $('#select-unidade').trigger('change');
  $('#select-texto').trigger('change');
  $('#select-assinatura').trigger('change');
  $('#select-assinatura').trigger('keyup');

});


$(".ui.black.empty.circular.label").click(function(){
  $(this).parent().nextAll('input').val('#000001');
})

$(".ui.grey.empty.circular.label").click(function(){
  $(this).parent().nextAll('input').val('#FFFFFF');
})

$(".ui.eyedropper.icon").css('cursor', 'pointer');

$( ".ui.eyedropper.icon" ).click(function() {

  var cta_style = $('#portal').attr('style');

  $('.imagem-single-curso, #imagem').mousemove(function(e) {

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

      $('#container').attr('bgcolor', $('#input-fundo').val());
      $('#container').attr('style', 'border: 1px solid ' + $('#input-fundo').val() + '; border-collapse: collapse;');
      $('#portal span').attr('style', 'color: ' + $('#input-fundo').val());

  });

  $(this).parent().nextAll('input').focus();

});

// $(document).ready(function(){
//   $('.ui.eyedropper.icon').click(function(){
//     $('body').css('cursor', 'crosshair');
//   });
// });

$('#salvar-email').click(function(){

  var doc_type = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' + '\n';
  var open_html = '<html xmlns="http://www.w3.org/1999/xhtml">' + '\n';
  var head = '<head>' + '\n' + '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />' + '\n' + '<title>' + '<?php convert_string_to_html( $lblModalidade . ' - ' . get_the_title() ); ?>' + '</title>' + '\n' + '</head>' + '\n';
  var open_body = '<body>'
  var email = $('#email-marketing').html();
  var close_body = '</body>' + '\n';
  var close_html = '</html>';

  var email_final = doc_type + open_html + head + open_body + email + close_body + close_html;
  var email_encoded = he.encode(email_final, {
    'useNamedReferences': true,
    'allowUnsafeSymbols': true
  });

  var filename = '99999999_XXX_nome_do_curso';

  $('#baixar-email').show().attr('download', filename + '.html').attr('href', 'data:text/html,' + email_encoded);

  var post_id = $(this).data('id');
  var save_imagem = $('#input-imagem').val();
  var save_portal = $('#input-portal').val();
  var save_fundo = $('#input-fundo').val();
  var save_texto = $('#select-texto').val();
  var save_assinatura = $('#select-assinatura').val();

  $.ajax({
    method: 'POST',
    url: ajaxurl,
    data: {
      action: 'salvar_email',
      post_id : post_id,
      save_imagem : save_imagem,
      save_portal : save_portal,
      save_fundo : save_fundo,
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
      scrollTop: $("#email-marketing").offset().top
  }, 2000);
});

</script>



<?php get_footer(); ?>
