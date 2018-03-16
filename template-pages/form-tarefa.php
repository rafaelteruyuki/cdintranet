<?php acf_form_head();

/*
Template Name: Formulário Solicitação
*/

get_header(); ?>

<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/form-tarefa.css">

<?php
$current_user = wp_get_current_user();
$current_user_id = get_current_user_id();
$test_users = array(114, 77, 57, 151, 113, 132, 55, 1, 47, 51, 50, 49, 48, 53, 97, 37, 99, 76, 67, 146);
?>

<?php if ( !in_array($current_user_id, $test_users) ) : ?>

<style media="screen">
  .acf-field-5787b4caf1816 ul li:nth-child(3){ display:none; }
  .cd-hidden { display: none; }
</style>

<?php endif; ?>

<?php if ( is_user_logged_in() ) :

 $args = array(
       'post_id'		          => 'new_post', // Create a new post
       'post_title'			      => true,
       'field_groups'         => array (127),
       'return' 			        => get_bloginfo('url') . '/minhas-solicitacoes',
       'new_post'			        => array(
          'post_type'		        => 'tarefa',
          'post_status'	        => 'publish'
       ),
       'label_placement'      => 'top',
       'submit_value'         => 'Enviar',
       'updated_message'      => 'Salvo!',
       'html_updated_message'	=> '<div id="message" class="updated"><p>%s</p></div>',
       'html_submit_button'	  => '<input type="submit" class="ui primary large fluid button" value="%s" />',
       'uploader'             => 'basic',
);

?>

<div class="ui vertical basic segment cd-padding" style="background-color:#F5F5F5">
  <div class="ui grid container stackable">
    <div class="ten wide column cd-box">

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
