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

$count_naoiniciado = get_post_count_by_meta('status', 'naoiniciado', 'tarefa');
$count_cancelado = get_post_count_by_meta('status', 'cancelado', 'tarefa');
$count_incompleto = get_post_count_by_meta('status', 'incompleto', 'tarefa');
$count_aguardando = get_post_count_by_meta('status', 'aguardandoinformacao', 'tarefa');
$count_emproducao = get_post_count_by_meta('status', 'emproducao', 'tarefa');
$count_publicado = get_post_count_by_meta('status', 'publicado', 'tarefa');
$count_finalizado = get_post_count_by_meta('status', 'finalizado', 'tarefa');

$modificado = get_the_modified_time('dmYGis');
$atual = date( 'd/m/Y G:i', current_time( 'timestamp', 0 ) );

switch ($status['value']) {
    case "naoiniciado":
        $percent = 0;
        $corStatus = '';
        break;
    case "cancelado":
        $percent = 0;
        $corStatus = 'grey';
        break;
    case "incompleto":
        $percent = 15;
        $corStatus = 'red';
        break;
    case "aguardandoinformacao":
        $percent = 35;
        $corStatus = 'orange';
        break;
    case "emproducao":
        $percent = 50;
        $corStatus = 'yellow';
        break;
    case "fluxors":
        $percent = 50;
        $corStatus = 'yellow';
        break;
    case "fluxoportal":
        $percent = 50;
        $corStatus = 'yellow';
        break;
    case "publicado":
        $percent = 70;
        $corStatus = 'olive';
        break;
    case "finalizado":
        $percent = 100;
        $corStatus = 'green';
        break;
}

 ?>
