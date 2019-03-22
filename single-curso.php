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

      <div class="ui disabled sub header modalidade"><?= $lblModalidade; ?></div>
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

<div class="ui basic segment cd-padding" style="background-color:#F6F6F6; display:none;" id="section-email">

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
        <label>Link do curso</label>
        <input type="text" id="input-portal">
      </div>

      <!-- UNIDADE -->
      <div class="field">
        <label>Unidade</label>
        <?php
        $field_key = "field_58d1a32b9f77e";
        $excluir = array('GAC', 'GCR', 'GD1', 'GD2', 'GD3', 'GD4', 'GEP', 'GHJ', 'GHP', 'GMS', 'GPG', 'EDS', 'JUL');
        $field = get_field_object($field_key);
        $field_final = array_diff($field['choices'], $excluir);

        if( $field_final ) {

          echo '<select id="select-unidade">';
          foreach( $field_final as $k => $v ) {
            echo '<option value="' . $k . '">' . $v . '</option>';
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

      <div class="ui hidden divider"></div>

      <div class="ui action input email" style="display:none;">
        <input id="input-email" type="text">
        <button class="ui green right labeled icon button" id="copiar-email">
          <i class="copy icon"></i>
          Copiar
        </button>
      </div>

    </div>

    </div>

    <!-- // FORM EMAIL MARKETING -->

  </div>

  <div class="ten wide column">

    <!-- EMAIL MARKETING -->

    <div id="email-marketing">

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
                <td width="500">&nbsp;</td>
                <td width="50">&nbsp;</td>
              </tr>
              <tr>
                <td width="50">&nbsp;</td>
                <td width="500">&nbsp;</td>
                <td width="50">&nbsp;</td>
              </tr>
              <tr>
                <td width="50">&nbsp;</td>
                <td id="texto" width="500" align="left" style="font-family: Arial, Helvetica, sans-serif; font-size: 18px;">
                  <?php if (get_field('texto-curso')) : the_field('texto-curso'); else : echo 'Atenção! Não há texto cadastrado.'; endif; ?>
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
                <td id="cta-bg" width="500" align="center" bgcolor="#000001">
                  <a id="portal" target="_blank" style="font-family: Arial, Helvetica, sans-serif; font-size:18px; line-height:18px; font-weight:bold; display:block; text-decoration:none;"><br />Inscreva-se.<br /><br /></a>
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
                <td width="500"><img title="Senac S&atilde;o Paulo" src="http://www1.sp.senac.br/hotsites/msg/gcr/2017_Desconto_30_500px_01.gif" alt="Descontos 30% - Em todos os cursos presenciais - livres, t&eacute;cnicos e idiomas. - Veja o percentual que seu curso oferece."  border="0" style="display:block; border:0;" /></td>
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
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td>
                <td width="419" align="right" valign="bottom" style="font-family: Arial, Helvetica, sans-serif; font-size:16px;">
                  <strong>APRENDIZADO E CONHECIMENTO PARA SEMPRE.</strong><br /><br />
                  Acesse <a id="link-unidade" target="_blank"><strong></strong></a> e conhe&ccedil;a a programa&ccedil;&atilde;o completa da unidade.<br /><br />
                  <img id="tel-icon" width="20" style="border:0;" />
                  <span id="tel-text" style="margin-left: 5px;"></span><br />
                  <img id="pin-icon" height="20" style="border:0;" />
                  <a id="pin-text" target="_blank" style="text-decoration: underline; margin-left: 5px;"></a>
                </td>
                <td width="20" valign="middle">&nbsp;</td>
                <td width="121" valign="bottom">
                  <img id="logo-senac" title="Senac S&atilde;o Paulo" alt="Senac S&atilde;o Paulo"  border="0" width="121" height="135" />
                </td>
                <td width="20">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
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
            <strong>Atendimento corporativo</strong>, solu&ccedil;&otilde;es para empresas: 0800 707 1027 ou <a id="atendimento" target="_blank" style="color:#666666">www.sp.senac.br/corporativo</a>. <br />
            <br />
            <strong>Educa&ccedil;&atilde;o a Dist&acirc;ncia Senac:</strong> conhe&ccedil;a a programa&ccedil;&atilde;o no site <a id="ead" target="_blank" style="color:#666666">www.ead.senac.br</a>. <br />
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
<script src="<?php bloginfo('template_url') ?>/js/download.js"></script>
<script src="<?php bloginfo('template_url') ?>/js/unidades.js?ver=1.3"></script>
<script src="<?php bloginfo('template_url') ?>/js/criar-emkt.js?ver=1.1"></script>

<?php get_footer(); ?>
