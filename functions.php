<?php

// Imagem destacada
add_theme_support( 'post-thumbnails' );

// Adiciona o tamanho das imagens ao tema
add_image_size('redes-sociais', '400', '210', true);

// Registrar menu no tema
register_nav_menu( 'main-menu', 'Menu principal do tema que vai no header' );

// Carrega CSS e Scripts
add_action('wp_enqueue_scripts', 'carrega_scripts');

function carrega_scripts() {

	// CSS
	wp_enqueue_style( 'style', get_stylesheet_uri()); //style.css
	if ( !is_admin() ) {
		wp_enqueue_style( 'semantic', get_template_directory_uri() . '/css/semantic.min.css', array(), '1.2', 'all');
	}
	wp_enqueue_style( 'jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css',false,'1.1','all');
	wp_enqueue_style( 'form-solicitacao', get_template_directory_uri() . '/css/form-solicitacao.css',false,'1.1','all');
	wp_enqueue_style( 'main', get_template_directory_uri() . '/css/main.css',false,'1.4','all');
	wp_enqueue_style( 'popup', get_template_directory_uri() . '/components/popup.css',false,'1.1','all');

	// Javascript
	wp_deregister_script( 'jquery' ); // Remove o Jquery ogirinal do Wordpress
	wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery-3.1.0.min.js', array(), '3.1.0', true);
	// wp_enqueue_script( 'jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array(), '1.2.1', false);
	wp_enqueue_script( 'semantic-js', get_template_directory_uri() . '/js/semantic.min.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'tablesort', get_template_directory_uri() . '/js/tablesort.js', array('jquery'), '1.1', true );
	wp_enqueue_script( 'mustache', get_template_directory_uri() . '/js/mustache.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'jquery-mask', get_template_directory_uri() . '/js/jquery.mask.min.js', array('jquery'), '1.0', false );
	wp_enqueue_script( 'main', get_template_directory_uri()."/js/main.js", array('jquery'), '1.3', true);
	wp_enqueue_script( 'custom-js', get_template_directory_uri()."/js/scripts.js", array('jquery'), '1.0', true);

	wp_localize_script('custom-js', 'ajax_object',
		array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'template_directory_uri' => get_template_directory_uri()
		)
	);
}

//AJAX actions
add_action('wp_ajax_consulta_subarea', 'consultar_subarea');
add_action('wp_ajax_nopriv_consulta_subarea', 'consultar_subarea');


function consultar_subarea() {
	// Podemos acessar $_REQUEST para usar os dados enviados:
	$area = $_REQUEST['area'];

	$acf_fields = acf_get_fields_by_id(113);

	$fieldsKey = array();
	foreach($acf_fields as $field){
		$fieldsKey[$field['name']] = $field['key'];
	}

	$key = $fieldsKey['subarea-'.$area];
	$subareasField = get_field_object($key);

	echo json_encode($subareasField['choices']);

	wp_die();
}

//CONSULTAS AJAX CATÁLOGO
add_action('wp_ajax_cursos_modalidade', 'consultar_cursos');
add_action('wp_ajax_nopriv_cursos_modalidade', 'consultar_cursos');

function consultar_cursos(){
	$modalidade = $_REQUEST['modalidade'];
	$area = $_REQUEST['area'];
	$subarea = $_REQUEST['subarea'];

	$keyMod = 'modalidade';
	$keyArea = 'area';
	$keySubarea = 'subarea-'.$area;

	$valMod = $modalidade;
	$valArea = $area;
	$valSubarea = $subarea;


	if($modalidade == '0'){
		$keyMod = null;
		$valMod = null;
	}

	if($area == '0'){
		$keyArea = null;
		$valArea = null;
	}

	if($subarea == '0'){
		$keySubarea = null;
		$valSubarea = null;
	}

	//var_dump($keyMod);
	//var_dump($valMod);

	$args = array(
			'post_type'		=> 'curso',
			'posts_per_page'	=> -1,
			'order'			=> 'DESC',
			'orderby'		=> 'date',
			'meta_query' => array(
			                    'relation' => 'AND',

			                    array(
			                        'key' => $keyMod,
			                        'value' => $valMod,
			                        'compare' => '='
			                      ),

			                    array(
			                        'key' => $keyArea,
			                        'value' => $valArea,
			                        'compare' => '='
			                      ),

			                      array(
			                        'key' => $keySubarea,
			                        'value' => $valSubarea,
			                        'compare' => '='
			                      )
			                )
		);

	$query = new WP_Query($args);

	if ( $query->have_posts() ) {

		$postsArray = array();

		while ( $query->have_posts() ){
			$query->the_post();

			$obj = get_field_object('modalidade');
    		$modalidade = $obj['choices'][ $obj['value'] ];

			$postSingle = array(
				'permalink' 	=> get_the_permalink(),
				'thumbnail' 	=> get_the_post_thumbnail(null, 'redes-sociais'),
				'title' 		=> get_the_title(),
				'modalidade'	=> $modalidade
			);

			array_push($postsArray, $postSingle);
		}
	}
	echo json_encode($postsArray);

	wp_die();
}


add_action('wp_ajax_query_cursos', 'query_cursos');
add_action('wp_ajax_nopriv_query_cursos', 'query_cursos');

function query_cursos(){

	$query_string = $_REQUEST['query'];

	$args = array(
			'post_type'		=> 'curso',
			'posts_per_page'	=> -1,
			'order'			=> 'DESC',
			'orderby'		=> 'date',
			's'				=> $query_string
		);

	$search = new WP_Query($args);

	if ( $search->have_posts() ) {

		$postsArray = array();

		while ( $search->have_posts() ){
			$search->the_post();

			$obj = get_field_object('modalidade');
    		$modalidade = $obj['choices'][ $obj['value'] ];

			$postSingle = array(
				'permalink' 	=> get_the_permalink(),
				'thumbnail' 	=> get_the_post_thumbnail(null, 'redes-sociais'),
				'title' 		=> get_the_title(),
				'modalidade'	=> $modalidade
			);

			array_push($postsArray, $postSingle);
		}
	}
	echo json_encode($postsArray);

	wp_die();
}

/* --------------------------

CUSTOM POST TYPE - CURSO

---------------------------- */

function registra_post_type_curso() {

	$labels = array(
		'name'                  => _x( 'Cursos', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Curso', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Cursos', 'text_domain' ),
		'name_admin_bar'        => __( 'Curso', 'text_domain' ),
		'archives'              => __( 'Arquivos', 'text_domain' ),
		'parent_item_colon'     => __( 'Curso pai:', 'text_domain' ),
		'all_items'             => __( 'Todos os cursos', 'text_domain' ),
		'add_new_item'          => __( 'Adicionar novo Curso', 'text_domain' ),
		'add_new'               => __( 'Adicionar novo', 'text_domain' ),
		'new_item'              => __( 'Novo Curso', 'text_domain' ),
		'edit_item'             => __( 'Editar Curso', 'text_domain' ),
		'update_item'           => __( 'Atualizar Curso', 'text_domain' ),
		'view_item'             => __( 'Ver Curso', 'text_domain' ),
		'search_items'          => __( 'Procurar Curso', 'text_domain' ),
		'not_found'             => __( 'Não encontrado', 'text_domain' ),
		'not_found_in_trash'    => __( 'Não encontrado no lixo', 'text_domain' ),
		'featured_image'        => __( 'Redes Sociais 840x440', 'text_domain' ),
		'set_featured_image'    => __( 'Definir imagem', 'text_domain' ),
		'remove_featured_image' => __( 'Remover imagem', 'text_domain' ),
		'use_featured_image'    => __( 'Utilizar como imagem', 'text_domain' ),
		'insert_into_item'      => __( 'Inserir no Curso', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Atualizado neste Curso', 'text_domain' ),
		'items_list'            => __( 'Lista de Cursos', 'text_domain' ),
		'items_list_navigation' => __( 'Lista de navegação de Cursos', 'text_domain' ),
		'filter_items_list'     => __( 'Filtrar lista de Cursos', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Curso', 'text_domain' ),
		'description'           => __( 'Custom post type para os cursos', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_rest' 					=> true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'curso', $args );

}
add_action( 'init', 'registra_post_type_curso', 0 );

/* --------------------------

CUSTOM POST TYPE - TAREFA

---------------------------- */

function tarefa_post_type() {

	$labels = array(
		'name'                  => _x( 'Tarefas', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Tarefa', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Tarefas', 'text_domain' ),
		'name_admin_bar'        => __( 'Tarefa', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'Todas as tarefas', 'text_domain' ),
		'add_new_item'          => __( 'Adicionar Nova Tarefa', 'text_domain' ),
		'add_new'               => __( 'Adicionar Nova', 'text_domain' ),
		'new_item'              => __( 'Nova Tarefa', 'text_domain' ),
		'edit_item'             => __( 'Editar Tarefa', 'text_domain' ),
		'update_item'           => __( 'Atualizar Tarefa', 'text_domain' ),
		'view_item'             => __( 'Visualizar Tarefa', 'text_domain' ),
		'search_items'          => __( 'Procurar Tarefa', 'text_domain' ),
		'not_found'             => __( 'Não encontrado', 'text_domain' ),
		'not_found_in_trash'    => __( 'Não encontrado no lixo', 'text_domain' ),
		'featured_image'        => __( 'Imagem', 'text_domain' ),
		'set_featured_image'    => __( 'Configurar Imagem', 'text_domain' ),
		'remove_featured_image' => __( 'Remover Imagem', 'text_domain' ),
		'use_featured_image'    => __( 'Utilizar como imagem', 'text_domain' ),
		'insert_into_item'      => __( 'Inserir na tarefa', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Adicionado a esta tarefa', 'text_domain' ),
		'items_list'            => __( 'Lista de tarefas', 'text_domain' ),
		'items_list_navigation' => __( 'Navegação da lista de tarefas', 'text_domain' ),
		'filter_items_list'     => __( 'Filtrar lista de tarefas', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Tarefa', 'text_domain' ),
		'description'           => __( 'Tarefa', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'author', 'thumbnail', 'comments', 'revisions'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_rest' 					=> true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-pressthis',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'tarefa', $args );

}
add_action( 'init', 'tarefa_post_type', 0 );


/* --------------------------

SEARCH TEMPLATES

---------------------------- */

function template_chooser($template)
{
  global $wp_query;
  $post_type = get_query_var('post_type');

	//Post Type Curso
  if( $wp_query->is_search && $post_type == 'curso' )
  {
    return locate_template('search-curso.php');
  }

	//Post Type Tarefa
	if( $wp_query->is_search && $post_type == 'tarefa' )
  {
    return locate_template('search-tarefa.php');
  }

  return $template;
}
add_filter('template_include', 'template_chooser');


/* --------------------------

MOSTRAR TODOS OS RESULTADOS DE BUSCA

---------------------------- */

function change_wp_search_size($query) {
    if ( $query->is_search ) // Make sure it is a search page
        $query->query_vars['posts_per_page'] = -1; // Change the number of posts you would like to show

    return $query; // Return our modified query variables
}
add_filter('pre_get_posts', 'change_wp_search_size'); // Hook our custom function onto the request filter



/**
 * Extend WordPress search to include custom fields
 *
 * https://adambalee.com/search-wordpress-by-custom-fields-without-a-plugin/
 */

/**
 * Join posts and postmeta tables
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 */
function cf_search_join( $join ) {
    global $wpdb;

    if ( is_search() ) {
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }

    return $join;
}
add_filter('posts_join', 'cf_search_join' );

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
function cf_search_where( $where ) {
    global $pagenow, $wpdb;

    if ( is_search() ) {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
    }

    return $where;
}
add_filter( 'posts_where', 'cf_search_where' );

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function cf_search_distinct( $where ) {
    global $wpdb;

    if ( is_search() ) {
        return "DISTINCT";
    }

    return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );

/* --------------------------

CUSTOM ROLE - DESIGNER GD2 e GD4

---------------------------- */

add_role( 'designer_gd2_gd4', 'Designer GD2/GD4', array(
	'edit_dashboard'			=> true,
	'delete_others_pages'		=> true,
	'delete_others_posts'		=> true,
	'delete_pages'				=> true,
	'delete_posts'				=> true,
	'delete_private_pages'		=> true,
	'delete_private_posts'		=> true,
	'delete_published_pages'	=> true,
	'delete_published_posts'	=> true,
	'edit_others_pages'			=> true,
	'edit_others_posts'			=> true,
	'edit_pages'				=> true,
	'edit_posts'				=> true,
	'edit_private_pages'		=> true,
	'edit_private_posts'		=> true,
	'edit_published_pages'		=> true,
	'edit_published_posts'		=> true,
	'manage_categories'			=> true,
	'manage_links'				=> true,
	'moderate_comments'			=> true,
	'publish_pages'				=> true,
	'publish_posts'				=> true,
	'read'						=> true,
	'read_private_pages'		=> true,
	'read_private_posts'		=> true,
	'unfiltered_html'			=> true,
	'upload_files'				=> true
));

/* --------------------------

CUSTOM ROLE - DESIGNER GD1 e GD3

---------------------------- */

add_role( 'designer_gd1_gd3', 'Designer GD1/GD3', array(
	'edit_dashboard'			=> true,
	'delete_others_pages'		=> true,
	'delete_others_posts'		=> true,
	'delete_pages'				=> true,
	'delete_posts'				=> true,
	'delete_private_pages'		=> true,
	'delete_private_posts'		=> true,
	'delete_published_pages'	=> true,
	'delete_published_posts'	=> true,
	'edit_others_pages'			=> true,
	'edit_others_posts'			=> true,
	'edit_pages'				=> true,
	'edit_posts'				=> true,
	'edit_private_pages'		=> true,
	'edit_private_posts'		=> true,
	'edit_published_pages'		=> true,
	'edit_published_posts'		=> true,
	'manage_categories'			=> true,
	'manage_links'				=> true,
	'moderate_comments'			=> true,
	'publish_pages'				=> true,
	'publish_posts'				=> true,
	'read'						=> true,
	'read_private_pages'		=> true,
	'read_private_posts'		=> true,
	'unfiltered_html'			=> true,
	'upload_files'				=> true
));

/* --------------------------

CUSTOM ROLE - DESIGNER INSTITUCIONAL

---------------------------- */

add_role( 'designer_institucional', 'Designer Institucional', array(
	'edit_dashboard'			=> true,
	'delete_others_pages'		=> true,
	'delete_others_posts'		=> true,
	'delete_pages'				=> true,
	'delete_posts'				=> true,
	'delete_private_pages'		=> true,
	'delete_private_posts'		=> true,
	'delete_published_pages'	=> true,
	'delete_published_posts'	=> true,
	'edit_others_pages'			=> true,
	'edit_others_posts'			=> true,
	'edit_pages'				=> true,
	'edit_posts'				=> true,
	'edit_private_pages'		=> true,
	'edit_private_posts'		=> true,
	'edit_published_pages'		=> true,
	'edit_published_posts'		=> true,
	'manage_categories'			=> true,
	'manage_links'				=> true,
	'moderate_comments'			=> true,
	'publish_pages'				=> true,
	'publish_posts'				=> true,
	'read'						=> true,
	'read_private_pages'		=> true,
	'read_private_posts'		=> true,
	'unfiltered_html'			=> true,
	'upload_files'				=> true
));

/* --------------------------

CUSTOM ROLE - PORTAL

---------------------------- */

add_role( 'portal', 'Portal', array(
	'delete_others_pages'		=> true,
	'delete_others_posts'		=> true,
	'delete_pages'				=> true,
	'delete_posts'				=> true,
	'delete_private_pages'		=> true,
	'delete_private_posts'		=> true,
	'delete_published_pages'	=> true,
	'delete_published_posts'	=> true,
	'edit_others_pages'			=> true,
	'edit_others_posts'			=> true,
	'edit_pages'				=> true,
	'edit_posts'				=> true,
	'edit_private_pages'		=> true,
	'edit_private_posts'		=> true,
	'edit_published_pages'		=> true,
	'edit_published_posts'		=> true,
	'manage_categories'			=> true,
	'manage_links'				=> true,
	'moderate_comments'			=> true,
	'publish_pages'				=> true,
	'publish_posts'				=> true,
	'read'						=> true,
	'read_private_pages'		=> true,
	'read_private_posts'		=> true,
	'unfiltered_html'			=> true,
	'upload_files'				=> true
));

/* --------------------------

CUSTOM ROLE - SENAC

---------------------------- */

add_role( 'senac', 'Senac', array(
	'delete_others_pages'		=> false,
	'delete_others_posts'		=> false,
	'delete_pages'				=> false,
	'delete_posts'				=> false,
	'delete_private_pages'		=> false,
	'delete_private_posts'		=> false,
	'delete_published_pages'	=> false,
	'delete_published_posts'	=> false,
	'edit_others_pages'			=> false,
	'edit_others_posts'			=> false,
	'edit_pages'				=> false,
	'edit_posts'				=> true,
	'edit_private_pages'		=> false,
	'edit_private_posts'		=> false,
	'edit_published_pages'		=> false,
	'edit_published_posts'		=> false,
	'manage_categories'			=> false,
	'manage_links'				=> false,
	'moderate_comments'			=> false,
	'publish_pages'				=> false,
	'publish_posts'				=> true,
	'read'						=> true,
	'read_private_pages'		=> false,
	'read_private_posts'		=> false,
	'unfiltered_html'			=> true,
	'upload_files'				=> true
));

/* --------------------------

CUSTOM ROLE - REDES SOCIAIS

---------------------------- */

add_role( 'redes_sociais', 'Redes Sociais', array(
	'delete_others_pages'		=> true,
	'delete_others_posts'		=> true,
	'delete_pages'				=> true,
	'delete_posts'				=> true,
	'delete_private_pages'		=> true,
	'delete_private_posts'		=> true,
	'delete_published_pages'	=> true,
	'delete_published_posts'	=> true,
	'edit_others_pages'			=> true,
	'edit_others_posts'			=> true,
	'edit_pages'				=> true,
	'edit_posts'				=> true,
	'edit_private_pages'		=> true,
	'edit_private_posts'		=> true,
	'edit_published_pages'		=> true,
	'edit_published_posts'		=> true,
	'manage_categories'			=> true,
	'manage_links'				=> true,
	'moderate_comments'			=> true,
	'publish_pages'				=> true,
	'publish_posts'				=> true,
	'read'						=> true,
	'read_private_pages'		=> true,
	'read_private_posts'		=> true,
	'unfiltered_html'			=> true,
	'upload_files'				=> true
));



function wpse27856_set_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );

/* --------------------------

ADMIN - CUSTOM WORDPRESS FOOTER MESSAGE

---------------------------- */
function remove_footer_admin () {
	echo 'Comunicação Digital - Gerência de Comunicação e Relações Institucionais';
}
add_filter('admin_footer_text', 'remove_footer_admin');


/* --------------------------

ADMIN - MENUS LATERAIS

---------------------------- */

function remove_menus(){

	if ( ! current_user_can( 'administrator' ) ) {

	  remove_menu_page( 'index.php' );                  //Dashboard
	  remove_menu_page( 'jetpack' );                    //Jetpack*
	  remove_menu_page( 'edit.php' );                   //Posts
	  remove_menu_page( 'upload.php' );                 //Media
	  //remove_menu_page( 'edit.php?post_type=page' );    //Pages
	  remove_menu_page( 'edit-comments.php' );          //Comments
	  remove_menu_page( 'themes.php' );                 //Appearance
	  remove_menu_page( 'plugins.php' );                //Plugins
	  remove_menu_page( 'users.php' );                  //Users
		remove_menu_page( 'profile.php' );                  //Profile
	  remove_menu_page( 'tools.php' );                  //Tools
	  remove_menu_page( 'options-general.php' );        //Settings

	  //remove_menu_page( 'et_divi_options' );        //Divi não some
	  remove_menu_page( 'edit.php?post_type=project' );        //Projetos
		remove_menu_page( 'edit.php?post_type=tarefa' );        //Tarefas
	  remove_menu_page( 'edit.php?post_type=acf-field-group' );        //ACF
	  remove_menu_page( 'formcraft3_dashboard' );        //FormCraft

	}

}
add_action( 'admin_menu', 'remove_menus' );

// Remove o Divi do menu
function my_custom_fonts() {

	if ( ! current_user_can( 'administrator' ) ) {

		echo
		'<style>
			#toplevel_page_et_divi_options {display: none;}
		</style>';

	}

}

add_action('admin_head', 'my_custom_fonts');


/* --------------------------

ADMIN BAR - ESCONDE A ADMIN BAR SE NÃO FOR ADMINISTRADOR OU DESIGNER DO FRONT-END

---------------------------- */

function mytheme_remove_admin_bar() {
	if ( current_user_can('administrator') || current_user_can('designer') ) {
		show_admin_bar( true );
	} else {
		show_admin_bar( false );
	}
}
add_action( 'after_setup_theme', 'mytheme_remove_admin_bar' );


/* --------------------------

ADMIN BAR - CUSTOM ADMIN BAR

---------------------------- */

function webriti_remove_admin_bar_links() {

	global $wp_admin_bar;

	if ( !current_user_can('administrator') ) {

	//Remove WordPress Logo Menu Items
	$wp_admin_bar->remove_menu('wp-logo'); // Removes WP Logo and submenus completely, to remove individual items, use the below mentioned codes
	$wp_admin_bar->remove_menu('about'); // 'About WordPress'
	$wp_admin_bar->remove_menu('wporg'); // 'WordPress.org'
	$wp_admin_bar->remove_menu('documentation'); // 'Documentation'
	$wp_admin_bar->remove_menu('support-forums'); // 'Support Forums'
	$wp_admin_bar->remove_menu('feedback'); // 'Feedback'

	//Remove Site Name Items
	//$wp_admin_bar->remove_menu('site-name'); // Removes Site Name and submenus completely, To remove individual items, use the below mentioned codes
	//$wp_admin_bar->remove_menu('view-site'); // 'Visit Site'
	//$wp_admin_bar->remove_menu('dashboard'); // 'Dashboard'
	$wp_admin_bar->remove_menu('themes'); // 'Themes'
	$wp_admin_bar->remove_menu('widgets'); // 'Widgets'
	$wp_admin_bar->remove_menu('menus'); // 'Menus'

	// Remove Customize
	$wp_admin_bar->remove_menu('customize');

	// Remove Comments Bubble
	$wp_admin_bar->remove_menu('comments');

	//Remove Update Link if theme/plugin/core updates are available
	$wp_admin_bar->remove_menu('updates');

	//Remove '+ New' Menu Items
	//$wp_admin_bar->remove_menu('new-content'); // Removes '+ New' and submenus completely, to remove individual items, use the below mentioned codes
	$wp_admin_bar->remove_menu('new-post'); // 'Post' Link
	$wp_admin_bar->remove_menu('new-media'); // 'Media' Link
	$wp_admin_bar->remove_menu('new-link'); // 'Link' Link
	$wp_admin_bar->remove_menu('new-page'); // 'Page' Link
	$wp_admin_bar->remove_menu('new-user'); // 'User' Link
	$wp_admin_bar->remove_menu('new-tarefa'); // Tarefa
	$wp_admin_bar->remove_menu('new-project'); // Project

	// Remove 'Howdy, username' Menu Items
	//$wp_admin_bar->remove_menu('my-account'); // Removes 'Howdy, username' and Menu Items
	//$wp_admin_bar->remove_menu('user-actions'); // Removes Submenu Items Only
	//$wp_admin_bar->remove_menu('user-info'); // 'username'
	//$wp_admin_bar->remove_menu('edit-profile'); // 'Edit My Profile'
	//$wp_admin_bar->remove_menu('logout'); // 'Log Out'

	}

}
add_action( 'wp_before_admin_bar_render', 'webriti_remove_admin_bar_links' );


/* --------------------------

NÃO PERMITE ACESSO AO DASHBOARD SE FOR USER ROLE SENAC

---------------------------- */

//FUNCIONANDO (FICAR ATENTO, POIS OUTRA FUNCAO PARECIDA FEZ O FORM-CRAFT PARAR DE ENVIAR SE NAO ESTA LOGADO)

add_action( 'init', 'blockusers_init' );
	function blockusers_init() {
	if ( is_admin() && current_user_can( 'senac' ) &&
	! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
	wp_redirect( home_url() );
	exit;
	}
}


/* --------------------------

ADMIN - CUSTOMIZAR DASHBOARD

---------------------------- */

if (!current_user_can('administrator')) {

function remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );   // Right Now
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' ); // Recent Comments
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );  // Incoming Links
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );   // Plugins
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );  // Quick Press
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );  // Recent Drafts
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );   // WordPress blog
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );   // Other WordPress News
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );   // Atividades
	remove_meta_box( 'formcraft_dashboard_widget', 'dashboard', 'normal' );   // FormCraft

	// use 'dashboard-network' as the second parameter to remove widgets from a network dashboard.
}
add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );

remove_action( 'welcome_panel', 'wp_welcome_panel' );

// Custom metabox
function custom_dashboard_widget() {

	$count_posts = wp_count_posts('curso');
	$published_posts = $count_posts->publish;

	echo '<h2>Comunicação Digital</h2><p>Gerência de Comunicação e Relações Institucionais</p>';
	echo '<ul>';
	echo '<li>• ' . '<strong>' . $published_posts . '</strong>' . ' cursos publicados</li>';
	echo '<li>• <a href="http://cd.intranet.sp.senac.br/wp-admin/post-new.php?post_type=curso">Novo curso</a></li>';
	echo '</ul>';
}

// Adicionar custom metabox
function add_custom_dashboard_widget() {
	wp_add_dashboard_widget('custom_dashboard_widget', 'Senac São Paulo', 'custom_dashboard_widget');
}

add_action('wp_dashboard_setup', 'add_custom_dashboard_widget');

}


/* --------------------------

CONTA O NUMERO DE POSTS DE ACORDO COM O CUSTOM FIELD ESPEFICICADO

---------------------------- */

function get_post_count_by_meta( $meta_key = false, $meta_value = false, $post_type = 'post' ) {

	$args = array(
			'post_type' => $post_type,
			'numberposts'	=> -1,
			'post_status'	=> 'publish',
		);

		if ( $meta_key && $meta_value ) {
			$args['meta_query'][] = array('key' => $meta_key, 'value' => $meta_value);
		}
		elseif ( $meta_value ) {
			$args['meta_query'][] = array('value'=>$meta_value);
		}
		elseif ( $meta_key ) {
			$args['meta_query'][] = array('key' => $meta_key);
		}

		$posts = get_posts($args);
		$count = count($posts);

	return $count;

}

/* --------------------------

PAGINACAO - ARCHIVE TAREFA

---------------------------- */

// function pagination_bar() {
//     global $wp_query;
//
//     $total_pages = $wp_query->max_num_pages;
//
//     if ($total_pages > 1){
//         $current_page = max(1, get_query_var('paged'));
//
//         echo paginate_links(array(
//             'base' => get_pagenum_link(1) . '%_%',
//             'format' => '/page/%#%',
//             'current' => $current_page,
//             'total' => $total_pages,
//         ));
//     }
// }

/* --------------------------

SALVA NO BANCO DE DADOS OS CAMPOS DO USUÁRIO DO ACF QUANDO UM NOVO USUÁRIO É CRIADO E MANDA EMAIL PRO ADMIN

---------------------------- */

add_action( 'user_register', 'save_acf_user_field', 10, 1 );

function save_acf_user_field( $user_id ) {

    update_field( 'field_5953b0fa6c4f9', true,'user_' . $user_id); // Notificações por email == checked
		update_field( 'field_595feb818431d', true,'user_' . $user_id); // Atualizar feed == checked

		$user = get_user_by( 'id', $user_id );
		$name = $user->display_name;
		$email = $user->user_email;

		$to = 'rafael.franchin@sp.senac.br';
		$headers = 'From: ' . $name . ' <' . $email . '>' . "\r\n";
		$subject = 'CD Intranet - Novo usuário';
		$message =
		'<h2>[Novo usuário registrado]</h2><br>' .
		'<strong>Nome: </strong> ' . $name . '<br>' .
		'<strong>Email: </strong> ' . $email . '<br>';

		wp_mail( $to , $subject, $message, $headers );

}

/* --------------------------

AO CRIAR/ATUALIZAR TAREFA

---------------------------- */

  function my_acf_save_post( $post_id ) {

		global $current_user;

		if (get_post_type($post_id) == 'tarefa') {

    $my_post = array();
    $my_post['ID'] = $post_id;
		$author_id = get_post_field( 'post_author', $post_id );

		// Muda o status para Não iniciado
		$status = get_field('status');

				if ( $status === null ) {
					update_field('status', 'naoiniciado', $post_id );

					// Define a segmentação da tarefa (ao criá-la apenas)
					include ( locate_template('template-parts/cd-feed-new.php') );

					// Define o cd_author
					update_field( 'cd_author', $author_id, $post_id);

					// // Registra o acesso
					// $acesso = date( 'YmdHis', current_time( 'timestamp', 0 ) );
					// $row = array(
					// 	'usuario'	=> $current_user->user_login,
					// 	'acesso'	=> $acesso,
					// );
					// $i = add_row('visitas', $row, $post_id);

					// Tarefas

					$tarefa_lida = array();
					$tarefa_lida[] = $current_user->ID;
				  $tarefa_lida = array_map('intval', $tarefa_lida);
				  update_post_meta( $post_id, 'tarefa_lida', $tarefa_lida );

				}

    // Update the post into the database - Se não não atualiza o cache do Search & Filter
    wp_update_post( $my_post );

		// Salva o the_modified_author, pois o ACF form não salva o meta_value da meta_key _edit_last
		update_post_meta( $post_id, '_edit_last', $current_user->ID );

		// // Atualizar feed == checked
		// global $wpdb;
		// $wpdb->query($wpdb->prepare("UPDATE wp_usermeta SET meta_value=1 WHERE meta_key='atualizar_feed'", ''));

		}
  }

  // run after ACF saves the $_POST['fields'] data
  add_action('acf/save_post', 'my_acf_save_post', 19);

	// /* --------------------------
	//
	// ATUALIZA O POST APOS O COMENTARIO (PARA O POST SUBIR NO FEED)
	//
	// ---------------------------- */
	//
	// add_filter( 'comment_post', 'comment_notification' );
	//
	// function comment_notification( $comment_id ) {
	//
	// 	$comment = get_comment( $comment_id );
	// 	$post_id = get_post( $comment->comment_post_ID );
	//
	// 	if ( get_post_type( $post_id ) == 'tarefa' ) {
	//
	// 	  // Update the post into the database
	// 	  wp_update_post( $post_id );
	//
	// 		// Atualizar feed == checked
	// 		global $wpdb;
	// 		$wpdb->query($wpdb->prepare("UPDATE wp_usermeta SET meta_value=1 WHERE meta_key='atualizar_feed'", ''));
	//
	// 	}
	//
	// }

	/* --------------------------

	VERIFICA SE ALGUM POST FOI ATUALIZADO PARA ATUALIZAR O FEED

	---------------------------- */

	// function verifica_atualizacao() {
	//
	// 	global $current_user;
	// 	$atualizar_feed = get_field('atualizar_feed', 'user_'. $current_user->ID );
	// 	echo $atualizar_feed;
  //   wp_die();
	//
	// }
	// add_action('wp_ajax_verifica_atualizacao', 'verifica_atualizacao');
	// add_action('wp_ajax_nopriv_verifica_atualizacao', 'verifica_atualizacao');
	//
	// function carrega_loop (){
	//
	//   global $current_user;
	// 	$response;
	//   // $atualizar_feed = get_field('atualizar_feed', 'user_'. $current_user->ID );
	//
	// 		include ( locate_template('template-parts/cd-feed.php') );
	//
	// 		$args = array(
	// 			'post_type'              => 'tarefa',
	// 			'posts_per_page'         => 31,
	// 			'order'                  => 'DESC',
	// 			'orderby'                => 'modified',
	// 			'author'                 => $feed_rc,
	// 			'meta_query'             => array( $feed_cd ),
	// 		);
	//
	// 		$query = new WP_Query( $args );
	//
	// 		if ( $query->have_posts() ) {
	// 			while ( $query->have_posts() ) { $query->the_post();
	//
	// 				include ( locate_template('template-parts/var-tarefas.php') );
	//
	// 				if ( get_post_meta(get_post()->ID, '_edit_last') ) {
	// 					$author = ', por ' . get_the_modified_author();
	// 				};
	//
	// 				$response .= '<a href="'. get_the_permalink() .'" class="item '. get_lido_nao_lido('feed-lido', 'feed-nao-lido').'" style="border-top: 1px solid #dedede !important;">';
	// 				$response .= '<strong style="line-height: 2;">'.get_field('unidade').'&nbsp;&nbsp;|&nbsp;&nbsp;'.get_the_title().'</strong><br>';
	// 				$response .= '<span class="cd-disabled">';
	// 				$response .= '<i class="green refresh icon"></i> Há '. human_time_diff(get_the_modified_time('U'), current_time('timestamp')) . $author;
	// 				$response .= '<br><i class="purple comments icon"></i>'. get_comments_number() . ' interações' . '<br>';
	// 				$response .= '<i class="power icon"></i>' . $status['label'] . '</span></a>';
	//
	// 			}
	//
	// 			if( current_user_can( 'edit_pages' )){
	// 				$response .= '<a href="http://cd.intranet.sp.senac.br/minhas-tarefas/" class="item" style="text-align: center; padding: 20px !important; border-top: 1px solid #dedede !important;"><strong>Ver todas</strong></a>';
	// 			}else{
	// 				$response .= '<a href="http://cd.intranet.sp.senac.br/minhas-solicitacoes/" class="item" style="text-align: center; padding: 20px !important; border-top: 1px solid #dedede !important;"><strong>Ver todas</strong></a>';
	// 			}
	//
	// 		}else{
	// 			$response = '<div class="item"><i class="grey refresh icon"></i>Não há notificações</div>';
	// 		}
	// 		wp_reset_postdata();
	//
	//
	// 	update_field( 'field_595feb818431d', false,'user_' . $current_user->ID); // Atualizar feed == unchecked
	//
	// 	echo $response;
	//
	// 	wp_die();
	// }
	//
	// add_action('wp_ajax_carrega_loop', 'carrega_loop');
	// add_action('wp_ajax_nopriv_carrega_loop', 'carrega_loop');

function carrega_loop () {

	// // CD-FEED
	// include ( locate_template('template-parts/cd-feed.php') );
	//
	// // REMOVE COMENTARIOS PRIVADOS DOS USUARIOS SENAC E DE USUARIOS NAO LOGADOS
	// if ( current_user_can( 'senac' ) || !is_user_logged_in() ) {
	//   $privado = array(
	//   'key' => 'privado_interacao',
	//   'value' => '1',
	//   'compare' => '!=',
	//   );
	// }
	//
	// // META_QUERY DOS POSTS IDS
	// $post_args = array(
	//   'post_type'              => array( 'tarefa' ),
	//   'posts_per_page'         => -1,
	//   'order'                  => 'DESC',
	//   // 'post__in'               => $allTheIDs,
	//   // 'orderby'                => 'comment_date',
	//   // 'author'                 => $feed_rc,
	//   'fields'                 => 'ids',
	//   'meta_query'             => array( $comment_feed ),
	// );
	//
	// $posts_array = get_posts( $post_args );
	// wp_reset_postdata();
	//
	// if (!empty($posts_array)) : // Se não tiver posts, não inicia essa query.
	//
	//   $nao_lidas_args = array(
	//       'order'          => 'DESC',
	//       'orderby'        => 'comment_date',
	//       'post__in'       => $posts_array, //THIS IS THE ARRAY OF POST IDS WITH META QUERY
	//       'meta_query'     => array( $privado ),
	//   );
	//
	//   $comments_query = new WP_Comment_Query;
	//   $comments = $comments_query->query( $nao_lidas_args );
	//
	//   $num_nao_lidas = 0;
	//   $i = 0;
	//
	//   $loop = '<a href="' . get_bloginfo('url') . '/interacoes/" class="item" id="interacoes-nao-lidas" style="display: none; text-align: left; padding: 20px !important; border-top: 1px solid #dedede !important;"><strong><i class="ui yellow info circle icon"></i>Veja todas as solicitações com interações não lidas</strong></a>';
	//
	//   if ( !empty( $comments ) ) :
	//
	//     foreach ( $comments as $comment ) :
	//
	// 			$lido_nao_lido = 'feed-lido';
	//
	// 			// Checa se há visita e quem visitou
	//       if( have_rows('visitas', $comment->comment_post_ID) ) {
	//
	//         while ( have_rows('visitas', $comment->comment_post_ID) ) {
	//           the_row();
	//           $usuario_registrado[] = get_sub_field('usuario', $comment->comment_post_ID); // Array usuários registrados
	//           $acesso_registrado[] = get_sub_field('acesso', $comment->comment_post_ID); // Array acessos registrados
	//         }
	//
	//         $key = array_search($current_user->user_login, $usuario_registrado); // Procura a posição no array de usuários registrados
	// 				$comment_time = get_comment_date('YmdHis', $comment->comment_ID);
	//
	//         // Usuário logado visitou
	//         if ($key !== false) {
	//
	//           if ($comment_time > $acesso_registrado[$key]) {
	// 						$lido_nao_lido = 'feed-nao-lido';
	//             $num_nao_lidas++;
	//           }
	//
	//         } else {
	//           $num_nao_lidas++; // Se há comentário, mas não visitou a tarefa ainda
	//         }
	//
	//       }
	//
	//       $usuario_registrado = array(); // Limpa o array
	//       $acesso_registrado = array(); // Limpa o array
	//
	//       $i++;
	//
	//       if ($i <= 30) :
	//
	//       $loop .= '<a href="' . get_the_permalink($comment->comment_post_ID) . '" class="item ' . $lido_nao_lido . '" style="border-top: 1px solid #dedede !important;">';
	// 			$loop .= '<span style="line-height:1.5;">';
  //       $loop .= '<strong>' . $comment->comment_author . '</strong> disse:<br>';
  // 			$loop .= '<em>' . get_comment_excerpt($comment->comment_ID) . '</em>';
  // 			$loop .= '</span>';
	// 			$loop .= '<br>';
	// 			$loop .= '<span class="cd-disabled">';
  //       $loop .= '<i class="purple comment icon"></i>Há ' . human_time_diff( get_comment_date('U', $comment), current_time('timestamp') );
  //       if ( get_field('privado_interacao', $comment) ) {
	// 			$loop .= '<i class="lock icon" style="margin:0;"></i>';
	// 			}
  //       if ( have_rows('arquivos_interacao', $comment) ) {
	// 			$loop .= '<i class="attach icon"></i>';
	// 			}
  //     	$loop .= '<br>';
	// 			$loop .= '<i class="green file text icon"></i>' . get_field('unidade', $comment->comment_post_ID) . '&nbsp;&nbsp;|&nbsp;&nbsp;' . get_the_title($comment->comment_post_ID);
  // 			$loop .= '</span>';
	// 			$loop .= '</a>';
	//
	//       endif;
	//
	//       endforeach;
	//
  //     $loop .= '<a href="' . get_bloginfo('url') . '/interacoes" class="item" style="text-align: center; padding: 20px !important; border-top: 1px solid #dedede !important;"><strong>Ver todas</strong></a>';
	//
  //     else :
	//
  //     $num_nao_lidas = 0;
  //     $loop .= '<a class="item"><i class="grey comment icon"></i>Não há interações</a>';
	//
  //     endif;
	//
  // 	else :
	//
	// 	$num_nao_lidas = 0;
  //   $loop .= '<a class="item"><i class="grey comment icon"></i>Não há interações</a>';
	//
	// 	endif; wp_reset_postdata();
	//
	// $response = json_encode(
	// 	array(
	// 		'loop' => $loop,
	// 		'num_nao_lidas' => $num_nao_lidas,
	// 		)
	// 	);

	$response = get_template_part('comment', 'feed');

	echo $response;

	wp_die();

}
add_action('wp_ajax_carrega_loop', 'carrega_loop');
add_action('wp_ajax_nopriv_carrega_loop', 'carrega_loop');

/* --------------------------

REDIRECT USUARIOS PARA A HOME APOS LOGIN

---------------------------- */

	// function my_login_redirect( $redirect_to, $request, $user ) {
	// 	//is there a user to check?
	// 	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
	// 		//check for admins
	// 		if ( in_array( 'administrator', $user->roles ) ) {
	// 			// redirect them to the default place
	// 			return $redirect_to;
	// 		} else {
	// 			return home_url();
	// 		}
	// 	} else {
	// 		return $redirect_to;
	// 	}
	// }
	//
	// add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );

	/* --------------------------

	SEARCH & FILTER - FILTROS MINHAS TAREFAS

	---------------------------- */

	function filter_function_name( $args, $sfid ) {

		global $current_user;

		// CD-FEED
		include ( locate_template('template-parts/cd-feed.php') );

		// Minhas tarefas
		if ( $sfid == 2817 ) {

	    $args['meta_query'] = array( $minhas_tarefas_feed );

		}

		// Minhas solicitações
		if ( $sfid == 12379 ) {

			$args['meta_query'] = array( $minhas_solicitacoes_feed );

		}

		return $args;

	}
	add_filter( 'sf_edit_query_args', 'filter_function_name', 20, 2 );

/* --------------------------

PAGINACAO - MINHAS TAREFAS / TODAS AS TAREFAS

---------------------------- */

function custom_pagination($numpages = '', $pagerange = '', $paged='') {

  if (empty($pagerange)) {
    $pagerange = 2;
  }

  /**
   * This first part of our function is a fallback
   * for custom pagination inside a regular loop that
   * uses the global $paged and global $wp_query variables.
   *
   * It's good because we can now override default pagination
   * in our theme, and use this function in default quries
   * and custom queries.
   */
  global $paged;
  if (empty($paged)) {
    $paged = 1;
  }
  if ($numpages == '') {
    global $wp_query;
    $numpages = $wp_query->max_num_pages;
    if(!$numpages) {
        $numpages = 1;
    }
  }

  /**
   * We construct the pagination arguments to enter into our paginate_links
   * function.
   */
  $pagination_args = array(
    //'base'            => get_pagenum_link(1) . '%_%',
    //'format'          => 'page/%#%',
    'total'           => $numpages,
    'current'         => $paged,
    'show_all'        => False,
    'end_size'        => 1,
    'mid_size'        => $pagerange,
    'prev_next'       => True,
    'prev_text'       => __('&laquo; Anterior'),
    'next_text'       => __('Próximo &raquo;'),
    'type'            => 'plain',
    'add_args'        => false,
    'add_fragment'    => ''
  );

  $paginate_links = paginate_links($pagination_args);

  if ($paginate_links) {
		echo '<div class="ui container cd-margem">';
	    echo "<div class='cd-paginacao'>";
	      // echo "<span class='page-numbers page-num'>Página " . $paged . " de " . $numpages . "</span> ";
	      echo $paginate_links;
	    echo "</div>";
		echo "</div>";
  }

}

/* --------------------------

QUERY ARCHIVE TAREFA

---------------------------- */

// function archive_tarefas_query( $query ) {
//
//   if ( $query->is_post_type_archive( 'tarefa' ) && $query->is_main_query() ) {
//
//     $query->set( 'posts_per_page', 50 ); // 50 posts por pagina
//
//   }
// }
//
// add_action( 'pre_get_posts', 'archive_tarefas_query' );

/* --------------------------

LIDO / NAO LIDO

---------------------------- */

function lido_nao_lido($lido = 'cd-lida', $nao_lido = 'cd-nao-lida') {

// table-body / header

	global $current_user;
	$comment = get_comment();

	$interacao_lida = get_comment_meta( $comment->comment_ID, 'interacao_lida', true );

	if (!in_array($current_user->ID, $interacao_lida)) {
		return $nao_lido;
	} else {
		$lido;
	}

}

/* --------------------------

HIGHLIGHT TAREFAS COM COMENTARIOS (MINHAS TAREFAS e MINHAS SOLICITACOES)

---------------------------- */

function comment_nao_lido($nao_lido = 'background:#ebf7ff;') {

global $current_user;
$post_id = get_the_ID();

	if ( !is_archive() && is_user_logged_in() ) {

		// Tira os comentários privados da comparação para usuários Senac
		if ( current_user_can( 'senac' ) ) {
		  $privado = array(
		  'key' => 'privado_interacao',
		  'value' => '1',
		  'compare' => '!=',
		  );
		}

		// Checa se há comentários
		$args = array(
			'number' => '1',
			'post_id' => $post_id,
			'fields' => 'ids',
			'meta_query' => array( $privado )
		);
		$last_comment = get_comments($args);

		if ($last_comment) {

			$interacao_lida = get_comment_meta( $last_comment[0], 'interacao_lida', true );

			if (!in_array($current_user->ID, $interacao_lida)) {
				return $nao_lido;
			}

		}

	}

}

/* --------------------------

MANTER USUARIOS LOGADOS

---------------------------- */

add_filter( 'auth_cookie_expiration', 'keep_me_logged_in_for_1_year' );

function keep_me_logged_in_for_1_year( $expirein ) {
    return 31556926; // 1 year in seconds
}

/* --------------------------

Previne se o usuário for deslogado, suas notificações somem e aparece o botão de login. Em conjunto com o header.php

---------------------------- */

function ajax_check_user_logged_in() {
    echo is_user_logged_in()?'yes':'no';
    die();
}
add_action('wp_ajax_is_user_logged_in', 'ajax_check_user_logged_in');
add_action('wp_ajax_nopriv_is_user_logged_in', 'ajax_check_user_logged_in');

/* --------------------------

NEW TASK

---------------------------- */

function new_task( $new_task = '<span class="ui blue mini label">Nova</span>' ) {

	global $current_user;
	$post_id = get_the_ID();
	$tarefa_lida = get_post_meta( $post_id, 'tarefa_lida', true );

	if ( !is_archive() && current_user_can('edit_pages') ) { // Não exibe na página Todas as Tarefas nem para usuários Senac

		if ($tarefa_lida) {

			if (!in_array($current_user->ID, $tarefa_lida)) {
				echo $new_task;
			}

		} else {
			echo $new_task;
		}

	}

}

// /* --------------------------
//
// NOTIFICACAO NEW TASK
//
// ---------------------------- */
//
// function notificacao_new_task() {
//
// 	// No header.php
//
// 	$response = false;
//
// 	if ( current_user_can('edit_pages') && have_rows('notificacao_new_task', 946) ) :
//
// 		global $current_user;
// 		$row_number = 1;
// 		$new_user = true;
//
// 		while ( have_rows('notificacao_new_task', 946) ) : the_row();
//
// 		  $usuario_registrado = get_sub_field('user_new_task', 946);
// 		  $acesso_registrado = get_sub_field('acesso_new_task', 946);
//
// 		  // Usuário já acessou
// 		  if ( $current_user->ID == $usuario_registrado['ID'] ) {
// 		    $new_user = false;
// 		    $key = $row_number;
// 		    $key_acesso_registrado = $acesso_registrado;
// 		  }
//
// 		  $row_number++;
//
// 		endwhile;
//
// 		// Pega o post mais recente de cada segmentação
// 		include ( locate_template('template-parts/cd-feed.php') );
// 		$args = array(
// 			'numberposts' => 1,
// 			'post_type' => 'tarefa',
// 			'meta_query' => $minhas_tarefas_feed,
// 		);
// 		$recent_posts = wp_get_recent_posts($args);
// 		foreach ( $recent_posts as $recent ) {
// 			$post_recente = get_post_time('YmdHis', '' , $recent["ID"]);
// 		}
// 		wp_reset_query();
//
// 		$acesso = date( 'YmdHis', current_time( 'timestamp', 0 ) );
//
// 		// Row do ACF
// 		$row = array(
// 			'user_new_task'	=> $current_user->ID,
// 			'acesso_new_task'	=> $acesso,
// 		);
//
// 		if ( $new_user == false ) {
// 			if ( is_page(946) ) {
// 				update_sub_field( array('notificacao_new_task', $key, 'acesso_new_task'), $acesso );
// 			}
// 			if ($post_recente > $key_acesso_registrado) {
// 				$response = true;
// 			}
// 		} else {
// 			if ( is_page(946) ) {
// 				$i = add_row('notificacao_new_task', $row, 946);
// 			}
// 		}
//
// 	endif;
//
// 	return $response;
//
// }
//
// function notificacao_new_task_ajax() {
//
// 	echo notificacao_new_task();
//
// 	wp_die();
//
// }
//
// add_action('wp_ajax_notificacao_new_task_ajax', 'notificacao_new_task_ajax');
// add_action('wp_ajax_nopriv_notificacao_new_task_ajax', 'notificacao_new_task_ajax');

/* --------------------------

NEW TASK PUSH

---------------------------- */

function new_task_push() {

	include ( locate_template('template-parts/cd-feed.php') );

	$query = new WP_Query(
		array(
			'post_type' => 'tarefa',
			'meta_query' => $minhas_tarefas_feed,
		)
	);

	$response = $query->found_posts;

	echo $response;

	wp_die();

}

add_action('wp_ajax_new_task_push', 'new_task_push');
add_action('wp_ajax_nopriv_new_task_push', 'new_task_push');

/* --------------------------

USUARIO LOGADO AJAX

---------------------------- */

function usuario_logado() {

	if ( current_user_can('edit_pages') ) {
		$response = 'edit_pages';
	} elseif (current_user_can('senac')) {
		$response = 'senac';
	}

	echo $response;

	wp_die();

}

add_action('wp_ajax_usuario_logado', 'usuario_logado');
add_action('wp_ajax_nopriv_usuario_logado', 'usuario_logado');

/* --------------------------

BOTÃO PARTICIPAR DESTA SOLICITAÇÃO AJAX

---------------------------- */

function participante() {

	global $current_user;
	$current_user_id = strval($current_user->ID); //converting to string just in case (importante)

	$post_id = $_REQUEST['post_id'];
	$post = get_post($post_id);
	$author_id = $post->post_author;
	$participantes_ids = get_field('field_59af2418778aa', $post_id, false);

	// CHECA SE O USUARIO LOGADO É O AUTOR
	if ($author_id != $current_user_id) $nao_autor = true;

	// CHECA SE O USUÁRIO LOGADO ESTÁ COMO PARTICIPANTE / SE NAO HÁ PARTICIPANTES
	if ($participantes_ids && !in_array($current_user_id, $participantes_ids)) $nao_participante = true;
	if (!$participantes_ids) $nao_participante = true;

	if ($nao_autor && $nao_participante) :

		if (!is_array($participantes_ids)) {
	      $participantes_ids = array();
	  }
		$participantes_ids[] = $current_user_id; // add the users ID to the array
		update_field('field_59af2418778aa', $participantes_ids, $post_id);
		$response = 'yes';

	elseif ($nao_autor  && !$nao_participante):
		$response = 'participante';

	elseif (!$nao_autor  && $nao_participante):
		$response = 'author';

	elseif (!$nao_autor  && !$nao_participante):
		$response = 'participante';

	endif;

	// PARA SAIR
	if ($_REQUEST['sair'] == true) :
		$array_diff = array_diff($participantes_ids, array($current_user_id));
		update_field('field_59af2418778aa', $array_diff, $post_id);
		$response = 'sair';
	endif;

	echo $response;

	wp_die();

}

add_action('wp_ajax_participante', 'participante');
add_action('wp_ajax_nopriv_participante', 'participante');

/* --------------------------

FORM TAREFA - GET CURSO

---------------------------- */

function get_curso() {

	$post_id = $_REQUEST['post_id'];
	$post = get_post($post_id);

	if ($post_id) {

		$modalidade = get_field('modalidade', $post_id);
		$titulo = $post->post_title;
		$area = get_field('area', $post_id);
		$subarea = get_field('subarea-' . $area, $post_id);
		$link = get_the_permalink($post_id);
		$imagem_curso = get_the_post_thumbnail_url($post_id);

		$response = json_encode(
			array(
				'modalidade' => $modalidade,
				'titulo' => $titulo,
				'area' => $area,
				'link' => $link,
				'imagem' => $imagem_curso,
				'subarea' => $subarea)
			);

	} else {

		$response = false;

	}

	echo $response;

	wp_die();

}

add_action('wp_ajax_get_curso', 'get_curso');
add_action('wp_ajax_nopriv_get_curso', 'get_curso');

/* --------------------------

FORM-TAREFA - COLOCA O POST ID (GET) COMO VALOR NO SELECT2

---------------------------- */

function my_acf_prepare_field( $field ) {

	// Somente na página do form tarefa
	if ( is_page(168) && isset($_GET['post_id']) ) {
		$post_id = $_GET['post_id'];
		$field['value'] = $post_id;
	}

	return $field;

}

add_filter('acf/prepare_field/name=catalogo_de_pecas', 'my_acf_prepare_field');

/* --------------------------

BASIC UPLOADER

---------------------------- */

// force basic uploader for a certain field
function my_acf_force_basic_uploader( $field ) {

    // don't do this on the backend
    if(is_admin()) return $field;

    // set the uploader setting before rendering the field
    acf_update_setting('uploader', 'basic');

    // return the field data
    return $field;

}

// target the field using its name
add_filter('acf/prepare_field/name=arquivo_interacao', 'my_acf_force_basic_uploader');

/* --------------------------

NOTIFICAÇÃO EMAIL - NOVA SOLICITACAO

---------------------------- */

add_action('acf/save_post', 'my_save_post', 20);

function my_save_post( $post_id ) {

	// bail early if not a contact_form post
	if( get_post_type($post_id) !== 'tarefa' ) {
		return;
	}

	// bail early if editing in admin
	if( is_admin() || !is_page(168) ) {
		return;
	}

	$post = get_post( $post_id );

	global $current_user; get_currentuserinfo();
	$name = $current_user->user_firstname . ' ' . $current_user->user_lastname;
	$email = $current_user->user_email;
	$finalidade = get_field('finalidade', $post_id);
	$unidade = get_field('unidade', $post_id);

	$destinos = array();

	//SEGMENTAÇÃO

	$segmentacao = get_field('segmentacao', $post_id);

	if ($segmentacao) {

		//DESIGNERS GD2 E GD4
		if( in_array('gd2_gd4', $segmentacao) || $segmentacao == 'gd2_gd4' ) {

			$designers = get_users('role=designer_gd2_gd4');

			foreach ( $designers as $designer ) {

						if ( get_field('receber_notificacoes_por_email', 'user_' . $designer->ID) ) {

							// $array_designers[] = $designer->user_email;
							array_push($destinos, $designer->user_email);

						}

			}

			}
			//DESIGNERS GD1 E GD3
			if( in_array('gd1_gd3', $segmentacao) || $segmentacao == 'gd1_gd3' ) {

			$designers = get_users('role=designer_gd1_gd3');

			foreach ( $designers as $designer ) {

						if ( get_field('receber_notificacoes_por_email', 'user_' . $designer->ID) ) {

							// $array_designers[] = $designer->user_email;
							array_push($destinos, $designer->user_email);

						}

			}

			}
			//DESIGNERS INSTITUCIONAL
			if( in_array('institucional', $segmentacao) || $segmentacao == 'institucional' ) {

			$designers = get_users('role=designer_institucional');

			foreach ( $designers as $designer ) {

						if ( get_field('receber_notificacoes_por_email', 'user_' . $designer->ID) ) {

							// $array_designers[] = $designer->user_email;
							array_push($destinos, $designer->user_email);

						}

			}

			}
			//PORTAL
			if( in_array('evento', $segmentacao) || $segmentacao == 'evento' ) {

			$designers = get_users('role=portal');

			foreach ( $designers as $designer ) {

						if ( get_field('receber_notificacoes_por_email', 'user_' . $designer->ID) ) {

							// $array_designers[] = $designer->user_email;
							array_push($destinos, $designer->user_email);

						}

			}

			}

			//REDES SOCIAIS
			if( in_array('redes_sociais', $segmentacao) || $segmentacao == 'redes_sociais' ) {

			$designers = get_users('role=redes_sociais');

			foreach ( $designers as $designer ) {

						if ( get_field('receber_notificacoes_por_email', 'user_' . $designer->ID) ) {

							// $array_designers[] = $designer->user_email;
							array_push($destinos, $designer->user_email);

						}

			}

			}

		}

	// $destinos = array_merge($destinos, $array_designers);

	//Checa cada item do array $destinos e compara com o $email (email do usuário logado). Se o email for diferente, insere no $to.

	$to = array();

	foreach ($destinos as $d) {

		if ($email != $d) {

			array_push($to, $d);

		}

	}

	$headers = 'From: ' . $name . ' <' . $email . '>' . "\r\n";
	$subject = $unidade . ' | ' . $post->post_title;
	$body =
	'<h2>[Nova solicitação]</h2><br>' .
	'<strong>' . '> Para visualizar, acesse: </strong>' . get_post_permalink($post_id) .
	'<br><br><br>' .
	'<hr>' .
	'Para ativar ou desativar as notificações por e-mail, clique <a href="http://cd.intranet.sp.senac.br/meu-perfil/">aqui</a>.';

	// send email
	wp_mail($to, $subject, $body, $headers );

	// }

}

// /* --------------------------
//
// NOTIFICAÇÃO EMAIL - STATUS UPDATE PARA O AUTOR E PARTICIPANTE
//
// ---------------------------- */

add_filter('acf/update_value/name=status', 'check_status_change', 10, 3);

function check_status_change($value, $post_id, $field) {

	global $current_user; get_currentuserinfo();
	$name = $current_user->user_firstname . ' ' . $current_user->user_lastname;
	$email = $current_user->user_email;

	$post = get_post( $post_id );
	$user = get_user_by( 'id', $post->post_author );

	$post_title = get_the_title( $post_id );
	$post_url = get_permalink( $post_id );
	$unidade = get_field('unidade', $post_id);
	//$status = get_field('status', $post_id);

  $old_value = get_post_meta($post_id, 'status', true);

  $participantes = get_field('participante', $post_id);

	$destinos = array();

	//AUTOR

	$author_email = $user->user_email;

	if ( get_field('receber_notificacoes_por_email', 'user_' . $user->ID) ) {

		array_push($destinos, $author_email);

	}

	//PARTICIPANTES

	$participantes = get_field('participante', $post_id);

	if( $participantes ) {

		foreach( $participantes as $participante ) {

			if ( get_field('receber_notificacoes_por_email', 'user_' . $participante['ID']) ) {

					// $array_participantes[] = $participante['user_email'];
					array_push($destinos, $participante['user_email']);

			}

		}

	}

	//Checa cada item do array $destinos e compara com o $email (email do usuário logado). Se o email for diferente, insere no $to.

	$to = array();

	foreach ($destinos as $d) {

		if ($email != $d) {

			array_push($to, $d);

		}

	}

  if ( $old_value != $value ) {

		$headers = 'From: ' . $name . ' <' . $email . '>' . "\r\n";
		$subject = $unidade . ' | ' . $post_title;
		$message =
		'<h2>[Status atualizado]</h2><br>' .
		//'<strong>Status atual: </strong><br> ' . $status_label . '<br><br><br>' .
		'<strong>' . '> Referente à solicitação: </strong>' . $unidade . ' | ' . $post_title . '<br>' .
		'<strong>' . '> Para visualizar, acesse: </strong>' . $post_url .
		'<br><br><br>' .
		'<hr>' .
		'Para ativar ou desativar as notificações por e-mail, clique <a href="http://cd.intranet.sp.senac.br/meu-perfil/">aqui</a>.';

		wp_mail( $to , $subject, $message, $headers );

  }

  return $value;

}

/* --------------------------

NOTIFICAÇÃO EMAIL POST NOVO/UPDATE - GERAL (TAREFAS)

---------------------------- */

// add_action( 'save_post', 'my_project_updated_send_email' );
//
// function my_project_updated_send_email( $post_id ) {
//
// 	// Não executa se a edição for feita no admin
// 	if ( is_admin() ) {
// 		return;
// 	}
//
// 	// Não executa se o post_type não é tarefa
// 	if( get_post_type($post_id) !== 'tarefa' ) {
// 		return;
// 	}
//
// 	global $current_user; get_currentuserinfo();
// 	$name = $current_user->user_firstname . ' ' . $current_user->user_lastname;
// 	$email = $current_user->user_email;
//
// 	$post = get_post( $post_id );
// 	$author = get_user_by( 'id', $post->post_author );
// 	$to = $author->user_email;
//
// 	$post_title = get_the_title( $post_id );
// 	$post_url = get_permalink( $post_id );
// 	$unidade = get_field('unidade', $post_id);
// 	$notificacaoEmail = get_field('receber_notificacoes_por_email', 'user_' . $author->ID);
//
// 	// Não envia se o e-mail do usuário logado = e-mail do autor do post
// 	if( $email == $to ) {
// 		return;
// 	}
//
// 		if ( !wp_is_post_revision( $post_id ) && $notificacaoEmail ) {
//
// 				$headers = 'From: ' . $name . ' <' . $email . '>' . "\r\n";
// 				$subject = $unidade . ' | ' . $post_title;
//
// 				$message = '<h2>Nova interação / atualização</h2><br>' .
// 				'<strong>Título: </strong>' . $post_title . '<br>' .
// 				'<strong>Visualizar: </strong>' . $post_url . '<br><br><br>' .
// 				'<hr>' .
// 				'Para ativar ou desativar as notificações por e-mail, clique <a href="http://cd.intranet.sp.senac.br/meu-perfil/">aqui</a>.';
//
// 				wp_mail( $to , $subject, $message, $headers );
// 		}
// }

/* --------------------------

NOTIFICAÇÃO EMAIL - COMENTÁRIOS

---------------------------- */

add_filter( 'comment_post', 'comment_notification_email' );

function comment_notification_email( $comment_id ) {

	// Current user
	global $current_user; get_currentuserinfo();
	$name = $current_user->user_firstname . ' ' . $current_user->user_lastname;
	$email = $current_user->user_email;
	// Comment
	$comment = get_comment( $comment_id );
	$interacao_privada = get_field('privado_interacao', $comment);
	// Post
	$post = get_post( $comment->comment_post_ID );
	$post_url = get_permalink( $post->ID );
	$unidade = get_field('unidade', $post);
	// Author
	$user = get_user_by( 'id', $post->post_author );
	$author_email = $user->user_email;
	$author_notificacao = get_field('receber_notificacoes_por_email', 'user_' . $user->ID);

	$destinos = array();

	// NOTIFICACAO PARA O AUTOR

	if ($author_notificacao) {

		if (in_array('senac', $user->roles)) {

			if (!$interacao_privada) {

				array_push($destinos, $author_email);

			}

		} else {

			array_push($destinos, $author_email);

		}

	}

		//SEGMENTAÇÃO

		$segmentacao = get_field('segmentacao', $post);

		if ($segmentacao) {

			//DESIGNERS GD2 E GD4
			if( in_array('gd2_gd4', $segmentacao) || $segmentacao == 'gd2_gd4' ) {

				$designers = get_users('role=designer_gd2_gd4');

				foreach ( $designers as $designer ) {

	        		if ( get_field('receber_notificacoes_por_email', 'user_' . $designer->ID) ) {

	        			// $array_designers[] = $designer->user_email;
								array_push($destinos, $designer->user_email);

	        		}

				}

	  		}
	  		//DESIGNERS GD1 E GD3
	  		if( in_array('gd1_gd3', $segmentacao) || $segmentacao == 'gd1_gd3' ) {

				$designers = get_users('role=designer_gd1_gd3');

				foreach ( $designers as $designer ) {

	        		if ( get_field('receber_notificacoes_por_email', 'user_' . $designer->ID) ) {

	        			// $array_designers[] = $designer->user_email;
								array_push($destinos, $designer->user_email);

	        		}

				}

	  		}
	  		//DESIGNERS INSTITUCIONAL
	  		if( in_array('institucional', $segmentacao) || $segmentacao == 'institucional' ) {

				$designers = get_users('role=designer_institucional');

				foreach ( $designers as $designer ) {

	        		if ( get_field('receber_notificacoes_por_email', 'user_' . $designer->ID) ) {

	        			// $array_designers[] = $designer->user_email;
								array_push($destinos, $designer->user_email);

	        		}

				}

	  		}
	  		//PORTAL
	  		if( in_array('evento', $segmentacao) || $segmentacao == 'evento' ) {

				$designers = get_users('role=portal');

				foreach ( $designers as $designer ) {

	        		if ( get_field('receber_notificacoes_por_email', 'user_' . $designer->ID) ) {

	        			// $array_designers[] = $designer->user_email;
								array_push($destinos, $designer->user_email);

	        		}

				}

	  		}

				//REDES SOCIAIS
				if( in_array('redes_sociais', $segmentacao) || $segmentacao == 'redes_sociais' ) {

				$designers = get_users('role=redes_sociais');

				foreach ( $designers as $designer ) {

							if ( get_field('receber_notificacoes_por_email', 'user_' . $designer->ID) ) {

								// $array_designers[] = $designer->user_email;
								array_push($destinos, $designer->user_email);

							}

				}

				}

  		}

		//PARTICIPANTES

		$participantes = get_field('participante', $post);

		if( $participantes ) {

			foreach( $participantes as $participante ) {

				if ( get_field('receber_notificacoes_por_email', 'user_' . $participante['ID']) ) {

					$user_meta = get_userdata($participante['ID']);
					$user_role = $user_meta->roles;

					if (in_array('senac', $user_role)) {

						if (!$interacao_privada) {

							// $array_participantes[] = $participante['user_email'];
							array_push($destinos, $participante['user_email']);

						}

					} else {

						// $array_participantes[] = $participante['user_email'];
						array_push($destinos, $participante['user_email']);

					}

				}

			}

		}

		//Checa cada item do array $destinos e compara com o $email (email do usuário logado). Se o email for diferente, insere no $to.

		$to = array();

		foreach ($destinos as $d) {

			if ($email != $d) {

				array_push($to, $d);

			}

		}


		$subject = $unidade . ' | ' . $post->post_title;
		$message =
		'<h2>[Nova interação]</h2><br>' .
		'<strong>' . $name . '</strong>' . ' disse:<br>' . '<em>' . $comment->comment_content . '</em>' . '<br><br><br>' .
		'<strong>' . '> Referente à solicitação: </strong>' . $unidade . ' | ' . $post->post_title . '<br>' .
		'<strong>' . '> Para responder, acesse: </strong>' . $post_url .
		'<br><br><br>' .
		'<hr>' .
		'Para ativar ou desativar as notificações por e-mail, clique <a href="http://cd.intranet.sp.senac.br/meu-perfil/">aqui</a>.';

		$headers = 'From: ' . $name . ' <' . $email . '>' . "\r\n";

		wp_mail( $to, $subject, $message, $headers );



}

/* --------------------------

NUMERO DE INTERACOES (PRIVADAS)

---------------------------- */

function num_comentarios($text = true, $post_id = 0) {

	if ($post_id == 0) {
		$post_id = get_the_ID();
	}

	if ( current_user_can('senac') || !is_user_logged_in() ) {
	  $privado = array(
	  'key' => 'privado_interacao',
	  'value' => '1',
	  'compare' => '!=',
	  );
	}

	$args = array(
	  'post_id' => $post_id, // use post_id, not post_ID
	  'count' => true, //return only the count
	  'meta_query' => array( $privado )
	);

	$comments = get_comments($args);

	if ($text) {

	  if ( $comments == 0 ) {
	    $comments = __('0 INTERAÇÕES');
	  } elseif ( $comments > 1 ) {
	    $comments = $comments . __(' INTERAÇÕES');
	  } else {
	    $comments = __('1 INTERAÇÃO');
	  }

	}

	echo $comments;

}

/* --------------------------

PAGE REDIRECT AFTER POST TRASHED

---------------------------- */

add_action('trashed_post','my_trashed_post_handler',10,1);

function my_trashed_post_handler($post_id) {
	$url = get_option('siteurl') . '/solicitacao-excluida';
  wp_redirect($url);
  exit;
}

/* --------------------------

ACF AVATAR

---------------------------- */

/**
 * Use ACF image field as avatar
 * @author Mike Hemberger
 * @link http://thestizmedia.com/acf-pro-simple-local-avatars/
 * @uses ACF Pro image field (tested return value set as Array )
 */
add_filter('get_avatar', 'tsm_acf_profile_avatar', 10, 5);
function tsm_acf_profile_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    $user = '';

    // Get user by id or email
    if ( is_numeric( $id_or_email ) ) {
        $id   = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );
    } elseif ( is_object( $id_or_email ) ) {
        if ( ! empty( $id_or_email->user_id ) ) {
            $id   = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }
    } else {
        $user = get_user_by( 'email', $id_or_email );
    }
    if ( ! $user ) {
        return $avatar;
    }
    // Get the user id
    $user_id = $user->ID;
    // Get the file id
    $image_id = get_user_meta($user_id, 'foto', true); // CHANGE TO YOUR FIELD NAME
    // Bail if we don't have a local avatar
    if ( ! $image_id ) {
        return $avatar;
    }
    // Get the file size
    $image_url  = wp_get_attachment_image_src( $image_id, 'thumbnail' ); // Set image size by name
    // Get the file url
    $avatar_url = $image_url[0];
    // Get the img markup
    $avatar = '<img alt="' . $alt . '" src="' . $avatar_url . '" class="avatar avatar-' . $size . '" height="' . $size . '" width="' . $size . '"/>';
    // Return our new avatar
    return $avatar;
}

/* --------------------------

CONVERTER STRING EM HTML, IGNORANDO AS TAGS HTML

---------------------------- */

/**
 * @link https://stackoverflow.com/questions/1364933/htmlentities-in-php-but-preserving-html-tags
 */

function convert_string_to_html($string = 0) {
	echo htmlspecialchars_decode(htmlentities($string, ENT_NOQUOTES, 'UTF-8', false), ENT_NOQUOTES);
}

/* --------------------------

SALVAR EMAIL CRIADO

---------------------------- */

function salvar_email() {

	$post_id = $_REQUEST['post_id'];

	update_post_meta( $post_id, 'save_imagem', $_REQUEST['save_imagem'] );
	update_post_meta( $post_id, 'save_fundo', $_REQUEST['save_fundo'] );
	update_post_meta( $post_id, 'save_botao', $_REQUEST['save_botao'] );
	update_post_meta( $post_id, 'save_linha', $_REQUEST['save_linha'] );
	update_post_meta( $post_id, 'save_texto', $_REQUEST['save_texto'] );
	update_post_meta( $post_id, 'save_assinatura', $_REQUEST['save_assinatura'] );

	// echo $response;

	wp_die();

}

add_action('wp_ajax_salvar_email', 'salvar_email');
add_action('wp_ajax_nopriv_salvar_email', 'salvar_email');

/* --------------------------

REDIRECT AO POSTAR COMENTARIO

---------------------------- */

add_action( 'comment_post', 'cd_comment_post_redirect', 10, 2 );
function cd_comment_post_redirect( $comment_ID ) {
	wp_safe_redirect( $_SERVER["HTTP_REFERER"] . '/?comment_id=' . $comment_ID );
	exit;
}

/* --------------------------

TITULO PATROCINIO POSTS

---------------------------- */

function titulo_patrocinio( $post_id ) {

	$finalidade = get_field('finalidade', $post_id);

	if ( $finalidade['value'] == 'patrocinio-rs'  ) {

		if (get_the_title($post_id) == '') {

			// get_field('area_divulgacao_tarefa', $post_id)

	    $new_title = 'Patrocínio #' . $post_id;
	    $new_slug = sanitize_title( $new_title );
	    $my_post = array(
	    	'ID'         => $post_id,
	        'post_title' => $new_title,
	        'post_name'  => $new_slug
			);
			wp_update_post( $my_post );

		}

		if (get_field('area_divulgacao_tarefa', $post_id) == '') {
			update_field('area_divulgacao_tarefa', 'campanhas', $post_id);
		}

	}

}
add_action('acf/save_post', 'titulo_patrocinio', 20);

/* --------------------------

POSTS EM ANALISE POR MAIS DE 2 DIAS

---------------------------- */

function cd_date_diff($date_1 , $date_2) {

	$status = get_field('status');

	if (current_user_can('edit_pages') && $status['value'] == 'naoiniciado') :

		$date_1 = date('Y-m-d', strtotime(get_the_date('Y-m-d'))); // post date
		$date_2 = date('Y-m-d', time()); // current date

    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);

    $days = $interval->format('%a');

		if ($days >= 2) {
			return array('bg' => 'background: #fffbe2;', 'icon' => '<i class="yellow warning sign icon cd-popup" title="Mais de 2 dias em análise" data-variation="very wide mini inverted"></i>' );
		}

	endif;

}

// /* --------------------------
//
// LOGIN OBRIGATORIO PARA TODOS OS USUARIOS
//
// ---------------------------- */
//
// function my_page_template_redirect()  {
//
//   if( !is_user_logged_in() ) {
//     wp_safe_redirect( wp_login_url() );
// 		exit;
//   }
//
// }
//
// add_action( 'template_redirect', 'my_page_template_redirect' );

/* --------------------------

MUDA O DIRETORIO DE UPLOAD

---------------------------- */

// // Form Eventos
// add_filter( 'acf/upload_prefilter/key=field_58d1a963b78a1', 'tarefa_upload_prefilter' );
// add_filter( 'acf/prepare_field/key=field_58d1a963b78a1', 'tarefa_files_field_display' );
//
// // Form Arquivos
// add_filter( 'acf/upload_prefilter/key=field_5787cc9506c2a', 'tarefa_upload_prefilter' );
// add_filter( 'acf/prepare_field/key=field_5787cc9506c2a', 'tarefa_files_field_display' );
//
// // Form Arquivos Extras
// add_filter( 'acf/upload_prefilter/key=field_593171bcfcd36', 'tarefa_upload_prefilter' );
// add_filter( 'acf/prepare_field/key=field_593171bcfcd36', 'tarefa_files_field_display' );
//
// // Arquivos Peças
// add_filter( 'acf/upload_prefilter/key=field_59418cee932b4', 'tarefa_upload_prefilter' );
// add_filter( 'acf/prepare_field/key=field_59418cee932b4', 'tarefa_files_field_display' );
//
// function tarefa_upload_prefilter( $errors ) {
//
//   add_filter( 'upload_dir', 'tarefa_upload_directory' );
//
//   return $errors;
//
// }
//
// function tarefa_upload_directory( $param ) {
//
// 	// $id = $_REQUEST['post_id']; // Pega o ID da página do form, ao invés do post (problema)
// 	// $slug = get_post( $id )->post_name; // Pega o nome da página do form, ao invés do post (problema)
//   // $folder = '/tarefas_uploads' . '/' . $slug; // Cria o diretório co, o nome da página do form, ao invés do post (problema)
//
// 	$folder = '/tarefas_uploads';
//
// 	$param['path'] = $param['basedir'] . $folder;
//   $param['url'] = $param['baseurl'] . $folder;
//   $param['subdir'] = '/';
//
// 	return $param;
//
// }
//
// function tarefa_files_field_display( $field ) {
//
//   // update paths accordingly before displaying link to file
//   add_filter( 'upload_dir', 'tarefa_upload_directory' );
//
//   return $field;
//
// }


/* --------------------------

REDUZ O TITULO TAREFA

---------------------------- */

// function max_title_length( $title ) {
// $max = 40;
// 	if( get_post_type($post_id) == 'tarefa' && strlen( $title ) > $max ) {
// 	return substr( $title, 0, $max ). " &hellip;";
// 	} else {
// 	return $title;
// 	}
// }
//
// add_filter( 'the_title', 'max_title_length');


/* --------------------------

DESABILITA O CSS DO ACF FORM NO FRONT-END

---------------------------- */

// add_action( 'wp_print_styles', 'my_deregister_styles', 100 );
//
// function my_deregister_styles() {
//   wp_deregister_style( 'acf' );
//   wp_deregister_style( 'acf-field-group' );
//   wp_deregister_style( 'acf-global' );
//   wp_deregister_style( 'acf-input' );
//   wp_deregister_style( 'acf-datepicker' );
// }

/* --------------------------

FIM

---------------------------- */
