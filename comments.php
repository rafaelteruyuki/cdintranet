
<?php $args = array(
	'walker'            => null,
	'max_depth'         => '',
	'style'             => '',
	'callback'          => mytheme_comment,
	'end-callback'      => null,
	'type'              => 'all',
	'reply_text'        => null,
	'page'              => '',
	'per_page'          => '',
	'avatar_size'       => 32,
	'reverse_top_level' => null,
	'reverse_children'  => '',
	'format'            => 'html5', // or 'xhtml' if no 'HTML5' theme support
	'short_ping'        => false,   // @since 3.6
  'echo'              => true     // boolean, default is true
); ?>

<?php
// Do not delete these lines
    if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die ('Please do not load this page directly. Thanks!');

    if ( post_password_required() ) { ?>
        <p class="nocomments">Este artigo está protegido por password. Insira-a para ver os comentários.</p>
    <?php
        return;
    }
?>

<!-- LISTA DE COMENTARIOS -->

<?php // Se o usuário for Senac ou não estiver logado, não mostra os comentários privados
if ( current_user_can('senac') || !is_user_logged_in() ) {
  $privado = array(
  'key' => 'privado_interacao',
  'value' => '1',
  'compare' => '!=',
  );
}

$comment_list_args = array(
	'post_id' => get_the_ID(),
	'order' => 'ASC',
	'meta_query' => array( $privado ),
);

$comments = get_comments($comment_list_args); ?>

<div class="ui threaded comments">

<?php foreach ( $comments as $comment ) : ?>

	<div id="comment-<?php comment_ID() ?>" class="comment">
	  <a class="avatar">
			<span class="ui mini circular image">
	    <?php echo get_avatar( $comment, 100 ); ?>
			</span>
	  </a>
	  <div class="content">
	    <a class="author"><?php comment_author(''); ?></a><br>
	    <div class="metadata" style="margin-left:0">
	      <div class="date">
					<?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?>
					<?php if ( get_field('privado_interacao', $comment) ) { echo '<i class="lock icon cd-popup" title="Interação privada"></i>'; } ?>
				</div>
	    </div>
	    <div class="text">
	        <?php if ($comment->comment_approved == '0') : ?>
	         <em><?php _e('Your comment is awaiting moderation.') ?></em>
	         <br />
	      <?php endif; ?>
	      <?php comment_text() ?>
	    </div>
			<div class="attachment">
			<?php $i=1;
			if( have_rows('arquivos_interacao', $comment) ) {
				while( have_rows('arquivos_interacao', $comment) ) { the_row();
					$anexo_interacao = get_sub_field('arquivo_interacao', $comment);
					echo '<a href="' . $anexo_interacao['url'] . '" target="_blank" class="cd-popup" title="' . $anexo_interacao['name'] . '"><i class="attach icon"></i>Anexo ' . $i++ . '</a><br>';
				}
			} ?>
			</div>
	  </div>
	</div>

<?php endforeach; ?>

</div>

<!-- COMMENT FORM -->

<?php if ( !current_user_can('edit_pages') ) : ?>
<style media="screen">
	/* Esconde o checkbox de interação privada */
	.acf-field-5984a7402ced4 {
		display: none;
	}
</style>
<?php endif; ?>

<?php if ( comments_open() ) : ?>

<style media="screen">
	/* Esconde o header da tabela */
	#respond thead {
		display: none;
	}
</style>

<?php $comment_form_args = array(
	'comment_field'	=> '<p><label for="comment">' . '<strong>Mensagem:</strong>' . '</label><textarea id="comment" name="comment" cols="45" rows="4" aria-required="true"></textarea></p>',
	'logged_in_as'	=> '',
	'class_submit'	=> 'ui submit purple small button',
	'label_submit'	=> 'Enviar',
	'comment_notes_before'	=> '',
	'title_reply'	=> '',
); ?>

<div id="respond" class="ui form">
	<?php if ( $user_ID ) : ?>
		<?php comment_form($comment_form_args); ?>
	<?php else : ?>
		<a class="ui fluid button" href="<?php echo wp_login_url(get_permalink()); ?>">Faça login para deixar uma mensagem</a>
	<?php endif; ?>
</div>

 <?php else : ?>
    <h3>Os comentários estão fechados.</h3>
<?php endif; ?>
