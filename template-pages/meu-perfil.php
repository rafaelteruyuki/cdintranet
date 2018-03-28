<?php acf_form_head();

/*
Template Name: Meu perfil
*/

get_header(); ?>

<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/form-tarefa.css">

<?php $current_user = wp_get_current_user();

  if ( is_user_logged_in() ) :

 $args = array(
       'post_id'		          => 'user_' . $current_user->ID,
       // 'post_title'			      => true,
       'field_groups'         => array (3122),
       // 'return' 			        => get_bloginfo('url') . '/minhas-solicitacoes',
       // 'new_post'			        => array(
       //    'post_type'		        => 'tarefa',
       //    'post_status'	        => 'publish'
       // ),
       'label_placement'      => 'top',
       'submit_value'         => 'Atualizar',
       'updated_message'      => 'Salvo!',
       'html_updated_message'	=> '<div id="message" class="acf-error-message" style="background: #22ba44;border-left: #1ca53a solid 4px;"><p>%s</p></div>',
       'html_submit_button'	  => '<input type="submit" class="ui primary large fluid button" value="%s" style="margin-top:20px" />',
       'uploader'             => 'basic',
);

?>


<div class="ui vertical basic segment cd-padding" style="background-color:#F5F5F5">
  <div class="ui grid container stackable">
    <div class="ten wide column cd-box">
      <h2 class="ui header" style="margin: 20px 0 50px;">
        <i class="user icon"></i>
        <?php the_title(); ?>
      </h2>
        <?php acf_form( $args ); ?>

    </div>
    <div class="six wide column">
    </div>
  </div>
</div>

<?php else : ?>

<h2 class="ui horizontal divider header cd-margem">
  <?php the_title(); ?>
</h2>

<div class="ui container center aligned cd-margem">
  <h3 class="ui center aligned icon header">
    <a href="<?php echo wp_login_url(get_permalink()); ?>"><i class="yellow sign in icon"></i></a>
    Você não está logado.
  </h3>
  <p>Faça <a href="<?php echo wp_login_url(get_permalink()); ?>"><strong>login</strong></a> para continuar.</p>
</div>

<?php endif;?>

<script type="text/javascript" src="<?php bloginfo('template_url') ?>/js/get-curso-form-tarefa.js"></script>

<?php get_footer(); ?>
