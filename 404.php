<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Comunicação Digital
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="ui hidden divider"></div>

<div class="ui basic segment cd-margem">
	<div class="ui center aligned container">
		<h2 class="ui center aligned icon header">
		  <i class="yellow warning sign icon"></i>
		  Página não encontrada
		</h2>
		<p>Voltar para a <a href="<?php bloginfo('url') ?>">home</a>.</p>
		<?php // get_search_form(); ?>
	</div>
</div>

<div class="ui hidden divider"></div>

<?php get_footer();
