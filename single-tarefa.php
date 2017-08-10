<?php acf_form_head(); ?>

<?php get_header(); ?>

<link rel="stylesheet" href="<?php bloginfo('url'); ?>/wp-content/themes/comunicacao-digital/css/form-tarefa.css">

<?php

// Tarefas sem status = Não iniciadas
// if ( !get_field('status') ) {
//   update_field('status', 'naoiniciado');
// }

?>


<?php // if ( $publicacao && in_array('publicacao', $publicacao) ): ?>
<!-- <p>Publicação de Evento</p> -->
<?php // elseif ( $publicacao && in_array('pecas', $publicacao) ): ?>
<!-- <p>Criação de Peças</p> -->
<?php // endif; ?>

<?php
//if (get_field('field_name') == 'Field Value') {
  // code to run if the above is true
//} else if (get_field('other_field_name') == 'Other Field Value') {
        // more code
//}
?>

<style type="text/css">
.cd-nd {
  color: rgba(0, 0, 0, 0.4);
  font-style: italic;
}
.cd-nd:before {
  content: "Não disponível";
}
.ui.list>.item {
  padding: .9em 0;
}
.acf-field--post-title {
display: none;
}
.acf-repeater ul li {
  float: left;
  margin-left: 0;
}
</style>

<?php if( current_user_can('edit_pages') ) : ?>

  <!-- MENU EDICAO DESIGNERS -->

  <div class="ui attached stackable menu" style="border: 1px solid rgba(0, 0, 0, 0.1); background:rgba(0,0,0,.05)">
    <div class="ui container">
        <div class="right menu">
       	 <a class="item active" data-tab="first"><i class="file text icon"></i>Tarefa</a>
         <a class="item" data-tab="second" style="border-right:1px solid rgba(0, 0, 0, 0.1)"><i class="edit icon"></i>Editar</a>
        </div>
    </div>
  </div>

  <!-- <div class="ui cd-tab center aligned container cd-margem">
    <div class="ui buttons">
      <a class="ui labeled icon button item active" data-tab="first">
        <i class="file text icon"></i>
        Tarefa
      </a>
      <a class="ui right labeled icon button item" data-tab="second">
        Editar
        <i class="edit icon"></i>
      </a>
    </div>
  </div> -->

<?php endif; ?>

<?php while ( have_posts() ) : the_post(); ?>

<?php
// VARIAVEIS TAREFAS
include ( locate_template('template-parts/var-tarefas.php') );
?>

<!-- ***********
  PRIMEIRA TAB
*************-->

<!-- <div class="ui mini <?= $corStatus ?> label" style="width:100%; display: block; margin: 0; border-radius: 0; padding: 0.3em 0.3em; "></div> -->

<div class="ui tab active" data-tab="first">

  <!-- TITULO PAGINA -->

  <div class="ui hidden divider"></div>

  <div class="ui center aligned container stackable cd-margem">
    <div class="ui grey label"><?= $finalidade['label']; ?></div>
      <h2 class="ui center aligned header">
        <div class="content">
          <div class="sub header"><?= $modalidade['label'] ?></div>
          <?php the_title(); ?>
        </div>
      </h2>
      <h3><em><?php the_field('area_divulgacao_tarefa'); ?><?php if ( get_field('subarea_tarefa') ) { echo ' - '; the_field('subarea_tarefa'); }?></em></h3>

      <!-- BARRA PORCENTAGEM -->
      <div class="ui hidden divider"></div>
      <div class="label" style="margin-bottom: 10px;"><i class="power <?= $corStatus ?> icon"></i><strong>Status: <?= $status['label'] ?></strong></div>
      <div class="ui small indicating progress" data-percent="<?= $percent ?>" id="example1" style="margin:0;">
        <div class="bar"></div>
      </div>
  </div>

  <!-- 3 COLUNAS -->

  <div class="ui equal width grid container stackable cd-margem">

    <!-- COLUNA SOLICITAÇÃO -->

    <div class="column">
      <h3 class="ui dividing header"><i class="blue file text icon"></i>SOLICITAÇÃO</h3><br>

      <!-- DADOS SOLICITANTE -->

      <div class="ui list">

        <div class="item">
          <i class="right triangle icon"></i>
          <div class="content">
            <div class="header">Solicitante</div>
            <div class="description">
              <?php echo get_the_author_meta('first_name'); ?>  <?php echo get_the_author_meta('last_name'); ?><br>
              <?php $authorDesc = the_author_meta('user_email'); echo $authorDesc; ?><br>
              <?php the_field('telefone'); ?><br>
              <?php the_field('unidade'); ?>
            </div>
          </div>
        </div>

        <!-- DATA DA SOLICITACAO -->
        <div class="item">
          <i class="right triangle icon"></i>
          <div class="content">
            <div class="header">Data da solicitação</div>
            <div class="description"><?php echo get_the_date('d/m/y') . ', às ' . get_the_date('H:m'); ?></div>
          </div>
        </div>

        <?php if ( $finalidade ['value'] === 'dcurso' ) : ?>

        <!-- DATA DE INICIO DO CURSO -->
        <div class="item">
          <i class="right triangle icon"></i>
          <div class="content">
            <div class="header">Data de início do curso</div>
            <div class="description">
              <?php if ( get_field('data_de_inicio_do_curso') ) {
                the_field('data_de_inicio_do_curso');
              } else {
                echo '<span class="cd-nd"></span>';
              } ?>
            </div>
          </div>
        </div>

        <?php endif; ?>

        <?php if ( $finalidade ['value'] === 'devento' ) : ?>

          <!-- DATA DE INICIO DO EVENTO -->
          <div class="item">
            <i class="right triangle icon"></i>
            <div class="content">
              <div class="header">Data de início do evento</div>
              <div class="description">
                <?php if ( get_field('data_de_inicio_do_evento') ) {
                  the_field('data_de_inicio_do_evento');
                } else {
                  echo '<span class="cd-nd"></span>';
                } ?>
              </div>
            </div>
          </div>

          <!-- PUBLICACAO / PECAS -->
          <div class="item">
            <i class="right triangle icon"></i>
            <div class="content">
              <div class="header">Publicação no portal / peças</div>
              <div class="description">
                <?php if ( get_field('publicacao_pecas') ) {
                  the_field('publicacao_pecas');
                } else {
                  echo '<span class="cd-nd"></span>';
                } ?>
              </div>
            </div>
          </div>

          <!-- NUMERO DE ATIVIDADES -->
          <div class="item">
            <i class="right triangle icon"></i>
            <div class="content">
              <div class="header">Número de atividades</div>
              <div class="description">
                <?php if ( get_field('numero_de_atividades') ) {
                  the_field('numero_de_atividades'); echo ' atividade(s)';
                } else {
                  echo '<span class="cd-nd"></span>';
                } ?>
              </div>
            </div>
          </div>

          <!-- FORMULARIO E ARQUIVOS DO EVENTO -->
          <div class="item">
            <i class="right triangle icon"></i>
            <div class="content">
              <div class="header">Formulário e arquivos do evento</div>
              <div class="description">
                <?php if( have_rows('formulario_arquivos') ) : ?>
        				<?php while( have_rows('formulario_arquivos') ): the_row(); $linkFormArquivos = get_sub_field('sub_formulario_arquivos'); ?>
                <a href="<?= $linkFormArquivos['url']; ?>" class="ui small primary button cd-popup" target="_blank" style="margin-top:10px;" title="<?= $linkFormArquivos['name']; ?>" download>Baixar</a>
                <!-- <a class="ui small primary button cd-popup" href="https://docs.google.com/viewerng/viewer?url=http://www3.sp.senac.br/hotsites/temp/teste.docx" title="<?= $linkFormArquivos['name']; ?>" style="margin-top:10px;" target="_blank">Visualizar</a> -->
                <?php endwhile;?>
                <?php else : ?>
                  <span class="cd-nd"></span>
                <?php endif;?>
              </div>
            </div>
          </div>

        <?php endif; ?>

        <!-- TIPO DE CRIACAO -->
        <div class="item">
          <i class="right triangle icon"></i>
          <div class="content">
            <div class="header">Tipo de criação</div>
            <div class="description">
              <?php if ( get_field('tipo_de_criacao') ) {
                the_field('tipo_de_criacao');
              } else {
                echo '<span class="cd-nd"></span>';
              } ?>
            </div>
          </div>
        </div>

        <!-- OUTRA CRIACAO -->
        <?php if ( get_field('outrotipocriacao') ) : ?>
          <div class="item">
            <i class="right triangle icon"></i>
            <div class="content">
              <div class="header">Outra criação</div>
              <div class="description">
                <?php if ( get_field('outrotipocriacao') ) {
                  the_field('outrotipocriacao');
                } else {
                  echo '<span class="cd-nd"></span>';
                } ?>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <?php // if ( $finalidade['value'] === 'dcurso' || $finalidade['value'] === 'outrafinalidade' ) : ?>
        <?php // if ( $publicacao && !in_array('publicacao', $publicacao) ): ?>

          <?php if ( get_field('publicado_portal') ): ?>

          <!-- PUBLICADO NO PORTAL -->
          <div class="item">
            <i class="right triangle icon"></i>
            <div class="content">
              <div class="header">Publicado no portal</div>
              <div class="description">
                <?php the_field('publicado_portal'); ?>
              </div>
            </div>
          </div>

          <?php endif; ?>

          <?php if ( get_field('link_portal_senac') ): ?>

          <!-- LINK PORTAL SENAC -->
          <div class="item">
            <i class="right triangle icon"></i>
            <div class="content">
              <div class="header">Link portal Senac</div>
              <div class="description">
                  <a href="<?php the_field('link_portal_senac'); ?>" class="ui small primary button" target="_blank" style="margin-top:10px;">Link</a>
              </div>
            </div>
          </div>

          <?php endif; ?>

          <?php if( have_rows('arquivos') ) : ?>

          <!-- ARQUIVOS -->
          <div class="item">
            <i class="right triangle icon"></i>
            <div class="content">
              <div class="header">Arquivos</div>
              <div class="description">
                <?php while( have_rows('arquivos') ): the_row(); $sub_arquivos = get_sub_field('sub_arquivos'); ?>
                <a href="<?= $sub_arquivos['url']; ?>" class="ui small primary button cd-popup" target="_blank" style="margin-top:10px;" title="<?= $sub_arquivos['name'] ?>">Baixar</a>
                <?php endwhile;?>
              </div>
            </div>
          </div>

        <?php endif; ?>

        <!-- OBSERVACOES -->
        <div class="item">
          <i class="right triangle icon"></i>
          <div class="content">
            <div class="header">Observações</div>
            <div class="description" style="word-break: break-word;">
              <?php if ( get_field('observacoes') ) {
                the_field('observacoes');
              } else {
                echo '<span class="cd-nd"></span>';
              } ?>
            </div>
          </div>
        </div>

      </div>

    </div>

    <!-- COLUNA PRODUÇÃO -->

    <div class="column" style="border-left: 5px solid #d4d4d5; padding-left: 2rem; padding-right: 2rem;">

      <h3 class="ui dividing header"><i class="green send icon"></i>PRODUÇÃO</h3><br>

      <div class="ui list">

        <!-- RESPONSAVEIS -->
        <div class="item">
          <i class="right triangle icon"></i>
          <div class="content">
            <div class="header">Responsáveis</div>
            <div class="description">
              <?php if ($responsavel1 || $responsavel2 || $responsavel3) : ?>

                <div style="margin-top:10px;">
                  <?php if ($responsavel1) : ?>
                    <span class="ui mini circular image cd-popup" title="<?php echo $responsavel1['display_name'] ?>">
                      <?php echo $responsavel1['user_avatar'];?>
                    </span>
                    &nbsp;
                  <?php endif; ?>
                  <?php if ($responsavel2) : ?>
                    <span class="ui mini circular image cd-popup" title="<?php echo $responsavel2['display_name'] ?>">
                      <?php echo $responsavel2['user_avatar'];?>
                    </span>
                    &nbsp;
                  <?php endif; ?>
                  <?php if ($responsavel3) : ?>
                    <span class="ui mini circular image cd-popup" title="<?php echo $responsavel3['display_name'] ?>">
                      <?php echo $responsavel3['user_avatar'];?>
                    </span>
                    &nbsp;
                  <?php endif; ?>
                  <?php if ($responsavel4) : ?>
                    <span class="ui mini circular image cd-popup" title="<?php echo $responsavel4['display_name'] ?>">
                      <?php echo $responsavel4['user_avatar'];?>
                    </span>
                    &nbsp;
                  <?php endif; ?>
                </div>

            <?php else : ?>
              <span class="cd-nd"></span>
            <?php endif; ?>
            </div>
          </div>
        </div>

        <?php if ( $publicacao && in_array('publicacao', $publicacao) ): ?>

          <!-- PREVISAO DE PUBLICACAO NO PORTAL -->
          <div class="item">
            <i class="right triangle icon"></i>
            <div class="content">
              <div class="header">Previsão de publicação no portal</div>
              <div class="description">
                <?php if ( get_field('previsao_de_publicacao') ) {
                  the_field('previsao_de_publicacao');
                } else {
                  echo '<span class="cd-nd"></span>';
                } ?>
              </div>
            </div>
          </div>

          <!-- IMAGENS PORTAL -->
          <div class="item">
            <i class="right triangle icon"></i>
            <div class="content">
              <div class="header">Imagens portal</div>
              <div class="description">

                <?php if ( $imagem_capa || $imagem_miniatura || $imagem_rodape || $imagem_lateral ) : ?>

                  <div style="margin-top:10px;">

                    <?php if ($imagem_capa) : ?>
                      <a class="ui tiny rounded image cd-popup" href="<?= $imagem_capa['url']; ?>" title="745x392" target="_blank" download style="display:block;">
                        <img src="<?= $imagem_capa['url']; ?>" />
                      </a>
                    <?php endif; ?>

                    <?php if ($imagem_miniatura) : ?>
                      <a class="ui tiny rounded image cd-popup" href="<?= $imagem_miniatura['url']; ?>" title="235x100" target="_blank" download style="display:block; margin-top:10px;">
                        <img src="<?= $imagem_miniatura['url']; ?>" />
                      </a>
                    <?php endif; ?>

                    <?php if ($imagem_rodape) : ?>
                      <a class="ui tiny rounded image cd-popup" href="<?= $imagem_rodape['url']; ?>" title="Imagem rodapé" target="_blank" download style="display:block; margin-top:10px;">
                        <img src="<?= $imagem_rodape['url']; ?>" />
                      </a>
                    <?php endif; ?>

                    <?php if ($imagem_lateral) : ?>
                      <a class="ui tiny rounded image cd-popup" href="<?= $imagem_lateral['url']; ?>" title="Imagem lateral" target="_blank" download style="display:block; margin-top:10px;">
                        <img src="<?= $imagem_lateral['url']; ?>" />
                      </a>
                    <?php endif; ?>

                  </div>

                <?php else : ?>
                  <span class="cd-nd"></span>
                <?php endif; ?>

              </div>
            </div>
          </div>

          <!-- SUGESTAO DE TEXTO -->
          <div class="item">
            <i class="right triangle icon"></i>
            <div class="content">
              <div class="header">Sugestão de texto</div>
              <div class="description">
                <?php if ( get_field('sugestao_de_texto') ) {
                  the_field('sugestao_de_texto');
                } else {
                  echo '<span class="cd-nd"></span>';
                } ?>
              </div>
            </div>
          </div>

          <!-- LINK DO EVENTO PUBLICADO -->
          <div class="item">
            <i class="right triangle icon"></i>
            <div class="content">
              <div class="header">Link do evento publicado</div>
              <div class="description">
                <?php if ( get_field('link_evento_publicado') ) : ?>
                  <a href="<?php the_field('link_evento_publicado'); ?>" class="ui small green button" target="_blank" style="margin-top:10px;">Link</a>
                <?php else : ?>
                  <span class="cd-nd"></span>
                <?php endif; ?>
              </div>
            </div>
          </div>

        <?php endif; ?>

        <!-- PREVISAO DE PRODUCAO DAS PECAS -->
        <div class="item">
          <i class="right triangle icon"></i>
          <div class="content">
            <div class="header">Previsão de entrega das peças</div>
            <div class="description">
              <?php $date = get_field('previsao_conclusao', false, false);
              if ( get_field('previsao_conclusao') ) {
                $date = new DateTime($date); echo $date->format('d/m/y');
              } else {
                echo '<span class="cd-nd"></span>';
              } ?>
            </div>
          </div>
        </div>

        <?php if ( !current_user_can('portal') || !current_user_can('senac') ) : ?>
        <!-- SOLICITAR TEXTO/IMAGEM -->
        <div class="item">
          <i class="right triangle icon"></i>
          <div class="content">
            <div class="header">Solicitar texto / imagem</div>
            <div class="description">
              <?php if (!$texto_luares) : ?><i class="file text icon" style="color: #CCC;"></i><?php endif; ?>
              <?php if ($texto_luares['value'] == 'solicitar-texto') : ?><i class="red file text icon cd-popup" title="Solicitar texto"></i><?php endif; ?>
              <?php if ($texto_luares['value'] == 'texto-solicitado') : ?><i class="green file text icon cd-popup" title="Texto solicitado"></i><?php endif; ?>
              <?php if (!$imagem_gd) : ?><i class="file image outline icon" style="color: #CCC;"></i><?php endif; ?>
              <?php if ($imagem_gd['value'] == 'solicitar-imagem') : ?><i class="red file image outline icon cd-popup" title="Solicitar imagem"></i><?php endif; ?>
              <?php if ($imagem_gd['value'] == 'imagem-solicitada') : ?><i class="green file image outline icon cd-popup" title="Imagem solicitada"></i><?php endif; ?>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <!-- PECAS FINALIZADAS-->
        <div class="item">
          <i class="right triangle icon"></i>
          <div class="content">
            <div class="header">Peças finalizadas</div>
            <div class="description">
              <?php if( have_rows('pecas_flex') ) : ?>
              <?php while( have_rows('pecas_flex') ): the_row(); ?>

                <?php if( get_row_layout() == 'links_flex' ): ?>

                  <a href="<?php the_sub_field('link_flex'); ?>" class="ui small green button" target="_blank" style="margin-top:10px;"><?php the_sub_field('nome_link_flex') ?></a>

                <?php elseif( get_row_layout() == 'arquivos_flex' ): ?>

                  <a href="<?php the_sub_field('arquivo_flex'); ?>" class="ui small green button" target="_blank" style="margin-top:10px;"><?php the_sub_field('nome_arquivo_flex') ?></a>

                <?php endif; ?>

              <?php endwhile; ?>
              <?php else : ?>
                <span class="cd-nd"></span>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- ULTIMA ATUALIZACAO -->
        <div class="item">
          <i class="right triangle icon"></i>
          <div class="content">
            <div class="header">Última atualização</div>
            <div class="description">
              <?php the_modified_date('d/m/y'); echo ', às '; the_modified_time('G:i');?>
              <?php if ( get_post_meta(get_post()->ID, '_edit_last') ) { echo '<br>por '; the_modified_author(); } ?>
            </div>
          </div>
        </div>

      </div>

    </div>

    <!-- COLUNA INTERAÇÃO -->

    <div class="column" style="border-left: 5px solid #d4d4d5; padding-left: 2rem; padding-right: 2rem;">
      <h3 class="ui dividing header"><i class="purple comments icon"></i><?php comments_number('0 INTERAÇÕES', '1 INTERAÇÃO', '% INTERAÇÕES' );?></h3><br>
      <?php comments_template(); ?>

      <!-- <h3 class="ui dividing header" style="color: rgba(0, 0, 0, 0.4);">ARQUIVOS EXTRAS</h3> -->
      <em style="color: rgba(0, 0, 0, 0.4);"><i class="info circle icon"></i>Os arquivos extras foram desativados. Para enviar novos arquivos, digite uma mensagem acima, clique em "adicionar anexos" e depois em "enviar".</em><br><br>
      <?php acf_form( $arquivosExtras ); ?>
      <?php $i=1;
      if( have_rows('arquivos_extras') ) {
        // echo '<span style="color: rgba(0, 0, 0, 0.4);">Adicionados anteriormente:</span><br>';
				while( have_rows('arquivos_extras') ) { the_row();
					$arquivo_extra = get_sub_field('arquivo_extra');
					echo '<a href="' . $arquivo_extra['url'] . '" target="_blank" class="cd-popup" title="' . $arquivo_extra['name'] . '"><i class="file icon"></i>Arquivo extra ' . $i++ . '</a><br>';
				}
			}
      ?>
    </div>

  </div>

</div>

<!-- ***********
  SEGUNDA TAB
*************-->

<div class="ui tab" data-tab="second">

  <?php

  	$abaTarefa = array(
    'post_title'      => true,
  	'field_groups'    => array (127),
  	'return' 			    => '%post_url%',
  	'uploader' => 'basic',
  	'submit_value'    => 'Atualizar',
  	'html_submit_button'	=> '<input type="submit" class="ui primary large fluid button" value="%s" />',
  	//'updated_message' => 'Salvo!'
  	);

  	$abaProducao = array(
  	'field_groups'    => array (1652),
  	'return' 			    => '%post_url%',
  	//'uploader' => 'basic',
  	'submit_value'    => 'Atualizar',
  	'html_submit_button'	=> '<input type="submit" class="ui primary large fluid button" value="%s" />',
  	//'updated_message' => 'Salvo!'
  	);

  ?>

  <div class="ui vertical basic segment" style="background:rgba(0,0,0,.05);">
    <div class="ui center aligned container" style="margin-top: 20px;">
      <strong>Data da solicitação: </strong><?= get_the_date('d/m/Y') . ', às ' . get_the_date('H:m'); ?>
    </div>
    <div class="ui grid container stackable">

      <div class="ten wide column cd-box cd-esconder">
        <div class="ui hidden divider"></div>
        <?php acf_form( $abaTarefa ); ?>
        <div class="ui hidden divider"></div>
      </div>

      <div class="six wide column cd-box">
        <div class="ui hidden divider"></div>
        <?php acf_form( $abaProducao ); ?>
        <div class="ui hidden divider"></div>
      </div>

    </div>
  </div>

</div>

<?php endwhile; ?>

<?php

// // Atualizar usuários
// $blogusers = get_users( array( 'fields' => array( 'ID' ) ) );
// foreach ( $blogusers as $user ) {
// 	$user->ID;
//   update_field( 'field_5953b0fa6c4f9', true,'user_' . $user->ID); // Notificações por email == checked
//   update_field( 'field_595feb818431d', true,'user_' . $user->ID); // Atualizar feed == checked
// };

// Atualizar comments privados
// $comments = get_comments();
// foreach ( $comments as $comment ) {
// 	// echo $comment->comment_ID . '<br>';
//   update_field( 'field_5984a7402ced4', false,'comment_' . $comment->comment_ID);
// };

?>

<?php get_footer(); ?>
