<?php

$area = get_field('area_divulgacao_tarefa', $post_id);
$finalidade = get_field('finalidade', $post_id);
$modalidade = get_field('modalidade_curso', $post_id);
$publicacao_pecas = get_field('publicacao_pecas', $post_id);
$segmentacao = get_field('segmentacao', $post_id);

// GD2 e GD4

$areas_gd2_gd4 = array(
  'educacao',
  'gestao-negocios',
  'meio-ambiente',
  'saude-bem-estar',
  'sst',
  'tecnologia-informacao',
);

$modalidade_gd2_gd4 = array(
  'curso-livre',
  'extensao',
);

$finalidade_gd2_gd4 = array(
  'devento',
  'outrafinalidade',
);

if ( in_array($area['value'], $areas_gd2_gd4) ) {

  if ( in_array($modalidade['value'], $modalidade_gd2_gd4) || in_array($finalidade['value'], $finalidade_gd2_gd4) ) {

    update_field( 'segmentacao', 'gd2_gd4', $post_id);

    // EVENTO
    if ( $publicacao_pecas && in_array('publicacao', $publicacao_pecas) ) {

      $value = array ('gd2_gd4', 'evento');
      update_field( 'segmentacao', $value, $post_id);

    }

  }

}

// GD1 e GD3

$areas_gd1_gd3 = array(
  'arquitetura-urbanismo',
  'comunicacao-artes',
  'desenvolvimento-social',
  'design',
  'eventos-lazer',
  'gastronomia',
  'hotelaria-turismo',
  'limpeza-conservacao-zeladoria',
  'moda',
);

$modalidade_gd1_gd3 = array(
  'curso-livre',
  'extensao',
);

$finalidade_gd1_gd3 = array(
  'devento',
  'outrafinalidade',
);

if ( in_array($area['value'], $areas_gd1_gd3) ) {

  if ( in_array($modalidade['value'], $modalidade_gd1_gd3) || in_array($finalidade['value'], $finalidade_gd1_gd3) ) {

    update_field( 'segmentacao', 'gd1_gd3', $post_id);

    // EVENTO
    if ( $publicacao_pecas && in_array('publicacao', $publicacao_pecas) ) {

      $value = array ('gd1_gd3', 'evento');
      update_field( 'segmentacao', $value, $post_id);

    }

  }

}

// INSTITUCIONAL

$areas_institucional = array(
  'idiomas',
  'gerencias',
  'campanhas',
  'editora',
  'hoteis',
);

$modalidade_institucional = array(
  'curso-tecnico',
  'pos',
  'vestibular',
  'gratuidade',
  'aprendizagem',
);

$finalidade_institucional = array(
  'dcurso',
  'devento',
  'outrafinalidade',
);

if ( in_array($modalidade['value'], $modalidade_institucional) || ( in_array($area['value'], $areas_institucional) && in_array($finalidade['value'], $finalidade_institucional) ) ) {

    update_field( 'segmentacao', 'institucional', $post_id);

    // EVENTO
    if ( $publicacao_pecas && in_array('publicacao', $publicacao_pecas) ) {

      $value = array ('institucional', 'evento');
      update_field( 'segmentacao', $value, $post_id);

    }

}

// PAUTA

if ( $finalidade && in_array('pauta', $finalidade) ) {

  update_field( 'segmentacao', 'pauta', $post_id);

}

// PORTAL

// if ( ($publicacao_pecas && in_array('publicacao', $publicacao_pecas)) || ($finalidade && in_array('pauta', $finalidade))  ) {
//
//   // Pega os valores já atribuídos acima
//   $value[] = $segmentacao['value'];
//
//   array_push($value, 'evento');
//
//   update_field( 'segmentacao', $value, $post_id);
//
// }

?>
