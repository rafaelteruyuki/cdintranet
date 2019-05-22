<?php

$percent;
$corStatus;

$responsavel1 = get_field('responsavel_1');
$responsavel2 = get_field('responsavel_2');
$responsavel3 = get_field('responsavel_portal');
$responsavel4 = get_field('responsavel_portal_2');
$responsavel5 = get_field('responsavel_rs');

$responsaveis_atendimento = get_field('atendimento');
$responsaveis_design = get_field('design');
$responsaveis_aimprensa = get_field('aimprensa');
$responsaveis_curadoria = get_field('curadoria');
$responsaveis_redacao = get_field('redacao');
$responsaveis_imagem_institucional = get_field('imagem_institucional');
$responsaveis_tecnologia_e_bi = get_field('tecnologia_e_bi');
$responsaveis_redes_sociais = get_field('redes_sociais');

$prazo_atendimento = get_field('prazo_atendimento');
$prazo_design = get_field('prazo_design');
$prazo_aimprensa = get_field('prazo_aimprensa');
$prazo_curadoria = get_field('prazo_curadoria');
$prazo_redacao = get_field('prazo_redacao');
$prazo_imagem_institucional = get_field('prazo_imagem_institucional');
$prazo_tecnologia_e_bi = get_field('prazo_tecnologia_e_bi');
$prazo_redes_sociais = get_field('prazo_redes_sociais');
$campanha = get_field('campanha');
$investimento = get_field('investimento');

$finalidade = get_field('finalidade');
$modalidade = get_field('modalidade_curso');
$tipo_de_evento = get_field('tipo_de_evento');
$status = get_field('status');
$publicacao = get_field('publicacao_pecas');
$texto_luares = get_field('texto_luares');
$imagem_gd = get_field('imagem_gd');
$participantes = get_field('participante');

$imagem_capa = get_field('imagem_capa');
$imagem_miniatura = get_field('imagem_miniatura');
$imagem_rodape = get_field('imagem_rodape');
$imagem_lateral = get_field('imagem_lateral');

$modificado = get_the_modified_time('dmYGis');
$atual = date( 'd/m/Y G:i', current_time( 'timestamp', 0 ) );

switch ($status['value']) {
    case "naoiniciado":
        $percent = 0;
        $corStatus = '';
        break;
    case "cancelado":
        $percent = 2;
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
    case "producaogcr":
        $percent = 50;
        $corStatus = 'yellow';
        break;
    case "producaounidade":
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
