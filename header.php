<!doctype html>
<html lang="pt-br">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title class="title-contador"><?php if(is_home()) { echo bloginfo("name"); echo " | "; echo bloginfo("description"); } else { echo wp_title(" | ", false, right); echo bloginfo("name"); } ?></title>

<!--<link rel="shortcut icon" href="front_assets/images/icon.ico">-->

<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/semantic.min.css">

<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/semantic.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/tablesort.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/mustache.js"></script>

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php lido_nao_lido_single(); // LIDO / NAO LIDO / REGISTRA NA SINGLE ?>

<style>

  /*SIDEBAR FILTROS*/
  .sidebar .searchandfilter ul li h4 {
    font-size: 14px;
  }
  .sidebar .searchandfilter ul li ul {
    padding-left: 0;
  }
  .searchandfilter select.sf-input-select {
    border: 1px solid #CCC;
    height: 2em;
    border-radius: 5px;
    padding: 5px 1em;
  }

  /* FEED TAREFAS */
  /*.ui.menu .ui.dropdown .menu>.item.feed-lido {
    display: none!important;
  }*/
  .ui.menu .ui.dropdown .menu>.item.feed-nao-lido {
    background-color: #ebf7ff !important;
  }
  .ui.menu .ui.dropdown .menu>.item.feed-nao-lido:hover {
    background-color: #dfecf5 !important;
  }
  .ui.scrolling.dropdown .menu {
      max-height: 35rem !important;
  }
  .ui.scrolling.dropdown .menu {
      max-width: 480px !important;
  }
  /*.ui.menu .ui.dropdown .menu>.item.cd-feed .icon {
    margin: 0 4px 0 0;
  }*/

  .cd-disabled {
    color: rgba(0, 0, 0, 0.4);
    line-height: 1.5;
  }

  /* LIDA / NAO LIDA */
  .cd-nao-lida {
    color: #2185d0 !important;
  }

  .cd-push {
    position: absolute;
    right: -400px;
    width: 400px;
    margin-top: 20px;
    z-index: 100;
  }

</style>

<!-- SIDEBAR FILTROS -->

<div class="ui wide sidebar vertical menu tarefas">
  <div class="ui hidden divider"></div>
  <h3 style="margin-left: 40px;">Filtros</h3>
  <?php
    if ( is_page( 946 ) ) {
      // echo 'Filtros Minhas Tarefas' . '<br>';
      echo do_shortcode( '[searchandfilter id="2817"]' );
    };
    if ( is_page( 951 ) ) {
      // echo 'Filtros Minhas Solicitacoes' . '<br>';
      echo do_shortcode( '[searchandfilter id="12379"]' );
    };
    if ( is_post_type_archive('tarefa') ) {
      // echo 'Filtros Todas as Tarefas' . '<br>';
      echo do_shortcode( '[searchandfilter id="4806"]' );
    };
  ?>
  <a data-tooltip="Voltar" class="ui icon cd-filtro button tarefas" style="margin: 20px 0 0 40px;">
	<i class="arrow left icon"></i>
  </a>
</div>

<!-- <div class="ui wide sidebar inverted vertical menu cursos">
  <div class="ui hidden divider"></div>
  <?php // echo do_shortcode( '[searchandfilter id="2182"]' ); ?>
  <a data-tooltip="Voltar" class="ui icon cd-filtro button cursos" style="margin: 20px 0 0 40px;">
	<i class="arrow left icon"></i>
  </a>
</div> -->

<!-- PUSHER SIDEBAR -->

<div class="pusher">

<!-- HEADER -->

<div class="ui inverted vertical segment">
  <div class="ui two column grid container stackable" style="margin:2em 0">
    <div class="middle aligned column">
      <a href="<?php bloginfo("url");?>">
        <h1 class="ui header inverted">Comunicação Digital
          <div class="sub header inverted">Gerência de Comunicação e Relações Institucionais</div>
        </h1>
      </a>
    </div>
    <div class="right aligned column">
      <img src="<?php bloginfo('template_url'); ?>/images/logo-senac-branco.png" width="130">
    </div>
  </div>
</div>

<!-- MENU -->

<div class="ui attached stackable inverted menu" style="border: 1px solid rgba(255, 255, 255, 0.1);">
  <div class="ui container" style="border-left:1px solid rgba(255, 255, 255, 0.1); border-right:1px solid rgba(255, 255, 255, 0.1)">

    <a href="<?php bloginfo( 'url' ); ?>" class="item"><i class="grid layout icon"></i> Catálogo de Cursos</a>
    <a href="<?php bloginfo( 'url' ); ?>/solicitacao/" class="item"><i class="edit icon"></i>Nova solicitação</a>
    <a href="<?php bloginfo( 'url' ); ?>/redes-sociais/" class="item"><i class="globe icon"></i> Redes Sociais</a>

    <!-- <div class="ui dropdown item">
        <i class="edit icon"></i>Solicitações
        <i class="dropdown icon"></i>
        <div class="menu">
          <a href="<?php // bloginfo( 'url' ); ?>/solicitacao/" class="item"><i class="edit icon"></i>Nova</a>
        </div>
    </div> -->

    <div class="right menu">

      <?php global $current_user; ?>

      <!--BOTAO LOGIN-->
      <?php if ( !is_user_logged_in() ) : ?>
      <a href="<?php echo wp_login_url(get_permalink()); ?>" class="item cd-login"><i class="sign in icon"></i> Login</a>
      <?php endif; ?>

      <!--LOGIN-->
      <?php if ( is_user_logged_in() ) : ?>
        <div class="ui dropdown item cd-user-logado">
          <span class="ui mini rounded image"><?php echo get_avatar( $current_user->ID, 24 ); ?></span><?php echo $current_user->display_name ?>
          <i class="dropdown icon"></i>
          <div class="menu">
            <!--LOGIN DESIGNER E ADMIN-->
            <?php if ( current_user_can( 'edit_pages' ) ) : ?>
            <a href="<?php bloginfo( 'url' ); ?>/wp-admin/post-new.php?post_type=curso" class="item"><i class="block layout icon"></i>Novo Curso</a>
            <a href="<?php bloginfo( 'url' ); ?>/minhas-tarefas/" class="item"><i class="list layout icon"></i>Minhas tarefas</a>
            <a href="<?php bloginfo( 'url' ); ?>/tarefa/" class="item"><i class="list icon"></i>Todas as tarefas</a>
            <a href="<?php bloginfo( 'url' ); ?>/notificacoes-por-e-mail/" class="item"><i class="mail square icon"></i>Notificações por e-mail</a>
            <?php endif; ?>
            <?php if ( current_user_can( 'portal' ) ) : ?>
            <a href="<?php bloginfo( 'url' ); ?>/exportar-tarefas/" class="item"><i class="download icon"></i>Exportar tarefas</a>
            <?php endif; ?>
            <!--LOGIN OUTROS-->
            <?php if ( current_user_can( 'senac' ) ) : ?>
            <a href="<?php bloginfo( 'url' ); ?>/minhas-solicitacoes/" class="item"><i class="list layout icon"></i>Minhas solicitações</a>
            <a href="<?php bloginfo( 'url' ); ?>/notificacoes-por-e-mail/" class="item"><i class="mail square icon"></i>Notificações por e-mail</a>
            <?php endif; ?>
            <a href="<?php echo wp_logout_url( home_url() ); ?>" class="item"><i class="sign out icon"></i>Sair</a>
          </div>
        </div>
      <?php endif; ?>

      <!-- CD-FEED -->
      <?php if ( is_user_logged_in() ) : ?>
      <div class="ui scrolling dropdown item cd-user-logado">
        <i class="comment icon" style="margin:0;"></i>
        <i class="info circle icon" style="margin:0 0 0 10px;"></i>
        <!-- <i class="comments icon" style="margin:0;"></i> -->
        <div class="contador"></div>
        <div class="menu" id="refresh">
          <?php echo '<a href="' . get_site_url() . '/minhas-tarefas/" class="item" style="padding: 15px !important;" onclick="notificacao_new_task();"><i class="blue info circle icon"></i><strong>Você tem novas solicitações.' . $array_acesso_registrado[$key] . '</strong></a>';
          notificacao_new_task(); ?>
          <?php get_template_part('comment','feed') ?>
        </div>
      </div>
      <?php endif; ?>

    </div>

  </div>
</div>

<script type="text/javascript">

var naoLido_old;
var cd_title = '<?php if(is_home()) { echo bloginfo("name"); echo " | "; echo bloginfo("description"); } else { echo wp_title(" | ", false, right); echo bloginfo("name"); } ?>';
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>"; //Define o endereço AJAX

<?php // if ( is_user_logged_in() ) : ?>

<?php // update_field( 'field_595feb818431d', true,'user_' . $current_user->ID); // Atualizar feed == checked ?>

feed_refresh();

setInterval(feed_refresh, 5000);

function feed_refresh() {

  $.post(
    ajaxurl,
    {action: 'verifica_atualizacao'},
    function(response) {
      if(response == '1') {

        $('#refresh').load('<?php echo bloginfo('template_url')?>/feed-refresh.php');
        $('.refresh').addClass("loading");

        // // FEED REFRESH - OUTRO METODO
        // jQuery.post({
        //     url: ajaxurl,
        //     data: {action: 'carrega_loop'},
        //     success: function(response) {
        //      $('#refresh').html(response);
        //     }
        // });

        // Aguarda as requisições AJAX terminarem para realizar a contagem
        $(document).ajaxStop(function() {

        // CONTADOR FEED

        var naoLido = 0;
        naoLido = $('#refresh .feed-nao-lido').length;

          $('.refresh').removeClass("loading");
          $('.contador').removeClass("green");
          $('.contador').removeClass("yellow");
          $('.contador').removeClass("red");
          $('.contador').empty();

          if (naoLido <= 30 && naoLido  >= 1){
            $('.contador').html(naoLido);
            $('.contador').addClass("floating red ui label");
            $('.title-contador').html('(' + naoLido + ') ' + cd_title);
          } else if (naoLido == 0) {
            $('.contador').html('<i class="check icon" style="margin:0;"></i>');
            $('.contador').addClass("floating green ui label");
            $('.title-contador').html(cd_title);
          } else if (naoLido > 30) {
            $('.contador').html("30+");
            $('.contador').addClass("floating red ui label");
            $('.title-contador').html('(30+) ' + cd_title);
          }

        // CD NOTIFICAÇAO PUSH

        if (naoLido_old < naoLido) {
          $(".cd-push").hide();
        	$(".cd-push").html( '<div class="ui message"><i class="close icon"></i><div class="header"><i class="green refresh icon"></i> Você tem novas notificações</div></div>' );
          $(".cd-push").show();
          $(".cd-push").animate({right: '20px'});
          $(".close").click(function(){
              $(".cd-push").animate({right: '-400px'});
          });
        };

        naoLido_old = naoLido;

        $(this).unbind('ajaxStop');

        });
      }
    }
  );

  // Previne se o usuário for deslogado, suas notificações somem e aparece o botão de login. Função no functions.

  $.post(
    ajaxurl,
    {action: 'is_user_logged_in'},
    function(response) {
      if(response == 'no') {
        location.reload(); // recarrega a página
      }
    }
  );

};

<?php // else : ?>

// $(".cd-push").hide();
// $('.title-contador').html(cd_title);

<?php // endif; ?>




<?php if ( is_user_logged_in() ) : ?>

feed_refresh();

// function feed_refresh() {
//
//   // CONTADOR FEED
//
//   var naoLido = 0;
//   naoLido = $('#refresh .feed-nao-lido').length;
//
//     $('.contador').removeClass("green");
//     $('.contador').removeClass("yellow");
//     $('.contador').removeClass("red");
//     $('.contador').empty();
//
//     if (naoLido <= 30 && naoLido  >= 1){
//       $('.contador').html(naoLido);
//       $('.contador').addClass("floating red ui label");
//       $('.title-contador').html('(' + naoLido + ') ' + cd_title);
//     } else if (naoLido == 0) {
//       $('.contador').html('<i class="check icon" style="margin:0;"></i>');
//       $('.contador').addClass("floating green ui label");
//       $('.title-contador').html(cd_title);
//     } else if (naoLido > 30) {
//       $('.contador').html("30+");
//       $('.contador').addClass("floating red ui label");
//       $('.title-contador').html('(30+) ' + cd_title);
//     }
//
// };

<?php endif; ?>

</script>

<div class="cd-push"></div>
