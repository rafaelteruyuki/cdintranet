<?php

// Imagem destacada
add_theme_support( 'post-thumbnails' );

// Adiciona o tamanho das imagens ao tema
add_image_size('redes-sociais', '400', '210', true);

// Registrar menu no tema
register_nav_menu( 'main-menu', 'Menu principal do tema que vai no header' );

// Carrega os styles
wp_enqueue_style( 'style', get_stylesheet_uri()); //style.css
//wp_enqueue_style( 'semantic', get_template_directory_uri() . '/css/semantic.min.css',false,'1.1','all');
//CONFLITO COM O CSS DO ACF NO BACK-END
wp_enqueue_style( 'form-solicitacao', get_template_directory_uri() . '/css/form-solicitacao.css',false,'1.1','all');
wp_enqueue_style( 'main', get_template_directory_uri() . '/css/main.css',false,'1.1','all');
wp_enqueue_style( 'popup', get_template_directory_uri() . '/components/popup.css',false,'1.1','all');

// Inside the functions.php file
//PostType::make('cpt-slug', 'PluralName', 'SingularName')->set(['public' => true]);

// Carrega scripts
add_action('wp_enqueue_scripts', 'carrega_scripts');

function carrega_scripts() {
	wp_enqueue_script('custom-js', get_template_directory_uri()."/js/scripts.js", array('jquery'), false, true);
	//scripts do Semantic
	//wp_enqueue_script( 'semantic-js', get_template_directory_uri() . '/js/semantic.min.js', array('jquery'), '', true );
	//wp_enqueue_script( 'tablesort', get_template_directory_uri() . '/js/tablesort.js', array('jquery'), '', true );
	//wp_enqueue_script( 'mustache', get_template_directory_uri() . '/js/mustache.js', array('jquery'), '', true );
	wp_enqueue_script( 'main-js', get_template_directory_uri()."/js/main.js", array('jquery'), false, true);

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

CUSTOM ROLE - DESIGNER

---------------------------- */

add_role( 'designer', 'Designer', array(
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

CUSTOM ROLE - DESIGNER GD2 e GD4

---------------------------- */

add_role( 'designer_gd2_gd4', 'Designer GD2/GD4', array(
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

					// Registra o acesso
					$acesso = date( 'YmdHis', current_time( 'timestamp', 0 ) );
					$row = array(
						'usuario'	=> $current_user->user_login,
						'acesso'	=> $acesso,
					);
					$i = add_row('visitas', $row, $post_id);

				}

    // Update the post into the database - Se não não atualiza o cache do Search & Filter
    wp_update_post( $my_post );

		// Salva o the_modified_author, pois o ACF form não salva o meta_value da meta_key _edit_last
		update_post_meta( $post_id, '_edit_last', $current_user->ID );

		// Atualizar feed == checked
		global $wpdb;
		$wpdb->query($wpdb->prepare("UPDATE wp_usermeta SET meta_value=1 WHERE meta_key='atualizar_feed'", ''));

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

	function verifica_atualizacao() {

		global $current_user;
		$atualizar_feed = get_field('atualizar_feed', 'user_'. $current_user->ID );
		echo $atualizar_feed;
    wp_die();

	}
	add_action('wp_ajax_verifica_atualizacao', 'verifica_atualizacao');
	add_action('wp_ajax_nopriv_verifica_atualizacao', 'verifica_atualizacao');

	function carrega_loop (){

	  global $current_user;
		$response;
	  // $atualizar_feed = get_field('atualizar_feed', 'user_'. $current_user->ID );

			include ( locate_template('template-parts/cd-feed.php') );

			$args = array(
				'post_type'              => 'tarefa',
				'posts_per_page'         => 31,
				'order'                  => 'DESC',
				'orderby'                => 'modified',
				'author'                 => $feed_rc,
				'meta_query'             => array( $feed_cd ),
			);

			$query = new WP_Query( $args );

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) { $query->the_post();

					include ( locate_template('template-parts/var-tarefas.php') );

					if ( get_post_meta(get_post()->ID, '_edit_last') ) {
						$author = ', por ' . get_the_modified_author();
					};

					$response .= '<a href="'. get_the_permalink() .'" class="item '. get_lido_nao_lido('feed-lido', 'feed-nao-lido').'" style="border-top: 1px solid #dedede !important;">';
					$response .= '<strong style="line-height: 2;">'.get_field('unidade').'&nbsp;&nbsp;|&nbsp;&nbsp;'.get_the_title().'</strong><br>';
					$response .= '<span class="cd-disabled">';
					$response .= '<i class="green refresh icon"></i> Há '. human_time_diff(get_the_modified_time('U'), current_time('timestamp')) . $author;
					$response .= '<br><i class="purple comments icon"></i>'. get_comments_number() . ' interações' . '<br>';
					$response .= '<i class="power icon"></i>' . $status['label'] . '</span></a>';

				}

				if( current_user_can( 'edit_pages' )){
					$response .= '<a href="http://cd.intranet.sp.senac.br/minhas-tarefas/" class="item" style="text-align: center; padding: 20px !important; border-top: 1px solid #dedede !important;"><strong>Ver todas</strong></a>';
				}else{
					$response .= '<a href="http://cd.intranet.sp.senac.br/minhas-solicitacoes/" class="item" style="text-align: center; padding: 20px !important; border-top: 1px solid #dedede !important;"><strong>Ver todas</strong></a>';
				}

			}else{
				$response = '<div class="item"><i class="grey refresh icon"></i>Não há notificações</div>';
			}
			wp_reset_postdata();


		update_field( 'field_595feb818431d', false,'user_' . $current_user->ID); // Atualizar feed == unchecked

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

function get_lido_nao_lido($lido = 'cd-lida', $nao_lido = 'cd-nao-lida') {

// table-body / header

	global $current_user;

	$modificado = get_the_modified_time('YmdHis');
	$comment_modificado = get_comment_time('YmdHis');
	$comment = get_comment( $comment_id );
	$post_id = get_post( $comment->comment_post_ID );

	$usuario_registrado = array();
	$acesso_registrado = array();

	if( have_rows('visitas', $post_id) ):

	    while ( have_rows('visitas', $post_id) ) : the_row();

	        $usuario_registrado[] = get_sub_field('usuario', $post_id); // Array usuários registrados
	        $acesso_registrado[] = get_sub_field('acesso', $post_id); // Array acessos registrados

	    endwhile;

	endif;

	$key = array_search($current_user->user_login, $usuario_registrado); // Procura a posição no array de usuários registrados

  if ( is_user_logged_in() ) {

    // se existir a key do usuário, executa a função
    if ($key !== false) {

      if ($comment_modificado > $acesso_registrado[$key]) {
        return $nao_lido;
      } else {
        return $lido;
      };

      // se não, coloca como não visualizado
    } else {
      return $nao_lido;
    };

  };

};

function lido_nao_lido($lido = 'cd-lida', $nao_lido = 'cd-nao-lida') {

	$lido_nao_lido = get_lido_nao_lido($lido, $nao_lido);

	echo apply_filters( 'filtro', $lido_nao_lido, $lido, $nao_lido );
}

function lido_nao_lido_single() {

	// No header.php e na função my_acf_save_post

	if ( is_user_logged_in() &&  is_singular( 'tarefa' ) ) {

	global $current_user;

	$modificado = get_the_modified_time('YmdHis');
	$acesso = date( 'YmdHis', current_time( 'timestamp', 0 ) );

	// Row do ACF
	$row = array(
		'usuario'	=> $current_user->user_login,
		'acesso'	=> $acesso,
	);

	// Declara os arrays
	$usuario_registrado = array();
	$acesso_registrado = array();

	// Transforma as rows em array que possam ser acessados fora do loop
	if( have_rows('visitas') ):

			while ( have_rows('visitas') ) : the_row();

					$usuario_registrado[] = get_sub_field('usuario');
					$acesso_registrado[] = get_sub_field('acesso');

			endwhile;

	endif;

	// Faz a key do array começar em 1, não em 0, pq a row do ACF começa em 1. O número da key do usuário é igual ao número da row onde ele está inserido
	array_unshift($usuario_registrado,"");
	unset($usuario_registrado[0]);

		// Procura o usuário no array de usuários registrados
		if ( in_array($current_user->user_login, $usuario_registrado) ) {

			// Identifica sua posição (key) no array
			$key = array_search($current_user->user_login, $usuario_registrado);
			$row_number = $key;

			// Como ele já está registrado, apenas atualiza seu acesso na row dele
			update_row('visitas', $row_number, $row);

		} else {
			// Se não acessou nunca, uma row é criada para ele
			$i = add_row('visitas', $row);
		};

	};

};

/* --------------------------

HIGHLIGHT TAREFAS COM COMENTARIOS (MINHAS TAREFAS e MINHAS SOLICITACOES)

---------------------------- */

function comment_nao_lido($nao_lido = 'background:#ebf7ff;', $comment_privado) {

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
			'meta_query' => array( $privado )
		);
		$comments = get_comments($args);

		if ($comments) {

			// Checa se há visita e quem visitou
			if( have_rows('visitas', $post_id) ) {

				while ( have_rows('visitas', $post_id) ) {
					the_row();
					$usuario_registrado[] = get_sub_field('usuario', $post_id); // Array usuários registrados
					$acesso_registrado[] = get_sub_field('acesso', $post_id); // Array acessos registrados
				}

				$key = array_search($current_user->user_login, $usuario_registrado); // Procura a posição no array de usuários registrados

				// Usuário logado visitou
				if ($key !== false) {

					// Faz a comparação com o último comentário
					foreach($comments as $comment) {

						$last_comment_time = get_comment_date('YmdHis', $comment->comment_ID);

						if ($last_comment_time > $acesso_registrado[$key]) {
							return $nao_lido;
						}

					}

				}

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

	if ( !is_archive() && current_user_can('edit_pages') ) { // Não exibe na página Todas as Tarefas nem para usuários Senac

	  if ( have_rows('visitas', $post_id) ) {
	      while ( have_rows('visitas', $post_id) ) { the_row();
	          $usuario_registrado[] = get_sub_field('usuario', $post_id);
	          $acesso_registrado[] = get_sub_field('acesso', $post_id);
	      }

	    // Procura o usuário no array de usuários registrados
	    if ( !in_array($current_user->user_login, $usuario_registrado) ) {
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

							$array_designers[] = $designer->user_email;

						}

			}

			}
			//DESIGNERS GD1 E GD3
			if( in_array('gd1_gd3', $segmentacao) || $segmentacao == 'gd1_gd3' ) {

			$designers = get_users('role=designer_gd1_gd3');

			foreach ( $designers as $designer ) {

						if ( get_field('receber_notificacoes_por_email', 'user_' . $designer->ID) ) {

							$array_designers[] = $designer->user_email;

						}

			}

			}
			//DESIGNERS INSTITUCIONAL
			if( in_array('institucional', $segmentacao) || $segmentacao == 'institucional' ) {

			$designers = get_users('role=designer_institucional');

			foreach ( $designers as $designer ) {

						if ( get_field('receber_notificacoes_por_email', 'user_' . $designer->ID) ) {

							$array_designers[] = $designer->user_email;

						}

			}

			}
			//PORTAL
			if( in_array('evento', $segmentacao) || $segmentacao == 'evento' ) {

			$designers = get_users('role=portal');

			foreach ( $designers as $designer ) {

						if ( get_field('receber_notificacoes_por_email', 'user_' . $designer->ID) ) {

							$array_designers[] = $designer->user_email;

						}

			}

			}

		}

	$destinos = array_merge($destinos, $array_designers);


	$to = array();

	foreach ($destinos as $d) {

			array_push($to, $d);

	}

	$headers = 'From: ' . $name . ' <' . $email . '>' . "\r\n";
	$subject = $unidade . ' | ' . $post->post_title;
	$body =
	'<h2>[Nova solicitação]</h2><br>' .
	'<strong>' . '> Para visualizar, acesse: </strong>' . get_post_permalink($post_id) .
	'<br><br><br>' .
	'<hr>' .
	'Para ativar ou desativar as notificações por e-mail, clique <a href="http://cd.intranet.sp.senac.br/notificacoes-por-e-mail/">aqui</a>.';

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

		$destinos = array($author_email);

	}

	//PARTICIPANTES

	$participantes = get_field('participante', $post_id);

	if( $participantes ) {

		foreach( $participantes as $participante ) {

			if ( get_field('receber_notificacoes_por_email', 'user_' . $participante['ID']) ) {

					$array_participantes[] = $participante['user_email'];

			}

		}

		$destinos = array_merge($destinos, $array_participantes);

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
		'Para ativar ou desativar as notificações por e-mail, clique <a href="http://cd.intranet.sp.senac.br/notificacoes-por-e-mail/">aqui</a>.';

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
// 				'Para ativar ou desativar as notificações por e-mail, clique <a href="http://cd.intranet.sp.senac.br/notificacoes-por-e-mail/">aqui</a>.';
//
// 				wp_mail( $to , $subject, $message, $headers );
// 		}
// }

/* --------------------------

NOTIFICAÇÃO EMAIL - COMENTÁRIOS

---------------------------- */

add_filter( 'comment_post', 'comment_notification_email' );

function comment_notification_email( $comment_id ) {

		$comment = get_comment( $comment_id );
		$post = get_post( $comment->comment_post_ID );
		$user = get_user_by( 'id', $post->post_author );
		$post_url = get_permalink( $post->ID );

		global $current_user; get_currentuserinfo();

		$name = $current_user->user_firstname . ' ' . $current_user->user_lastname;
		$email = $current_user->user_email;

		$unidade = get_field('unidade', $post);

		$interacao_privada = get_field('privado_interacao', $comment);

		$destinos = array();

		//AUTOR

		$author_email = $user->user_email;

		if ( get_field('receber_notificacoes_por_email', 'user_' . $user->ID) ) {

			if ( in_array('senac', $user->roles) && $interacao_privada ) {

			} else {

				$destinos = array($author_email);

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

	        			$array_designers[] = $designer->user_email;

	        		}

				}

	  		}
	  		//DESIGNERS GD1 E GD3
	  		if( in_array('gd1_gd3', $segmentacao) || $segmentacao == 'gd1_gd3' ) {

				$designers = get_users('role=designer_gd1_gd3');

				foreach ( $designers as $designer ) {

	        		if ( get_field('receber_notificacoes_por_email', 'user_' . $designer->ID) ) {

	        			$array_designers[] = $designer->user_email;

	        		}

				}

	  		}
	  		//DESIGNERS INSTITUCIONAL
	  		if( in_array('institucional', $segmentacao) || $segmentacao == 'institucional' ) {

				$designers = get_users('role=designer_institucional');

				foreach ( $designers as $designer ) {

	        		if ( get_field('receber_notificacoes_por_email', 'user_' . $designer->ID) ) {

	        			$array_designers[] = $designer->user_email;

	        		}

				}

	  		}
	  		//PORTAL
	  		if( in_array('evento', $segmentacao) || $segmentacao == 'evento' ) {

				$designers = get_users('role=portal');

				foreach ( $designers as $designer ) {

	        		if ( get_field('receber_notificacoes_por_email', 'user_' . $designer->ID) ) {

	        			$array_designers[] = $designer->user_email;

	        		}

				}

	  		}

  		}

		$destinos = array_merge($destinos, $array_designers);

		//PARTICIPANTES

		$participantes = get_field('participante', $post);

		if( $participantes ) {

			foreach( $participantes as $participante ) {

				if ( get_field('receber_notificacoes_por_email', 'user_' . $participante['ID']) ) {

					$user_meta = get_userdata($participante['ID']);
					$user_role = $user_meta->roles;

					if ( in_array('senac', $user_role) && $interacao_privada ) {

					} else {

						$array_participantes[] = $participante['user_email'];

					}

				}

			}

			$destinos = array_merge($destinos, $array_participantes);

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
		'Para ativar ou desativar as notificações por e-mail, clique <a href="http://cd.intranet.sp.senac.br/notificacoes-por-e-mail/">aqui</a>.';

		$headers = 'From: ' . $name . ' <' . $email . '>' . "\r\n";

		wp_mail( $to, $subject, $message, $headers );



}

/* --------------------------

NUMERO DE INTERACOES (PRIVADAS)

---------------------------- */

function num_comentarios($text = true) {

	$post_id = get_the_ID();

	if ( current_user_can('senac') ) {
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
