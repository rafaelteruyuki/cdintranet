<?php
/*
Template Name: Atualizar
*/
get_header();
$current_user =  wp_get_current_user();
?>
<h2 class="ui horizontal divider header cd-margem">Atualizar</h2>
<div class="ui container cd-margem">


<?php

$user_args = array(
  'number' => -1,
  'fields' => array('ID', 'user_login'),
  // 'offset' => 20,
  // 'role' => 'designer_gd2_gd4', // Mudar aqui
 );
$users = get_users( $user_args );

// delete_metadata( 'comment', 0, 'interacao_lida', '', true );
include ( locate_template('template-parts/atualizacao-comentarios.php') );
foreach ( $users as $user ) :
  $user_ID = $user->ID;
  $user_login = $user->user_login;
  // atualizacao_comentarios($user_ID, $user_login);
endforeach;

?>

</div>
<?php get_footer(); ?>
