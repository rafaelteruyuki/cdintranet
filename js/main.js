
// jQuery( document ).ready( function( $ ) {

// Menu
$('.ui.dropdown.item')
	.dropdown({
    on: 'click'
  })
;

// Barra status
$('#example1').progress();

// Tabela classificação

var table = $("table").stupidtable();

function change_date_format(classe) {
  $(classe).each(function( index, element ) {
    var date = $(element).html();
    if ( date.match(/[0-9][0-9]\/[0-9][0-9]\/[0-9][0-9]/) ) {
      var newdate = date.split("/").reverse().join("");
      $(element).updateSortVal(newdate); // update cache stupid table
    } else if (!date) {
      $(element).updateSortVal('111' + index); // update cache stupid table
    } else {
			$(element).updateSortVal('112' + index); // update cache stupid table
		}
  });
}
change_date_format('.data-solicitacao');
change_date_format('.data-inicio');
change_date_format('.data-publicacao');
change_date_format('.data-previsao');

// table.on("beforetablesort", function (event, data) {
//   // Apply a "disabled" look to the table while sorting.
//   $("tr").addClass("disabled");
// });

table.on("aftertablesort", function (event, data) {
  // Reset loading message.
  // $("tr").removeClass("disabled");

  var th = $(this).find("th");
  th.find(".arrow").remove();
  var dir = $.fn.stupidtable.dir;

  var arrow = data.direction === dir.ASC ? "&uarr;" : "&darr;";
  th.eq(data.column).append('<span class="arrow"> ' + arrow +'</span>');
});

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

$('.eyedropper-tip')
  .popup({
    inline     : false,
    hoverable  : false,
    position   : 'top center',
		on    : 'click',
    // delay: {
    //   show: 800,
		// 	hide: 800,
    // }
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
