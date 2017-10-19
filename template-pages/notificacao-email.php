<?php

/*
Template Name: Notificação E-mail
*/

get_header();

global $current_user;

?>

<h2 class="ui horizontal divider header cd-margem">Deseja receber notificações por e-mail?</h2>

<div class="ui center aligned container cd-margem">

<?php if ( is_user_logged_in() ) : ?>

  <a href="<?php the_permalink(); ?>?notificacao_email=sim" class="ui large button">Sim</a>
  <a href="<?php the_permalink(); ?>?notificacao_email=nao" class="ui large button">Não</a>
  <div class="ui hidden divider"></div>
  <div class="ui hidden divider"></div>

  <?php if (!$_GET["notificacao_email"]) {

    $notificacao = get_field('receber_notificacoes_por_email', 'user_' . $current_user->ID);

    if ( $notificacao ) {
      echo '<i class="green check icon"></i> Status atual: <strong>ativado</strong>.';
    } else {
      echo '<i class="red close icon"></i> Status atual: <strong>desativado</strong>.';
    }

  } ?>

  <?php

  if ($_GET["notificacao_email"] == 'sim') {
    update_field( 'field_5953b0fa6c4f9', true,'user_' . $current_user->ID);
    echo '<i class="green check icon"></i> Notificações por e-mail ativadas.';
    // echo '<div class="ui green message">Notificações por e-mail ativadas.</div>';
  };
  if ($_GET["notificacao_email"] == 'nao') {
    update_field( 'field_5953b0fa6c4f9', false,'user_' . $current_user->ID);
    echo '<i class="red close icon"></i> Notificações por e-mail desativadas.';
    // echo '<div class="ui red message">Notificações por e-mail desativadas.</div>';
  };

  ?>

<?php else : ?>

  <h3 class="ui center aligned icon header">
    <a href="<?php echo wp_login_url(get_permalink()); ?>"><i class="yellow sign in icon"></i></a>
    Você não está logado.
  </h3>
  <p>Faça <a href="<?php echo wp_login_url(get_permalink()); ?>"><strong>login</strong></a> para continuar.</p>

<?php endif; ?>

<div class="ui hidden divider"></div>

</div>

<?php get_footer(); ?>
