
// CHECA O USUARIO LOGADO

$.post(
  ajaxurl,
  {action: 'usuario_logado'},
  function(response) {

    if (response == 'edit_pages') {
      contador();
      setInterval(notificacao_new_task_push_ajax, 120000);
      setInterval(feed_refresh, 120000);
      // feed_refresh();
    } else if (response == 'senac') {
      contador();
      setInterval(feed_refresh, 120000);
    }

  }

);

// LOCAL STORAGE CHANGE EVENT

$(window).bind('storage', function(e) {

  // Esconde a notificação new task em todas as abas
  if (localStorage.getItem("newtask") == 'hide') {
    $(".cd-push").animate({right: '-400px'});
  }

  // Atualiza o feed de comentários em todas as abas se houver mudança no número de notificações
  var local_contador = localStorage.getItem("contador");
  if (local_contador != local_contador_old) {
    feed_refresh();
  }
  var local_contador_old = local_contador;

});

// NEW TASK PUSH

var naoLido_old;

function notificacao_new_task_push_ajax() {

  $.post(
    ajaxurl,
    {action: 'new_task_push'},

    function(response) {

    var naoLido = 0;
    naoLido = response;

    // alert(naoLido + ' - ' + naoLido_old);

    if (naoLido_old < naoLido) {
      $(".cd-push").hide();
      $(".cd-push").html( '<div class="ui blue message"><i class="close icon"></i><div class="header"><i class="blue info circle icon"></i> <a href="http://cd.intranet.sp.senac.br/minhas-tarefas/">Você tem novas tarefas</a></div></div>' );
      $(".cd-push").show();
      localStorage.setItem("newtask", 'show');
      $(".cd-push").animate({right: '20px'});
      $(".close, .cd-push a").click(function(){
          $(".cd-push").animate({right: '-400px'});
          localStorage.setItem("newtask", 'hide');
      });
    }

    naoLido_old = naoLido;

    }

  );

}

// FEED REFRESH

function feed_refresh() {

  $.ajax({
      url: ajaxurl,
      method: 'POST',
      data: {action: 'carrega_loop'},

      beforeSend: function(response) {
        $('.contador').html('<i class="loading refresh icon" style="margin:0;"></i>').removeClass("green").removeClass("red");
      },

      success: function(response) {
       $('#refresh').html(response);
       contador();
       // naoLido = $('#refresh .feed-nao-lido').length;
      }
  });

}

// CONTADOR

function contador() {
  var naoLido = 0;
  naoLido = $('#num_nao_lidas').html(); // Valor de num_nao_lidas vem da contagem do comment-feed.php
  localStorage.setItem("contador", naoLido);
  if (naoLido <= 30 && naoLido  >= 1){
    $('.contador').html(naoLido);
    $('.contador').addClass("red");
    $('.title-contador').html('(' + naoLido + ') ' + cd_title);
    $('#interacoes-nao-lidas').show();
  } else if (naoLido == 0) {
    $('.contador').html('<i class="check icon" style="margin:0;"></i>');
    $('.contador').addClass("green");
    $('.title-contador').html(cd_title);
  } else if (naoLido > 30) {
    $('.contador').html("30+");
    $('.contador').addClass("red");
    $('.title-contador').html('(30+) ' + cd_title);
    $('#interacoes-nao-lidas').show();
  }
}

// function feed_refresh() {
//
//   // FEED REFRESH
//
//   $.ajax({
//       method: 'POST',
//       url: ajaxurl,
//       data: {action: 'carrega_loop'},
//
//       // beforeSend: function(response) {
//       //   $('.contador').removeClass("green");
//       //   $('.contador').removeClass("red");
//       //   $('.contador').html('<i class="loading refresh icon" style="margin:0;"></i>');
//       // },
//
//       success: function(response) {
//
//       var feedRefresh = $.parseJSON(response);
//
//       console.log(feedRefresh);
//
//        $('#refresh').html(feedRefresh['loop']);
//
//        var naoLido = 0;
//        // naoLido = $('#refresh .feed-nao-lido').length;
//        naoLido = feedRefresh['num_nao_lidas']; // Valor de num_nao_lidas vem da contagem do comment-feed.php
//
//        if (naoLido <= 30 && naoLido  >= 1){
//          $('.contador').html(naoLido);
//          $('.contador').addClass("red");
//          $('.title-contador').html('(' + naoLido + ') ' + cd_title);
//        } else if (naoLido == 0) {
//          $('.contador').html('<i class="check icon" style="margin:0;"></i>');
//          $('.contador').addClass("green");
//          $('.title-contador').html(cd_title);
//        } else if (naoLido > 30) {
//          $('.contador').html("30+");
//          $('.contador').addClass("red");
//          $('.title-contador').html('(30+) ' + cd_title);
//        }
//
//       }
//   });
//
//   // $('#refresh').load('http://localhost:8888/cdintranet/wp-content/themes/comunicacao-digital/feed-refresh.php');
//   // $('.refresh').addClass("loading");
//
//
// }




// setInterval(feed_refresh, 5000);
//
// function feed_refresh() {
//
//   $.post(
//     ajaxurl,
//     {action: 'verifica_atualizacao'},
//     function(response) {
//       if(response == '1') {
//
//         $('#refresh').load('<?php echo bloginfo('template_url')?>/feed-refresh.php');
//         $('.refresh').addClass("loading");
//
//         // // FEED REFRESH - OUTRO METODO
//         // jQuery.post({
//         //     url: ajaxurl,
//         //     data: {action: 'carrega_loop'},
//         //     success: function(response) {
//         //      $('#refresh').html(response);
//         //     }
//         // });
//
//         // Aguarda as requisições AJAX terminarem para realizar a contagem
//         $(document).ajaxStop(function() {
//
//         // CONTADOR FEED
//
//         var naoLido = 0;
//         naoLido = $('#refresh .feed-nao-lido').length;
//
//           $('.refresh').removeClass("loading");
//           $('.contador').removeClass("green");
//           $('.contador').removeClass("yellow");
//           $('.contador').removeClass("red");
//           $('.contador').empty();
//
//           if (naoLido <= 30 && naoLido  >= 1){
//             $('.contador').html(naoLido);
//             $('.contador').addClass("floating red ui label");
//             $('.title-contador').html('(' + naoLido + ') ' + cd_title);
//           } else if (naoLido == 0) {
//             $('.contador').html('<i class="check icon" style="margin:0;"></i>');
//             $('.contador').addClass("floating green ui label");
//             $('.title-contador').html(cd_title);
//           } else if (naoLido > 30) {
//             $('.contador').html("30+");
//             $('.contador').addClass("floating red ui label");
//             $('.title-contador').html('(30+) ' + cd_title);
//           }
//
//         // CD NOTIFICAÇAO PUSH
//
//         if (naoLido_old < naoLido) {
//           $(".cd-push").hide();
//         	$(".cd-push").html( '<div class="ui message"><i class="close icon"></i><div class="header"><i class="green refresh icon"></i> Você tem novas notificações</div></div>' );
//           $(".cd-push").show();
//           $(".cd-push").animate({right: '20px'});
//           $(".close").click(function(){
//               $(".cd-push").animate({right: '-400px'});
//           });
//         };
//
//         naoLido_old = naoLido;
//
//         $(this).unbind('ajaxStop');
//
//         });
//       }
//     }
//   );
//
//
//
//   Previne se o usuário for deslogado, suas notificações somem e aparece o botão de login. Função no functions.
// $.post(
//     ajaxurl,
//     {action: 'is_user_logged_in'},
//     function(response) {
//       if(response == 'no') {
//         location.reload(); // recarrega a página
//       }
//     }
//   );
//
// };
