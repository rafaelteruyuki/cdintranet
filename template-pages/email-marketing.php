<?php

/*
Template Name: E-mail Marketing
*/

get_header();

global $current_user;

?>

<?php

$unidade = array(
    "sigla" => "BAR",
    "nome" => "Barretos",
);

?>

<h2 class="ui horizontal divider header cd-margem">E-mail criado com sucesso</h2>

<div class="ui center aligned container cd-margem">

<a id="emkt-download" class="ui large primary button">Download</a>

<div class="ui hidden divider"></div>

<!-- PAGE TEMPLATE DO EMAIL -->

<div id="email-marketing">

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Senac <?= $_GET["unidade"] ?> - <?php $modalidade ?> - <?php the_title(); ?></title>
</head>

<body>
<div align="center">
	<table id="container" width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px solid #009CC4; border-collapse:collapse;">
		<tr>
			<td>
				<img src="<?php $link_imagem ?>" alt="<? $modalidade ?> - <?php the_title(); ?>" width="600" style="display:block; border:0;" />
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
						<td width="500" align="left" style="font-family: Arial, Helvetica, sans-serif; font-size: 18px; color: #000001;">Texto descritivo.<br />
					  <br />
					  - T&iacute;tulo pe&ccedil;a: <?= $_GET["titulo"] ?><br />
					  - Alt imagem<br />
					  - Link portal + XXX_Livres<br />
					  - Assinatura</td>
						<td width="50">&nbsp;</td>
					</tr>
					<tr>
						<td width="50">&nbsp;</td>
						<td width="500" align="left">&nbsp;</td>
						<td width="50">&nbsp;</td>
					</tr>
					<tr>
						<td width="50">&nbsp;</td>
						<td width="500" align="center" bgcolor="#009CC4">
								<a href="&utm_source=Email_Marketing&utm_medium=email&utm_campaign=XXX_Livres" target="_blank" style="font-family: Arial, Helvetica, sans-serif; font-size:18px; line-height:18px;color:#FFFFFF; font-weight:bold; display:block;"><br />Inscreva-se.<br /><br /></a>
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
        <table id="assinatura" width="600" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#EFEFEF">
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td width="20" >&nbsp;</td>
            <td align="right" valign="bottom" style="font-size:16px"><font color="#000001"  face="Arial, Verdana"> <strong>APRENDIZADO E CONHECIMENTO PARA SEMPRE.</strong><br />
              <br />
              Acesse <a href="http://www.sp.senac.br/jsp/default.jsp?newsID=a529.htm&testeira=352&unit=A%C7A&sub=1&utm_source=Portal&utm_medium=email&utm_campaign=CRM" target="_blank" style="color:#000001"><strong>www.sp.senac.br/aracatuba</strong></a> e conhe&ccedil;a a programa&ccedil;&atilde;o completa da unidade.<br />
              <br />
            <img src="http://www1.sp.senac.br/hotsites/msg/gcr/tel_preto.png"  width="20" style="border:0;"  />&nbsp;(18) 3117-1000<br />
              &nbsp;<a href="https://www.google.com.br/maps/place/Senac+Ara%C3%A7atuba/@-21.2011865,-50.4459439,17z/data=!3m1!4b1!4m2!3m1!1s0x949643f3d8a31887:0xec4d448031b7e3fd?shorturl=1" target="_blank" style="color:#000001"><img src="http://www1.sp.senac.br/hotsites/msg/gcr/pin_preto.png"  height="20" style="border:0;"  />&nbsp;Av. Jo&atilde;o Arruda Brasil, 500</a></font></td>
            <td width="20" valign="middle">&nbsp;</td>
            <td width="121" valign="middle"><img title="Senac S&atilde;o Paulo" src="http://www1.sp.senac.br/hotsites/msg/gcr/senac70_cor.png" alt="Senac S&atilde;o Paulo"  border="0" width="121" height="135" /></td>
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

<script type="text/javascript">

function downloadInnerHtml(filename, elId, mimeType) {
    var elHtml = document.getElementById(elId).innerHTML;
    var link = document.createElement('a');
    mimeType = mimeType || 'text/plain';

    link.setAttribute('download', filename);
    link.setAttribute('href', 'data:' + mimeType  +  ';charset=utf-8,' + encodeURIComponent(elHtml));
    link.click();
}

var fileName =  'tags.html'; // You can use the .txt extension if you want

$('#emkt-download').click(function(){
  downloadInnerHtml(fileName, 'email-marketing','text/html');
});
</script>

<?php if ( is_user_logged_in() ) : ?>

  <a href="<?php the_permalink(); ?>?notificacao_email=sim" class="ui large button">Sim</a>
  <a href="<?php the_permalink(); ?>?notificacao_email=nao" class="ui large button">Não</a>
  <div class="ui hidden divider"></div>
  <div class="ui hidden divider"></div>

  <?php if (!$_GET["notificacao_email"]) {

    $notificacao = get_field('receber_notificacoes_por_email', 'user_' . $current_user->ID);

    if ( $notificacao ) {
      echo '<i class="green check icon"></i> Status atual: <strong>ativado</strong>.';
    } else {
      echo '<i class="red close icon"></i> Status atual: <strong>desativado</strong>.';
    }

  } ?>

  <?php

  if ($_GET["notificacao_email"] == 'sim') {
    update_field( 'field_5953b0fa6c4f9', true,'user_' . $current_user->ID);
    echo '<i class="green check icon"></i> Notificações por e-mail ativadas.';
    // echo '<div class="ui green message">Notificações por e-mail ativadas.</div>';
  };
  if ($_GET["notificacao_email"] == 'nao') {
    update_field( 'field_5953b0fa6c4f9', false,'user_' . $current_user->ID);
    echo '<i class="red close icon"></i> Notificações por e-mail desativadas.';
    // echo '<div class="ui red message">Notificações por e-mail desativadas.</div>';
  };

  ?>

<?php else : ?>

  <h3 class="ui center aligned icon header">
    <a href="<?php echo wp_login_url(get_permalink()); ?>"><i class="yellow sign in icon"></i></a>
    Você não está logado.
  </h3>
  <p>Faça <a href="<?php echo wp_login_url(get_permalink()); ?>"><strong>login</strong></a> para continuar.</p>

<?php endif; ?>

<div class="ui hidden divider"></div>

</div>

<?php get_footer(); ?>
