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
    ?>

  </td>
  <td class="left aligned" style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px; font-weight:bold; position: relative; <?php if ( current_user_can('edit_dashboard') ) : ?> padding-right: 55px; <?php endif; ?>">
    <?php new_task(); echo ' '; the_title(); ?>
    <?php if ( current_user_can('edit_dashboard') ) : ?>
    <span style="position:absolute; right:5px;">
      <?php if (!$texto_luares) : ?><i class="file text icon" style="color: #CCC;"></i><?php endif; ?>
      <?php if ($texto_luares['value'] == 'solicitar-texto') : ?><i class="red file text icon cd-popup" title="Solicitar texto"></i><?php endif; ?>
      <?php if ($texto_luares['value'] == 'texto-solicitado') : ?><i class="green file text icon cd-popup" title="Texto solicitado"></i><?php endif; ?>
      <?php if (!$imagem_gd) : ?><i class="file image outline icon" style="color: #CCC;"></i><?php endif; ?>
      <?php if ($imagem_gd['value'] == 'solicitar-imagem') : ?><i class="red file image outline icon cd-popup" title="Solicitar imagem"></i><?php endif; ?>
      <?php if ($imagem_gd['value'] == 'imagem-solicitada') : ?><i class="green file image outline icon cd-popup" title="Imagem solicitada"></i><?php endif; ?>
    </span>
    <?php endif; ?>
  </td>
  <td class="collapsing"><?php $area = get_field('area_divulgacao_tarefa'); if ($area) { echo $area['label']; } ?></td>
  <td class="collapsing"><?php $data = get_the_date('d/m/y'); echo $data; ?></td>
  <td class="collapsing">
    <?php if ( get_field('data_de_inicio_do_evento') ) { the_field('data_de_inicio_do_evento'); }
    elseif ( get_field('data_de_inicio_do_curso') ) { the_field('data_de_inicio_do_curso'); }
    else { echo '<span style="color: rgba(0, 0, 0, 0.4); font-style: italic;">Não disponível</span>'; } ?>
  </td>
  <td class="collapsing"><?php if ( $publicacao && in_array('publicacao', $publicacao) ) the_field('previsao_de_publicacao'); elseif ($finalidade['value'] === "pauta") the_field('previsao_de_publicacao'); else echo '<span style="color: rgba(0, 0, 0, 0.4); font-style: italic;">Sem publicação</span>'; ?></td>
  <td class="collapsing"><?php if ( $finalidade['value'] === "pauta" ) { echo '<span style="color: rgba(0, 0, 0, 0.4); font-style: italic;">Não disponível</span>'; } else { the_field('previsao_conclusao'); } ?></td>
  <td class="left aligned collapsing">
		<?php if ($responsavel1) : ?><span class="ui avatar image" data-tooltip="<?php echo $responsavel1['display_name'] ?>"><?php echo $responsavel1['user_avatar']; ?></span><?php endif; ?>
		<?php if ($responsavel2) : ?><span class="ui avatar image" data-tooltip="<?php echo $responsavel2['display_name'] ?>"><?php echo $responsavel2['user_avatar']; ?></span><?php endif; ?>
    <?php if ($responsavel3) : ?><span class="ui avatar image" data-tooltip="<?php echo $responsavel3['display_name'] ?>"><?php echo $responsavel3['user_avatar']; ?></span><?php endif; ?>
    <?php if ($responsavel4) : ?><span class="ui avatar image" data-tooltip="<?php echo $responsavel4['display_name'] ?>"><?php echo $responsavel4['user_avatar']; ?></span><?php endif; ?>
  </td>
  <td class="collapsing"><?php num_comentarios(false);?></td>
  <td class="collapsing" style="color:#FFF;"><a class="ui <?= $corStatus ?> label" style="width:100%;"><?php echo $status['label'] ?></a></td>
</tr>
