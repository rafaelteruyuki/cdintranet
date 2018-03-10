
// jQuery( document ).ready( function( $ ) {

// Menu
$('.ui.dropdown.item')
	.dropdown({
    on: 'hover'
  })
;

// Barra status
$('#example1').progress();

// Tabela classificação
$('table').tablesort();

// Botões Filtro Catálogo
$('.combo.dropdown')
  .dropdown({
    action: 'combo'
  })
;


// Fade right imagem
$('.imagem-single-curso')
  .transition('hide')
  .transition({
    animation : 'fade in',
    duration  : 600,
  })
;

// SIDEBAR SCRIPTS
$('.ui.sidebar.tarefas')
 	.sidebar('attach events', '.cd-filtro.button.tarefas')
	.sidebar('setting', 'transition', 'overlay')
;
$('.cd-filtro.button.tarefas')
  .removeClass('disabled')
;
$('.ui.sidebar.cursos')
 	.sidebar('attach events', '.cd-filtro.button.cursos')
	.sidebar('setting', 'transition', 'overlay')
;
$('.cd-filtro.button.cursos')
  .removeClass('disabled')
;


// POPUP
$('.cd-popup')
  .popup({
    inline     : true,
    hoverable  : true,
    position   : 'top center',
  })
;

// TABS
$('.menu .item')
  .tab()
;

$('.cd-tab .item')
  .tab()
;

$('.form-solicitacao button').addClass('ui secondary button');

//$('.hide-if-value p').html($('.hide-if-value p').html().replace('Nenhum arquivo selecionado ','')); //remove "Nenhum arquivo selecionado" no Form front-end

// Reveal Itens Catálogo
// $('.card')
//   .transition('hide')
//   .transition({
//     animation : 'scale in',
//     interval  : 50,
//     duration  : 200,
//   })
// ;

// Hover Itens Catálogo
//$('.card .image').dimmer({
//  on: 'hover'
//});

$('.acf-field-58f4c987e479e .acf-input').append( $('#acf-_post_title') ); //Inserir título WP em lugar específico do Form front-end
//$('.acf-field-58f4c987e479e .acf-input').append( $('#titlewrap') ); //Inserir título
//$('.button-large, .acf-button, .button').removeClass('button-large acf-button button').addClass('ui primary button'); //muda a classe do botão Adicionar Arquivo no Form front-end
//$('.hide-if-value p').html($('.hide-if-value p').html().replace('Nenhum arquivo selecionado ','')); //remove "Nenhum arquivo selecionado" no Form front-end
//$('.button').text("Teste");

$('.cd-delete.modal')
  .modal('attach events', '.cd-delete-btn', 'show')
  .modal('attach events', '.cd-cancel-btn', 'hide')
;

// });
