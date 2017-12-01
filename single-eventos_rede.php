<?php acf_form_head(); ?>

<?php get_header(); ?>

<link rel="stylesheet" href="<?php bloginfo('url'); ?>/wp-content/themes/comunicacao-digital/css/form-tarefa.css">

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

/*.bg-evrd {
  background: -moz-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.8) 100%), url('http://localhost:8888/cdintranet/wp-content/uploads/2017/11/bg-sge.png') no-repeat;
  background: -webkit-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.8) 100%), url('http://localhost:8888/cdintranet/wp-content/uploads/2017/11/bg-sge.png') no-repeat;
  background: -o-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.8) 100%), url('http://localhost:8888/cdintranet/wp-content/uploads/2017/11/bg-sge.png') no-repeat;
  background: -ms-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.8) 100%), url('http://localhost:8888/cdintranet/wp-content/uploads/2017/11/bg-sge.png') no-repeat;
  background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.8) 100%), url('http://localhost:8888/cdintranet/wp-content/uploads/2017/11/bg-sge.png') no-repeat;
  background-size: cover;
  background-position: center;
}*/

.bg-evrd {
 background-image: linear-gradient(-20deg, #b721ff 0%, #21d4fd 100%);
}


/*.acf-field-59b05a664b6c2 {
  display: none;
}*/
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

  <div class="ui fluid container bg-evrd cd-padding">
    <h1 class="ui center aligned inverted header">
      <?php the_title(); ?>
      <div class="sub header">Evento em rede</div>
    </h1>
    <?php // the_post_thumbnail('full', ['class' => 'bg-evrd']); ?>
  </div>

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
      <h3>
        <em>
          <?php $area = get_field('area_divulgacao_tarefa'); if ($area) { echo $area['label']; } ?>
          <?php if ( get_field('subarea_tarefa') ) { echo ' - '; the_field('subarea_tarefa'); }?>
        </em>
      </h3>

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

      <div class="ui list">

        <!-- DADOS SOLICITANTE -->
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

        <?php $participantes = get_field('participante'); if( $participantes ): ?>

        <!-- PARTICIPANTES -->
        <div class="item">
          <i class="right triangle icon"></i>
          <div class="content">
            <div class="header">Participante(s)</div>
            <div class="description">
              	<?php foreach( $participantes as $participante ): ?>
              		<?php echo $participante['display_name']; ?><br>
              	<?php endforeach; ?>
            </div>
          </div>
        </div>

        <?php endif; ?>

        <!-- DATA DA SOLICITACAO -->
        <div class="item">
          <i class="right triangle icon"></i>
          <div class="content">
            <div class="header">Data da solicitação</div>
            <div class="description"><?php echo get_the_date('d/m/y') . ', às ' . get_the_date('G:i'); ?></div>
          </div>
        </div>

        <?php if ( get_field('data_de_inicio_do_curso') ) : ?>

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

        <?php if ( get_field('data_de_inicio_do_evento') ) : ?>

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

          <?php endif; ?>

          <?php if ( get_field('publicacao_pecas') ) : ?>

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

          <?php endif; ?>

          <?php if ( get_field('numero_de_atividades') ) : ?>

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

          <?php endif; ?>

          <?php if ( have_rows('formulario_arquivos') ) : ?>

          <!-- FORMULARIO E ARQUIVOS DO EVENTO -->
          <div class="item">
            <i class="right triangle icon"></i>
            <div class="content">
              <div class="header">Formulário e arquivos do evento</div>
              <div class="description">
        				<?php while( have_rows('formulario_arquivos') ): the_row(); $linkFormArquivos = get_sub_field('sub_formulario_arquivos'); ?>
                <a href="<?= $linkFormArquivos['url']; ?>" class="ui small primary button cd-popup" target="_blank" style="margin-top:10px;" title="<?= $linkFormArquivos['name']; ?>" download>Baixar</a>
                <!-- <a class="ui small primary button cd-popup" href="https://docs.google.com/viewerng/viewer?url=http://www3.sp.senac.br/hotsites/temp/teste.docx" title="<?= $linkFormArquivos['name']; ?>" style="margin-top:10px;" target="_blank">Visualizar</a> -->
                <?php endwhile;?>
              </div>
            </div>
          </div>

        <?php endif; ?>

        <?php if ( get_field('tipo_de_criacao') ) : ?>

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

        <?php endif; ?>

        <?php if ( get_field('outrotipocriacao') ) : ?>

        <!-- OUTRA CRIACAO -->
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

        <?php if ( get_field('breve_descricao') ) : ?>

        <!-- BREVE DESCRIÇAO -->
        <div class="item">
          <i class="right triangle icon"></i>
          <div class="content">
            <div class="header">Breve descrição</div>
            <div class="description" style="word-break: break-word;">
              <?php if ( get_field('breve_descricao') ) {
                the_field('breve_descricao');
              } else {
                echo '<span class="cd-nd"></span>';
              } ?>
            </div>
          </div>
        </div>

        <?php endif; ?>

        <?php if( have_rows('fotos_pauta') ) : ?>

        <!-- FOTOS PAUTA -->
        <div class="item">
          <i class="right triangle icon"></i>
          <div class="content">
            <div class="header">Fotos</div>
            <div class="description">
              <?php while( have_rows('fotos_pauta') ): the_row(); $sub_fotos_pauta = get_sub_field('sub_fotos_pauta'); ?>
              <a href="<?= $sub_fotos_pauta['url']; ?>" class="ui small primary button cd-popup" target="_blank" style="margin-top:10px;" title="<?= $sub_fotos_pauta['name'] ?>">Baixar</a>
              <?php endwhile;?>
            </div>
          </div>
        </div>

      <?php endif; ?>

      <?php if ( get_field('observacoes') ) : ?>

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

        <?php endif; ?>

        <?php if( current_user_can('edit_pages') ) : ?>

        <!-- DELETAR -->
        <div class="item">
          <i class="right triangle icon"></i>
          <div class="content">
            <div class="header">Deletar solicitação?</div>
            <div class="description">
              <div class="ui red button cd-delete-btn" style="margin-top:10px;">
                Deletar
              </div>
            </div>
          </div>
        </div>

        <!-- DELETE POST MODAL -->
        <div class="ui mini modal cd-delete">
          <i class="close icon"></i>
          <div class="header">
            Deletar solicitação
          </div>
          <div class="content">
            <p>Tem certeza que deseja deletar essa solicitação?</p>
          </div>
          <div class="actions">
            <div class="ui cd-cancel-btn button">Cancelar</div>
            <a href="<?php echo get_delete_post_link(); ?>" class="ui negative button">Deletar</a>
          </div>
        </div>

        <?php endif; ?>

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
              <?php if ($responsavel1 || $responsavel2 || $responsavel3 || $responsavel4) : ?>

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

        <?php // if ( $publicacao && in_array('publicacao', $publicacao) ): ?>

          <?php if ( get_field('previsao_de_publicacao') ) : ?>

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

          <?php endif; ?>

          <?php if ( $imagem_capa || $imagem_miniatura || $imagem_rodape || $imagem_lateral ) : ?>

          <!-- IMAGENS PORTAL -->
          <div class="item">
            <i class="right triangle icon"></i>
            <div class="content">
              <div class="header">Imagens portal</div>
              <div class="description">

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

              </div>
            </div>
          </div>

          <?php endif; ?>

          <?php if ( get_field('sugestao_de_texto') ) : ?>

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

          <?php endif; ?>

          <?php if ( get_field('link_evento_publicado') ) : ?>

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

        <?php if ( get_field('previsao_conclusao') ) : ?>

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

        <?php endif; ?>

        <?php if ( $texto_luares || $imagem_gd ) : ?>

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

        <?php endif; ?>

        <?php if ( have_rows('pecas_flex') ) : ?>

          <!-- PECAS FINALIZADAS-->
          <div class="item">
            <i class="right triangle icon"></i>
            <div class="content">
              <div class="header">Peças finalizadas</div>
              <div class="description">
                <?php while( have_rows('pecas_flex') ): the_row(); ?>

                  <?php if( get_row_layout() == 'links_flex' ): ?>

                    <a href="<?php the_sub_field('link_flex'); ?>" class="ui small green button" target="_blank" style="margin-top:10px;"><?php the_sub_field('nome_link_flex') ?></a>

                  <?php elseif( get_row_layout() == 'arquivos_flex' ): ?>

                    <a href="<?php the_sub_field('arquivo_flex'); ?>" class="ui small green button" target="_blank" style="margin-top:10px;"><?php the_sub_field('nome_arquivo_flex') ?></a>

                  <?php endif; ?>

                <?php endwhile; ?>

              </div>
            </div>
          </div>

        <?php endif; ?>

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
      <h3 class="ui dividing header"><i class="purple comments icon"></i><?php num_comentarios();?></h3><br>
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
  	// 'field_groups'    => array (13801),
    'field'    => array ('field_5a1d9e6d80ae8'),
  	'return' 			    => '%post_url%',
  	'uploader' => 'basic',
  	'submit_value'    => 'Atualizar',
  	'html_submit_button'	=> '<input type="submit" class="ui primary large fluid button" value="%s" />',
  	//'updated_message' => 'Salvo!'
  	);

  ?>

  <div class="ui vertical basic segment" style="background:rgba(0,0,0,.05);">
    <div class="ui center aligned container" style="margin-top: 20px;">
      <strong>Data da solicitação: </strong><?= get_the_date('d/m/Y') . ', às ' . get_the_date('G:i'); ?>
    </div>
    <div class="ui  container">

        <div class="ui hidden divider"></div>
        <?php acf_form( $abaTarefa ); ?>
        <div class="ui hidden divider"></div>

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

// // Atualizar posts
// $lastposts = get_posts( array(
//     'posts_per_page' => -1,
//     'post_type' => 'tarefa',
// ) );
//
// if ( $lastposts ) {
//     foreach ( $lastposts as $post ) :
//
//       $post_id = $post->ID;
//       include ( locate_template('template-parts/cd-feed-new.php') );
//
//     endforeach;
//     wp_reset_postdata();
// }

// Atualizar dados Walter
// $lastposts = get_posts( array(
//     'posts_per_page' => -1,
//     'post_type' => 'tarefa',
// ) );
//
// if ( $lastposts ) {
//     foreach ( $lastposts as $post ) :
//
//       $post_id = $post->ID;
//
//       $responsavel1 = get_field('responsavel_1');
//       $responsavel2 = get_field('responsavel_2');
//
//       if ($responsavel1['ID'] == 6) {
//         update_field( 'responsavel_1', 177, $post_id);
//       }
//
//       if ($responsavel2['ID'] == 6) {
//         update_field( 'responsavel_2', 177, $post_id);
//       }
//
//
//
//       $usuario_registrado = array();
//
//       $row = array(
//         'usuario'	=> 'walter.pfjunior',
//       );
//
//       if( have_rows('visitas') ):
//           while( have_rows('visitas') ) : the_row();
//               $usuario_registrado[] = get_sub_field('usuario');
//           endwhile;
//       endif;
//
//       // Faz a key do array começar em 1, não em 0, pq a row do ACF começa em 1. O número da key do usuário é igual ao número da row onde ele está inserido
//       array_unshift($usuario_registrado,"");
//       unset($usuario_registrado[0]);
//
//         // Procura o usuário no array de usuários registrados
//         if ( in_array('walter', $usuario_registrado) ) {
//
//           // Identifica sua posição (key) no array
//           $key = array_search('walter', $usuario_registrado);
//           $row_number = $key;
//
//           // Como ele já está registrado, apenas atualiza seu acesso na row dele
//           update_row('visitas', $row_number, $row);
//
//         }
//
//
//
//     endforeach;
//     wp_reset_postdata();
// }

// // CD Author Update
// $lastposts = get_posts( array(
//     'posts_per_page' => -1,
//     'post_type' => 'tarefa',
// ) );
//
// if ( $lastposts ) {
//     foreach ( $lastposts as $post ) :
//
//       $post_id = $post->ID;
//       $author_id = $post->post_author;
//
//       $cd_author = get_field('cd_author');
//
//       // update_field( 'cd_author', $author_id, $post_id);
//
//     endforeach;
//     wp_reset_postdata();
// }

?>


<script type="text/javascript">

(function hideRow () {

  var unidade = '.acf-field[data-name="unidade"]';
  var user_id = '.acf-field[data-name="user_id"]';
  var alteracoes = '.acf-field[data-name="alteracoes"]';
  var data_inicial = '.acf-field[data-name="data_e_hora_inicial"]';
  var data_final = '.acf-field[data-name="data_e_hora_final"]';
  var titulo = '.acf-field[data-name="titulo_da_atividade"]';
  var current_user_id = <?php echo get_current_user_id(); ?>;

  // Rows collapsed
  // $('.acf-row').not('.acf-table .acf-table .acf-row').addClass('-collapsed');

  // Rows open
  $('.acf-row').removeClass('-collapsed');

  // Esconde os controles
  $('.acf-row-handle.remove').hide();
  $('.acf-row-handle.order').hide();

  // Esconde o user ID e Alterações
  $(user_id).hide();
  $(alteracoes).hide();

  // Insere estilo dos botões e ao clicar, some
  $('.acf-actions a').removeClass('button-primary').addClass('ui').click(function () {
    $(this).hide();
    // $('.acf-actions').append('<input type="submit" class="ui primary button" value="Atualizar">');
  });

  // Número total de rows
  var rowsNum = $('.acf-row' + ' ' + unidade).length - 1;

  for (x=0 ; x<rowsNum ; x++) {

    var row = '.acf-row[data-id=' + x + ']';
    var user_row = $(row + ' ' + user_id + ' input').val(); // Row correspondente ao usuário que a criou

    // Se o usuário logado não for o mesmo que a criou, esconde
    if (current_user_id != user_row) {

      $(row).hide();

    } else {

      // Esconde os demais campos e deixa visível apenas Alteração
      var rowPublished = $(row + ' td.acf-fields.-left .acf-field');
      rowPublished.not(row + ' td.acf-fields.-left ' + alteracoes + ', .acf-table .acf-table td.acf-fields.-left .acf-field').hide();

      //$('.acf-row[data-id=' + x + '] .acf-field-5a1f019ed3d7f .acf-input').append( $('.acf-row[data-id=' + x + '] .acf-field-5a1da2b4b028a input').val() + ' <a class="ui primary button btn-alterar" data-alterar="' + x + '" style="float:right;">Solicitar alteração</a>');
      // Muda o título e descrição da row
      $(row + ' ' + alteracoes + ' > .acf-label label').html( $(row + ' ' + titulo + ' input').val() );
      $(row + ' ' + alteracoes + ' > .acf-label .description').html(
        'Início: ' + $(row + ' ' + data_inicial + ' input.input').val() + '<br>' +
        'Final: ' +  $(row + ' ' + data_final + ' input.input').val()
      );

      // Mostra Alterações apenas nas rows já criadas
      $(row + ' ' + alteracoes).show();

    }

  }

  // Criar função que registra o current user ID no repeater!!!

})();


// $('.btn-alterar').click(function() {
//   var d = $(this).data('alterar');
//   $('.acf-row[data-id=' + d + ']').removeClass('-collapsed');
// });

</script>


<?php get_footer(); ?>
