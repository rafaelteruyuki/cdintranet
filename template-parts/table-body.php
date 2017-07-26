<?php

// VARIAVEIS TAREFAS
include ( locate_template('template-parts/var-tarefas.php') );

// NOVA TAREFA
global $current_user;
    while ( have_rows('visitas') ) : the_row();
        $usuario_registrado[] = get_sub_field('usuario');
        $acesso_registrado[] = get_sub_field('acesso');
    endwhile;

  // Procura o usuário no array de usuários registrados
  if ( !in_array($current_user->user_login, $usuario_registrado) ) {
    $new_task_label = '<span class="ui blue mini label">Nova</span>';
    $new_task_bg = 'background:#ebf7ff;';
  }

?>

<tr class="center aligned cd-tarefa" style="cursor:pointer; <?= $new_task_bg ?>" onclick="window.open('<?php the_permalink(); ?>');" >
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
    } ?>

  </td>
  <td class="left aligned">
    <?= $new_task_label ?>
    <strong><?php the_title(); ?></strong>
    <?php if ( !current_user_can('portal') ) : ?>
    <span style="float:right">
      <?php if (!$texto_luares) : ?><i class="file text icon" style="float:right; color: #CCC;"></i><?php endif; ?>
      <?php if ($texto_luares['value'] == 'solicitar-texto') : ?><i class="red file text icon cd-popup" title="Solicitar texto" style="float:right;"></i><?php endif; ?>
      <?php if ($texto_luares['value'] == 'texto-solicitado') : ?><i class="green file text icon cd-popup" title="Texto solicitado" style="float:right;"></i><?php endif; ?>
      <?php if (!$imagem_gd) : ?><i class="file image outline icon" style="float:right; color: #CCC;"></i><?php endif; ?>
      <?php if ($imagem_gd['value'] == 'solicitar-imagem') : ?><i class="red file image outline icon cd-popup" title="Solicitar imagem" style="float:right;"></i><?php endif; ?>
      <?php if ($imagem_gd['value'] == 'imagem-solicitada') : ?><i class="green file image outline icon cd-popup" title="Imagem solicitada" style="float:right;"></i><?php endif; ?>
    </span>
    <?php endif; ?>
  </td>
  <td class="collapsing"><?php the_field('area_divulgacao_tarefa'); ?></td>
  <td class="collapsing"><?php $data = get_the_date('d/m/y'); echo $data; ?></td>
  <td class="collapsing"><?php if ( get_field('data_de_inicio_do_evento') ) { the_field('data_de_inicio_do_evento'); } else { echo '<span style="color: rgba(0, 0, 0, 0.4); font-style: italic;">Não disponível</span>'; } ?></td>
  <td class="collapsing"><?php if ( $publicacao && in_array('publicacao', $publicacao) ) the_field('previsao_de_publicacao'); else echo '<span style="color: rgba(0, 0, 0, 0.4); font-style: italic;">Sem publicação</span>'; ?></td>
  <td class="collapsing"><?php the_field('previsao_conclusao'); ?></td>
  <td class="left aligned collapsing">
		<?php if ($responsavel1) : ?><span class="ui avatar image" data-tooltip="<?php echo $responsavel1['display_name'] ?>"><?php echo $responsavel1['user_avatar']; ?></span><?php endif; ?>
		<?php if ($responsavel2) : ?><span class="ui avatar image" data-tooltip="<?php echo $responsavel2['display_name'] ?>"><?php echo $responsavel2['user_avatar']; ?></span><?php endif; ?>
    <?php if ($responsavel3) : ?><span class="ui avatar image" data-tooltip="<?php echo $responsavel3['display_name'] ?>"><?php echo $responsavel3['user_avatar']; ?></span><?php endif; ?>
    <?php if ($responsavel4) : ?><span class="ui avatar image" data-tooltip="<?php echo $responsavel4['display_name'] ?>"><?php echo $responsavel4['user_avatar']; ?></span><?php endif; ?>
  </td>
  <td class="collapsing"><?php $num_comments = get_comments_number(); if ( $num_comments == 0 ) echo '0'; else echo $num_comments; ?></td>
  <td class="collapsing" style="color:#FFF;"><a class="ui <?= $corStatus ?> label" style="width:100%;"><?php echo $status['label'] ?></a></td>
</tr>
