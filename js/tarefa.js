
$('.participar').click(function (){

  var post_id = $(this).data('id');
  var current_user_name = $(this).data('username');

  // REMOVE O PRIMEIRO EVENTO (CLICK), PARA NAO INTERFERIR NO PROXIMO AJAX
  $('.participar').unbind("click")

  $.ajax({
      method: 'POST',
      url: ajaxurl,
      data: {
        action: 'participante',
        post_id : post_id,
      },

      beforeSend: function() {
        $('.participar').html('Carregando...');
      },

      success: function(response) {

        // PARTICIPAR
        if (response == 'yes') {
          $('.participar').html('<i class="ui check icon"></i>Participando').removeClass('blue').addClass('green');
          $('#novo-participante').html(current_user_name + '<br>');
        }

        // JA É PARTICIPANTE, DESEJA SAIR?
        if (response == 'participante') {
          $('.participar').removeClass('blue').addClass('orange').html('Você já é participante. Deseja sair?').click(function(){

            // REMOVE O SEGUNDO EVENTO (CLICK), PARA IMPEDIR DE CLICAR NOVAMENTE
            $('.participar').unbind("click")

            $.ajax({
              method: 'POST',
              url: ajaxurl,
              data: {
                action: 'participante',
                post_id : post_id,
                sair : true,
              },
              beforeSend: function() {
                $('.participar').html('Saindo...');
              },
              success: function() {
                $('.participar').html('Você saiu').removeClass('blue').addClass('grey').unbind("click");
                $('.participantes:contains(' + current_user_name + ')').each(function(){
                    $(this).html($(this).html().split(current_user_name + '<br>').join(""));
                });
              }
            });
          });
        }

        // JA É AUTOR
        if (response == 'author') $('.participar').removeClass('blue').addClass('orange').html('Você já é o autor desta solicitação');

      }
  });
});

// Scroll to top button

$('.topo').on('click', function() {
    $('html, body').animate({
        scrollTop: $("#cd-header").offset().top
    }, 700, 'swing');

});

$(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
    $('.topo').fadeIn();
  } else {
    $('.topo').fadeOut();
  }
});

// // Smooth scroll to comment and highlight

$(function(){

  if ($('.comment.clicked').html()) {

    $('html, body').animate({
        scrollTop: $('.comment.clicked').offset().top - 300
    }, 700, 'swing');

    $('.comment.clicked').addClass('highlight');
    setTimeout(function() {
      $('.comment.clicked').addClass('no-highlight');
    }, 2000);

    // Limpa o parametro da URL
    var url = window.location.href;
    var url_no_parameter = url.split('?')[0];
    window.history.replaceState({}, document.title, url_no_parameter);

  }

});


$('#investimento input').mask("#.##0,00", {reverse: true});


function downloadInnerHtml(filename, elClass, mimeType) {

    var elHtml = document.querySelectorAll(elClass);

        var newHTML = '';

        elHtml.forEach(function(element, index) {

            newHTML = newHTML + element.innerText + '\n';

        });

    var link = document.createElement('a');
    mimeType = mimeType || 'text/plain';

    console.log(newHTML);

    document.body.append(link)
    link.setAttribute('download', filename);
    link.setAttribute('href', 'data:' + mimeType + ';charset=utf-8,' + encodeURIComponent(newHTML));
    link.click();
}

var fileName =  'patrocinio.txt';

$('#downloadLink').click(function(){
    downloadInnerHtml(fileName, '.download-txt','text/plain');
});
