<?php acf_form_head(); ?>
<?php get_header(); ?>

<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/form-tarefa.css?ver=1.3">

<?php if( current_user_can('edit_pages') ) : ?>
<!-- MENU EDICAO -->
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
<?php include ( locate_template('template-parts/var-tarefas.php') ); ?>


<!-- LINHA COLORIDA -->
<!-- <div class="ui mini <?= $corStatus ?> label" style="width:100%; display: block; margin: 0; border-radius: 0; padding: 3em; "></div> -->


<!-- ***********
  PRIMEIRA TAB
*************-->

<div class="ui tab active" data-tab="first">


  <!-- TOPO -->

  <div style="background-color: #F5F5F5; background-image: linear-gradient(to top, #f5f5f5, #f7f7f7, #fafafa, #fcfcfc, #ffffff); padding: 4em 0">

  <div class="ui center aligned container stackable">
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
    <div class="label" style="margin-bottom: 10px;"><i class="power <?= $corStatus ?> icon"></i><strong>Status: <?= $status['label'] ?></strong> <?php $bg_icon = cd_date_diff(); echo $bg_icon['icon']; ?></div>
    <div class="ui small indicating progress" data-percent="<?= $percent ?>" id="example1" style="margin:0;">
      <div class="bar"></div>
    </div>
  </div>

  </div>


  <!-- 3 COLUNAS -->
  <div class="ui equal width grid container stackable cd-margem">


    <!-- *********** COLUNA SOLICITACAO *************-->

    <div class="column" id="solicitacao">
      <h3 class="ui header"><i class="blue file text icon"></i>SOLICITAÇÃO</h3><br>
      <div class="ui list">

        <!-- DADOS SOLICITANTE -->
        <div class="item download-txt">
          <!-- <i class="right triangle icon"></i> -->
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

        <!-- PARTICIPANTES -->
        <div class="item">
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Participante(s)</div>
            <div class="description">
              <div class="participantes">
              <?php if( $participantes ): ?>
              	<?php foreach( $participantes as $participante ): ?>
              		<?php echo $participante['display_name']; ?><br>
              	<?php endforeach; ?>
              <?php endif; ?>
              </div>

              <!-- PARTICIPAR DESTA SOLICITAÇÃO -->
              <span id="novo-participante"></span>

              <?php if (is_user_logged_in()) : ?>
                <button class="ui blue mini button participar" data-id="<?php the_ID(); ?>" data-username="<?php echo $current_user->display_name; ?>" style="margin-top:10px;">Participar desta solicitação</button>
              <?php else: ?>
                <a class="ui mini button" href="<?php echo wp_login_url(get_permalink()); ?>" style="margin-top:10px;">Faça login para participar</a>
              <?php endif; ?>

            </div>
          </div>
        </div>

        <!-- DATA DA SOLICITACAO -->
        <div class="item download-txt">
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Data da solicitação</div>
            <div class="description"><?php echo get_the_date('d/m/y') . ', às ' . get_the_date('G:i'); ?></div>
          </div>
        </div>

        <?php if ( get_field('formato_da_postagem') ) : ?>

        <!-- FORMATO DA POSTAGEM -->
        <div class="item download-txt">
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Formato da postagem</div>
            <div class="description">
              <?php the_field('formato_da_postagem'); ?>
            </div>
          </div>
        </div>

        <?php endif; ?>

        <?php if ( get_field('link_da_postagem') ) : ?>

        <!-- LINK DA POSTAGEM -->
        <div class="item download-txt">
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Link da postagem</div>
            <div class="description">
              <?php the_field('link_da_postagem'); ?>
            </div>
          </div>
        </div>

        <?php endif; ?>

        <?php if ( get_field('link_do_portal') ) : ?>

        <!-- LINK DA POSTAGEM -->
        <div class="item download-txt">
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Link do portal</div>
            <div class="description">
              <?php the_field('link_do_portal'); ?>
            </div>
          </div>
        </div>

        <?php endif; ?>

        <?php if ( get_field('publico') ) : ?>

        <!-- PUBLICO -->
        <div class="item download-txt">
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Público</div>
            <div class="description">
              <?php the_field('publico'); ?>
            </div>
          </div>
        </div>

        <?php endif; ?>

        <?php if ( get_field('interesses_do_publico') ) : ?>

        <!-- INTERESSES DO PUBLICO -->
        <div class="item download-txt">
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Interesses do público</div>
            <div class="description">
              <?php the_field('interesses_do_publico'); ?>
            </div>
          </div>
        </div>

        <?php endif; ?>

        <?php if ( get_field('praca') ) : ?>

        <!-- PRACA -->
        <div class="item download-txt">
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Praça</div>
            <div class="description">
              <?php the_field('praca'); ?>
            </div>
          </div>
        </div>

        <?php endif; ?>

        <?php if ( get_field('data_inicial') || get_field('data_final') ) : ?>

        <!-- PERIODO DO PATROCINIO -->
        <div class="item download-txt">
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Período do patrocínio</div>
            <div class="description">
              <?php the_field('data_inicial'); echo ' a '; the_field('data_final') ?>
            </div>
          </div>
        </div>

        <?php endif; ?>

        <?php if ( get_field('data_de_inicio_do_curso') ) : ?>

        <!-- DATA DE INICIO DO CURSO -->
        <div class="item">
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Data de início do curso</div>
            <div class="description">
              <?php the_field('data_de_inicio_do_curso'); ?>
            </div>
          </div>
        </div>

        <?php endif; ?>

        <?php if ( get_field('data_de_inicio_do_evento') ) : ?>

          <!-- DATA DE INICIO DO EVENTO -->
          <div class="item">
            <!-- <i class="right triangle icon"></i> -->
            <div class="content">
              <div class="header">Data de início do evento</div>
              <div class="description">
                <?php the_field('data_de_inicio_do_evento'); ?>
              </div>
            </div>
          </div>

          <?php endif; ?>

          <?php if ( get_field('publicacao_pecas') ) : ?>

          <!-- PUBLICACAO / PECAS -->
          <div class="item">
            <!-- <i class="right triangle icon"></i> -->
            <div class="content">
              <div class="header">Publicação no portal / peças</div>
              <div class="description">
                <?php the_field('publicacao_pecas'); ?>
              </div>
            </div>
          </div>

          <?php endif; ?>

          <?php if ( get_field('numero_de_atividades') ) : ?>

          <!-- NUMERO DE ATIVIDADES -->
          <div class="item">
            <!-- <i class="right triangle icon"></i> -->
            <div class="content">
              <div class="header">Número de atividades</div>
              <div class="description">
                <?php the_field('numero_de_atividades'); echo ' atividade(s)'; ?>
              </div>
            </div>
          </div>

          <?php endif; ?>

          <?php if ( have_rows('formulario_arquivos') ) : ?>

          <!-- FORMULARIO E ARQUIVOS DO EVENTO -->
          <div class="item">
            <!-- <i class="right triangle icon"></i> -->
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
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Tipo de criação</div>
            <div class="description">
              <?php the_field('tipo_de_criacao'); ?>
            </div>
          </div>
        </div>

        <?php endif; ?>

        <?php if ( get_field('outrotipocriacao') ) : ?>

        <!-- OUTRA CRIACAO -->
          <div class="item">
            <!-- <i class="right triangle icon"></i> -->
            <div class="content">
              <div class="header">Outra criação</div>
              <div class="description">
                <?php the_field('outrotipocriacao'); ?>
              </div>
            </div>
          </div>

        <?php endif; ?>

        <?php if ( get_field('catalogo_de_pecas') ) : ?>

        <!-- LINK DO CATALOGO -->
        <div class="item">
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Catálogo de peças</div>
            <div class="description">
              <a href="<?php the_permalink(get_field('catalogo_de_pecas')) ?>" class="ui small primary button" target="_blank" style="margin-top:10px;">Curso</a>
            </div>
          </div>
        </div>

        <?php endif; ?>

          <?php if ( get_field('publicado_portal') ): ?>

          <!-- PUBLICADO NO PORTAL -->
          <div class="item">
            <!-- <i class="right triangle icon"></i> -->
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
            <!-- <i class="right triangle icon"></i> -->
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
            <!-- <i class="right triangle icon"></i> -->
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
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Breve descrição</div>
            <div class="description" style="word-break: break-word;">
              <?php the_field('breve_descricao'); ?>
            </div>
          </div>
        </div>

        <?php endif; ?>

        <?php if( have_rows('fotos_pauta') ) : ?>

        <!-- FOTOS PAUTA -->
        <div class="item">
          <!-- <i class="right triangle icon"></i> -->
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
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Observações</div>
            <div class="description" style="word-break: break-word;">
              <?php the_field('observacoes'); ?>
            </div>
          </div>
        </div>

        <?php endif; ?>

        <?php if( current_user_can('edit_pages') ) : ?>

        <?php if( $finalidade['value'] == 'patrocinio-rs' ) : ?>
        <!-- DOWNLOAD PATROCINIO -->
        <div class="item">
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Download</div>
            <div class="description">
                <a href="#" class="ui blue mini button" id="downloadLink" style="margin-top:10px;">Baixar solicitação</a>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <!-- DELETAR -->
        <div class="item">
          <!-- <i class="right triangle icon"></i> -->
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

    <!-- *********** COLUNA PRODUCAO *************-->

    <div class="column" style="border-left: 1px solid #dedede; padding-left: 2rem; padding-right: 2rem;">

      <h3 class="ui header"><i class="green send icon"></i>PRODUÇÃO</h3><br>

      <div class="ui list">

        <!-- RESPONSAVEIS -->
        <div class="item">
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Responsáveis</div>
            <div class="description">
              <?php if ($responsavel1 || $responsavel2 || $responsavel3 || $responsavel4 || $responsavel5) : ?>

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
                  <?php if ($responsavel5) : ?>
                    <span class="ui mini circular image cd-popup" title="<?php echo $responsavel5['display_name'] ?>">
                      <?php echo $responsavel5['user_avatar'];?>
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

        <?php if ( get_field('campanha') ) : ?>

        <!-- CAMPANHA -->
        <div class="item download-txt">
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Campanha</div>
            <div class="description">
              <?php the_field('campanha'); ?>
            </div>
          </div>
        </div>

        <?php endif; ?>

        <?php if ( get_field('investimento') ) : ?>

        <!-- INVESTIMENTO -->
        <div class="item download-txt">
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Investimento</div>
            <div class="description">
              R$ <?php the_field('investimento'); ?>
            </div>
          </div>
        </div>

        <?php endif; ?>

        <?php // if ( $publicacao && in_array('publicacao', $publicacao) ): ?>

          <?php if ( get_field('previsao_de_publicacao') ) : ?>

          <!-- PREVISAO DE PUBLICACAO NO PORTAL -->
          <div class="item">
            <!-- <i class="right triangle icon"></i> -->
            <div class="content">
              <div class="header">Previsão de publicação no portal</div>
              <div class="description">
                <?php the_field('previsao_de_publicacao'); ?>
              </div>
            </div>
          </div>

          <?php endif; ?>

          <?php if ( $imagem_capa || $imagem_miniatura || $imagem_rodape || $imagem_lateral ) : ?>

          <!-- IMAGENS PORTAL -->
          <div class="item">
            <!-- <i class="right triangle icon"></i> -->
            <div class="content">
              <div class="header">Imagens portal</div>
              <div class="description">

                  <div style="margin-top:10px;">

                    <?php if ($imagem_capa) : ?>
                      <a class="ui tiny rounded image cd-popup" href="<?= $imagem_capa['url']; ?>" title="1000x526" target="_blank" download style="display:block;">
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
            <!-- <i class="right triangle icon"></i> -->
            <div class="content">
              <div class="header">Sugestão de texto</div>
              <div class="description">
                <?php the_field('sugestao_de_texto'); ?>
              </div>
            </div>
          </div>

          <?php endif; ?>

          <?php if ( get_field('link_evento_publicado') ) : ?>

          <!-- LINK DO EVENTO PUBLICADO -->
          <div class="item">
            <!-- <i class="right triangle icon"></i> -->
            <div class="content">
              <div class="header">Link do evento publicado</div>
              <div class="description">
                <a href="<?php the_field('link_evento_publicado'); ?>" class="ui small green button" target="_blank" style="margin-top:10px;">Link</a>
              </div>
            </div>
          </div>

        <?php endif; ?>

        <?php if ( get_field('previsao_conclusao') ) : ?>

        <!-- PREVISAO DE PRODUCAO DAS PECAS -->
        <div class="item">
          <!-- <i class="right triangle icon"></i> -->
          <div class="content">
            <div class="header">Previsão de entrega das peças</div>
            <div class="description">
              <?php
              $date = get_field('previsao_conclusao', false, false);
              $date = new DateTime($date); echo $date->format('d/m/y');
              ?>
            </div>
          </div>
        </div>

        <?php endif; ?>

        <?php if ( $texto_luares || $imagem_gd ) : ?>

          <?php if ( current_user_can('edit_dashboard') ) : ?>
          <!-- SOLICITAR TEXTO/IMAGEM -->
          <div class="item">
            <!-- <i class="right triangle icon"></i> -->
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
            <!-- <i class="right triangle icon"></i> -->
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
          <!-- <i class="right triangle icon"></i> -->
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

    <!-- *********** COLUNA INTERACAO *************-->

    <div class="column" style="border-left: 1px solid #dedede; padding-left: 2rem; padding-right: 2rem;">
      <h3 class="ui header"><i class="purple comments icon"></i><?php num_comentarios();?></h3><br>
      <?php comments_template(); ?>
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
      <strong>Data da solicitação: </strong><?= get_the_date('d/m/Y') . ', às ' . get_the_date('G:i'); ?>
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

<a class="ui large blue button icon topo" style="display:none;"><i class="up arrow icon"></i></a>

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

<script src="<?php bloginfo('template_url'); ?>/js/tarefa.js?ver=1.1"></script>

<?php get_footer(); ?>
