<?php acf_form_head();

/*
Template Name: Formulário Solicitação
*/

get_header(); ?>

<link rel="stylesheet" href="<?php bloginfo('url'); ?>/wp-content/themes/comunicacao-digital/css/form-tarefa.css">

<?php

 $current_user = wp_get_current_user();

 if ( is_user_logged_in() ) :

   $args = array(
         'post_id'		    	=> 'new_post', // Create a new post
         'post_title'			=> true,
         'field_groups'    => array (127),
         'return' 			    => 'http://cd.intranet.sp.senac.br/index.php/minhas-solicitacoes/',
         'new_post'			  => array(
                             'post_type'		=> 'tarefa',
                             'post_status'	=> 'publish'
         ),
         'label_placement' => 'top',
         'submit_value'    => 'Enviar',
         'updated_message' => 'Salvo!',
         'html_updated_message'	=> '<div id="message" class="updated"><p>%s</p></div>',
         'html_submit_button'	=> '<input type="submit" class="ui primary large fluid button" value="%s" />',
         'uploader' => 'basic',
     );

?>

<div class="ui vertical basic segment cd-padding" style="background-color:#F5F5F5">

  <div class="ui grid container stackable">

      <div class="ten wide column cd-box">

          <?php acf_form( $args ); ?>

      </div>

      <div class="six wide column">

         <!--<img src="http://cd.intranet.sp.senac.br/wp-content/uploads/2016/12/prazo-eventos5.png" style="width: 100%;"> -->

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

<!-- ESTILO FORM -->

<style type="text/css">
/*.acf-fields > .acf-field:first-child {
	display: none;
}*/
.acf-field--post-title {
  display: none;
}
.acf-repeater ul li {
  float: left;
  margin-left: 0;
}
</style>

<?php get_footer(); ?>
