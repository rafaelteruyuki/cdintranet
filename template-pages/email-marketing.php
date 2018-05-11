<?php

/*
Template Name: E-mail Marketing
*/

global $current_user;

$unidades = array(
  'ACA' => array(
    'nome'        => 'Araçatuba',
    'nome_url'    => 'aracatuba',
    'endereco'    => 'Av. João Arruda Brasil, 500',
    'bairro'      => 'São Joaquim',
    'CEP'         => '16050-400',
    'telefone'    => '(18) 3117-1000',
    'url'         => 'http://www.sp.senac.br/jsp/default.jsp?newsID=a529.htm&testeira=352&unit=A%C7A&sub=1',
    'google_maps' => 'https://www.google.com.br/maps/place/Senac+Ara%C3%A7atuba/@-21.201429,-50.4467907,17z/data=!3m1!4b1!4m5!3m4!1s0x949643f3d8a31887:0xec4d448031b7e3fd!8m2!3d-21.201429!4d-50.444602',
  ),
  'ACL' => array(
    'nome'        => 'Aclimação',
    'nome_url'    => 'aclimacao',
    'endereco'    => 'Rua Pires da Mota, 838',
    'bairro'      => 'Aclimação',
    'CEP'         => '01529-000',
    'telefone'    => '(11) 3795-1299',
    'url'         => 'http://www.sp.senac.br/jsp/default.jsp?newsID=a18070.htm&testeira=1737&unit=ACL&sub=1',
    'google_maps' => 'https://www.google.com.br/maps/place/Senac+Aclima%C3%A7%C3%A3o/@-23.5686172,-46.6383325,17z/data=!3m1!4b1!4m5!3m4!1s0x94ce599f467de6b9:0x221608c031490e7d!8m2!3d-23.5686172!4d-46.6361438',
  ),
);

// UNIDADE
$unidade = $_GET['unidade'];
// CURSO
$modalidade = $_GET['modalidade'];
$titulo = $_GET['titulo'];
$texto = $_GET['texto'];
$link_imagem = $_GET['link-imagem'];
$link_portal = $_GET['link-portal'];
// CORPO
$corpo_fundo = $_GET['corpo-fundo'];
$corpo_texto = $_GET['corpo-texto'];
$borda = $_GET['borda'];
// INSCREVA-SE
$inscreva_se_fundo = $_GET['inscreva-se-fundo'];
$inscreva_se_texto = $_GET['inscreva-se-texto'];
// ASSINATURA
$assinatura_fundo = $_GET['assinatura-fundo'];
$assinatura_texto = $_GET['assinatura-texto'];
$logo = $_GET['logo'];
$pin_preto = 'http://www1.sp.senac.br/hotsites/msg/gcr/pin_preto.png';
$pin_branco = 'http://www1.sp.senac.br/hotsites/msg/gcr/pin_branco.png';
$tel_preto = 'http://www1.sp.senac.br/hotsites/msg/gcr/tel_preto.png';
$tel_branco = 'http://www1.sp.senac.br/hotsites/msg/gcr/tel_branco.png';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Senac <?= convert_string_to_html($unidades[$unidade]['nome']); ?> - <?= $modalidade ?> - <?= $titulo ?></title>
</head>

<body>
<div align="center">
	<table id="container" width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px solid <?= $borda ?>; border-collapse:collapse;">
		<tr>
			<td>
				<img src="<?= $link_imagem ?>" alt="<?= $modalidade ?> - <?= $titulo ?>" width="600" style="display:block; border:0;" />
			</td>
		</tr>
		<tr>
			<td>
				<table id="descricao" width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bgcolor="<?= $corpo_fundo ?>">
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
						<td width="500" align="left" style="font-family: Arial, Helvetica, sans-serif; font-size: 18px; color: <?= $corpo_texto ?>;">
              <?= $texto ?>
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
