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
      <a href="<?php bloginfo('url') ?>/solicitacao/?post_id=<?php the_ID(); ?>" class="ui right labeled icon button">
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

<!-- EMAIL MARKETING -->

<div id="email-marketing">

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title >Senac <?= $unidades[$unidade]['nome']; ?> - <?= $lblModalidade ?> - <?php the_title(); ?></title>
</head>

<body>
<div align="center">
  <table id="container" width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px solid <?= $borda ?>; border-collapse:collapse;">
    <tr>
      <td>
        <img id="link-imagem" alt="<?= $lblModalidade ?> - <?php the_title(); ?>" width="600" style="display:block; border:0;" />
      </td>
    </tr>
    <tr>
      <td>
        <table id="descricao" width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
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
            <td width="500" align="left" style="font-family: Arial, Helvetica, sans-serif; font-size: 18px; color: <?= $corpo_texto ?>;" id="corpo-texto">
              <?php if(get_field('texto-curso')) the_field('texto-curso'); ?>
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
            <td width="500" align="center" bgcolor="<?= $inscreva_se_fundo ?>">
                <a href="<?= $link_portal ?>&utm_source=Email_Marketing&utm_medium=email&utm_campaign=<?= $unidade; ?>_Livres" target="_blank" style="font-family: Arial, Helvetica, sans-serif; font-size:18px; line-height:18px; color:<?= $inscreva_se_texto ?>; font-weight:bold; display:block;"><br />Inscreva-se.<br /><br /></a>
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
        <table id="assinatura" width="600" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="<?= $assinatura_fundo ?>">
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td width="20" >&nbsp;</td>
            <td align="right" valign="bottom" style="font-size:16px"><font color="<?= $assinatura_texto ?>"  face="Arial, Verdana"> <strong>APRENDIZADO E CONHECIMENTO PARA SEMPRE.</strong><br />
              <br />
              Acesse <a href="<?= $unidades[$unidade]['url']; ?>&utm_source=Email_Marketing&utm_medium=email&utm_campaign=<?= $unidade; ?>_Livres" target="_blank" style="color:<?= $assinatura_texto ?>"><strong>www.sp.senac.br/<?= $unidades[$unidade]['nome_url']; ?></strong></a> e conhe&ccedil;a a programa&ccedil;&atilde;o completa da unidade.<br />
              <br />
            <img src="<?php if ($assinatura_texto == '#000001') { echo $tel_preto; } else { echo $tel_branco; }?>"  width="20" style="border:0;"  />&nbsp;<?= $unidades[$unidade]['telefone']; ?><br />
              &nbsp;<a href="<?= $unidades[$unidade]['google_maps']; ?>" target="_blank" style="color:<?= $assinatura_texto ?>"><img src="<?php if ($assinatura_texto == '#000001') { echo $pin_preto; } else { echo $pin_branco; } ?>" height="20" style="border:0;" />&nbsp;<?= $unidades[$unidade]['endereco']; ?></a></font></td>
            <td width="20" valign="middle">&nbsp;</td>
            <td width="121" valign="middle"><img title="Senac S&atilde;o Paulo" src="<?= $logo ?>" alt="Senac S&atilde;o Paulo"  border="0" width="121" height="135" /></td>
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
</body>

</html>

</div>

<!-- // EMAIL MARKETING -->

<script type="text/javascript">

var unidades = {
  'ACA': {
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

</script>

<div class="ui form">

<!-- UNIDADE -->
<div class="field">
  <label>Unidade</label>
  <?php
  $field_key = "field_58d1a32b9f77e";
  $field = get_field_object($field_key);

  if( $field ) {

    echo '<select name="unidade" id="select-unidade">';
    foreach( $field['choices'] as $k => $v ) {
        echo '<option value="' . $k . '">' . $v . '</option>';
    }
    echo '</select>';
  }
  ?>
</div>

<!-- CURSO -->

<div class="field">
  <label>Link do portal</label>
  <input type="text" id="input-link-portal">
</div>
<div class="field">
  <label>Link da imagem</label>
  <input type="text" value="http://www1.sp.senac.br/hotsites/msg/" id="input-link-imagem">
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

<script type="text/javascript">

$(function() {
  $('#input-link-imagem').keyup(function() {
    $('#link-imagem').attr('src', $(this).val());
  });
  $('#select-unidade').change(function() {
    $('title').prepend(unidades['ACL']['nome']);
  });
});


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
