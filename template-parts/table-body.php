<?php

// VARIAVEIS TAREFAS
include ( locate_template('template-parts/var-tarefas.php') );

?>

<tr class="center aligned cd-tarefa" style="cursor:pointer; <?php new_task('background:#ebf7ff;'); ?><?= comment_nao_lido(); ?>" onclick="window.open('<?php the_permalink(); ?>');" >
  <td class="collapsing"><?php the_field('unidade'); ?></td>
  <td class="collapsing">

    <?php if($finalidade['value'] === "dcurso"){
      echo 'Curso';
    }
    elseif($finalidade['value'] === "devento"){
      echo 'Evento';
    }
    elseif($finalidade['value'] === "outrafinalidade"){
      echo 'Outra';
    }
    elseif($finalidade['value'] === "pauta"){
      echo 'Pauta';
    }
    elseif($finalidade['value'] === "patrocinio-rs"){
      echo 'Patrocínio';
    }
    ?>

  </td>
  <td class="left aligned" style="white-space:nowrap;  max-width:200px; font-weight:bold; position:relative;<?php if ( current_user_can('edit_dashboard') ) : ?> padding-right: 55px; <?php endif; ?>">
    <div style="overflow:hidden; text-overflow:ellipsis;">
    <?php $bg_icon = cd_date_diff(); echo $bg_icon['icon']; new_task(); echo ' '; the_title(); ?><?php if ( get_field('formato_da_postagem') ) { echo ' - '; the_field('formato_da_postagem'); } if ( get_field('campanha') ) { echo ' - '; the_field('campanha'); } ?>
    <?php if ( current_user_can('edit_dashboard') ) : ?>
      <?php if (!$texto_luares) : ?><i class="file text icon" style="color: #CCC; position:absolute; right:25px;"></i><?php endif; ?>
      <?php if ($texto_luares['value'] == 'solicitar-texto') : ?><i style="position:absolute; right:25px;" class="red file text icon cd-popup" title="Solicitar texto" data-variation="very wide mini inverted"></i><?php endif; ?>
      <?php if ($texto_luares['value'] == 'texto-solicitado') : ?><i style="position:absolute; right:25px;" class="green file text icon cd-popup" title="Texto solicitado" data-variation="very wide mini inverted"></i><?php endif; ?>
      <?php if (!$imagem_gd) : ?><i class="file image outline icon" style="color: #CCC; position:absolute; right:5px;"></i><?php endif; ?>
      <?php if ($imagem_gd['value'] == 'solicitar-imagem') : ?><i style="position:absolute; right:5px;" class="red file image outline icon cd-popup" title="Solicitar imagem" data-variation="very wide mini inverted"></i><?php endif; ?>
      <?php if ($imagem_gd['value'] == 'imagem-solicitada') : ?><i style="position:absolute; right:5px;" class="green file image outline icon cd-popup" title="Imagem solicitada" data-variation="very wide mini inverted"></i><?php endif; ?>
    <?php endif; ?>
    </div>
  </td>
  <td class="collapsing"><?php $area = get_field('area_divulgacao_tarefa'); if ($area) { echo $area['label']; } ?></td>
  <td class="collapsing data-solicitacao"><?php $data = get_the_date('d/m/y'); echo $data; ?></td>
  <td class="collapsing data-inicio"><?php if ( get_field('data_de_inicio_do_evento') ) { the_field('data_de_inicio_do_evento'); } elseif ( get_field('data_de_inicio_do_curso') ) { the_field('data_de_inicio_do_curso'); } elseif ( get_field('data_inicial') ) { the_field('data_inicial'); } else { echo '<span style="color: rgba(0, 0, 0, 0.4); font-style: italic;">Não disponível</span>'; } ?></td>
  <td class="collapsing data-publicacao"><?php if ( $publicacao && in_array('publicacao', $publicacao) ) the_field('previsao_de_publicacao'); elseif ($finalidade['value'] === "pauta") the_field('previsao_de_publicacao'); else echo '<span style="color: rgba(0, 0, 0, 0.4); font-style: italic;">Sem publicação</span>'; ?></td>
  <td class="collapsing data-previsao"><?php if ( $finalidade['value'] === "pauta" ) { echo '<span style="color: rgba(0, 0, 0, 0.4); font-style: italic;">Não disponível</span>'; } else { the_field('previsao_conclusao'); } ?></td>
  <td class="left aligned collapsing" data-sort-value="<?php if ($responsavel1) echo $responsavel1['display_name'] . ' '; if ($responsavel2) echo $responsavel2['display_name'] . ' '; if ($responsavel3) echo $responsavel3['display_name'] . ' '; if ($responsavel4) echo $responsavel4['display_name'] . ' '; if ($responsavel5) echo $responsavel5['display_name'] . ' ';?>">
		<?php if ($responsavel1) : ?><span class="ui avatar image cd-popup" title="<?php echo $responsavel1['display_name'] ?>" data-variation="very wide mini inverted"><?php echo $responsavel1['user_avatar']; ?></span><?php endif; ?>
		<?php if ($responsavel2) : ?><span class="ui avatar image cd-popup" title="<?php echo $responsavel2['display_name'] ?>" data-variation="very wide mini inverted"><?php echo $responsavel2['user_avatar']; ?></span><?php endif; ?>
    <?php if ($responsavel3) : ?><span class="ui avatar image cd-popup" title="<?php echo $responsavel3['display_name'] ?>" data-variation="very wide mini inverted"><?php echo $responsavel3['user_avatar']; ?></span><?php endif; ?>
    <?php if ($responsavel4) : ?><span class="ui avatar image cd-popup" title="<?php echo $responsavel4['display_name'] ?>" data-variation="very wide mini inverted"><?php echo $responsavel4['user_avatar']; ?></span><?php endif; ?>
    <?php if ($responsavel5) : ?><span class="ui avatar image cd-popup" title="<?php echo $responsavel5['display_name'] ?>" data-variation="very wide mini inverted"><?php echo $responsavel5['user_avatar']; ?></span><?php endif; ?>
  </td>
  <td class="collapsing"><?php num_comentarios(false);?></td>
  <td class="collapsing" style="color:#FFF;"><a class="ui <?= $corStatus ?> label" style="width:100%;"><?php echo $status['label'] ?></a></td>
</tr>
