<?php

$percent;
$corStatus;

$responsavel1 = get_field('responsavel_1');
$responsavel2 = get_field('responsavel_2');
$responsavel3 = get_field('responsavel_portal');
$responsavel4 = get_field('responsavel_portal_2');

$finalidade = get_field('finalidade');
$modalidade = get_field('modalidade_curso');
$tipo_de_evento = get_field('tipo_de_evento');
$status = get_field('status');
$publicacao = get_field('publicacao_pecas');
$texto_luares = get_field('texto_luares');
$imagem_gd = get_field('imagem_gd');

$imagem_capa = get_field('imagem_capa');
$imagem_miniatura = get_field('imagem_miniatura');
$imagem_rodape = get_field('imagem_rodape');
$imagem_lateral = get_field('imagem_lateral');


$modificado = get_the_modified_time('dmYGis');
$atual = date( 'd/m/Y G:i', current_time( 'timestamp', 0 ) );

 ?>
