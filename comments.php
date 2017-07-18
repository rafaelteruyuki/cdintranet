
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



    <?php if ( have_comments() ) : ?>

        <div class="ui threaded comments">
       		<?php wp_list_comments($args); ?>
    		</div>

    <?php endif; ?>

    <?php if ( comments_open() ) : ?>

    <div id="respond">

            <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" class="ui form">


              	<?php if ( $user_ID ) : ?>

                <!-- <p><i class="user icon"></i><?php // $current_user = wp_get_current_user(); echo $current_user->first_name . '&nbsp' . $current_user->last_name ?><br>
                <i class="sign out icon"></i><a href="<?php // echo wp_logout_url(get_permalink()); ?>" title="Sair desta conta">Sair &raquo;</a></p> -->
                <div>
                  <div class="field">
                    <label for="comment">Mensagem:</label>
										<textarea name="comment" id="comment" rows="" cols=""></textarea>
										<input type="submit" class="ui submit purple small button" value="Enviar" style="margin-top:10px" />
                  </div>
                </div>

								<?php else : ?>

                <a class="ui primary fluid button" href="<?php echo wp_login_url(get_permalink()); ?>">Faça login para deixar uma mensagem</a>

                <?php endif; ?>

                <?php comment_id_fields(); ?>
                <?php do_action('comment_form', $post->ID); ?>


            </form>


        <p class="cancel"><?php cancel_comment_reply_link('Cancelar Resposta'); ?></p>
        </div>
     <?php else : ?>
        <h3>Os comentários estão fechados.</h3>
<?php endif; ?>
