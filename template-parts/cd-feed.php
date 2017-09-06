<?php

global $current_user;

if ( current_user_can( 'administrator' ) ) {
  $cd_author = $current_user->ID;
}

//FEED GD2 E GD4

if ( current_user_can( 'designer_gd2_gd4' ) ) {

  $feed_cd =

      array(

          'relation'		=> 'AND',

          // AREA
          array(
            'key' => 'area_divulgacao_tarefa',
            'value' => array(
              'educacao',
              'gestao-negocios',
              'meio-ambiente',
              'saude-bem-estar',
              'sst',
              'tecnologia-informacao',
            ),
            'compare' 	=> 'IN',
          ),

          array(

                'relation'		=> 'OR',

                // MODALIDADE
                array(
                  'key'		=> 'modalidade_curso',
                  'value'		=> array(
                    'curso-livre',
                    'extensao',
                    //'curso-tecnico',
                    //'pos',
                    //'vestibular',
                    //'gratuidade',
                    //'aprendizagem',
                  ),
                  'compare'	=> 'IN',
                ),

                //FINALIDADE
                array(
                  'key'		=> 'finalidade',
                  'value'		=> array(
                    //'dcurso',
                    'devento',
                    'outrafinalidade',
                  ),
                  'compare'	=> 'IN',
                ),
          ),
    );

    $cd_author = $current_user->ID;

}

//FEED GD1 E GD3

if ( current_user_can( 'designer_gd1_gd3' ) ) {

  $feed_cd =

      array(

          'relation'		=> 'AND',

          // AREA
          array(
            'key' => 'area_divulgacao_tarefa',
            'value' => array(
              'arquitetura-urbanismo',
              'comunicacao-artes',
              'desenvolvimento-social',
              'design',
              'eventos-lazer',
              'gastronomia',
              'hotelaria-turismo',
              'limpeza-conservacao-zeladoria',
              'moda',
            ),
            'compare' 	=> 'IN',
          ),

          array(

                'relation'		=> 'OR',

                // MODALIDADE
                array(
                  'key'		=> 'modalidade_curso',
                  'value'		=> array(
                    'curso-livre',
                    'extensao',
                    //'curso-tecnico',
                    //'pos',
                    //'vestibular',
                    //'gratuidade',
                    //'aprendizagem',
                  ),
                  'compare'	=> 'IN',
                ),

                //FINALIDADE
                array(
                  'key'		=> 'finalidade',
                  'value'		=> array(
                    //'dcurso',
                    'devento',
                    'outrafinalidade',
                  ),
                  'compare'	=> 'IN',
                ),
          ),
    );

    $cd_author = $current_user->ID;

}

//FEED INSTITUCIONAL

if ( current_user_can( 'designer_institucional' ) ) {

  $feed_cd =

      array(

          'relation'		=> 'OR',

          // MODALIDADE
          array(
            'key'		=> 'modalidade_curso',
            'value'		=> array(
              // 'curso-livre',
              // 'extensao',
              'curso-tecnico',
              'pos',
              'vestibular',
              'gratuidade',
              'aprendizagem',
            ),
            'compare'	=> 'IN',
          ),

          array(

                'relation'		=> 'AND',

                // AREA
                array(
                  'key' => 'area_divulgacao_tarefa',
                  'value' => array(
                    'idiomas',
                    'gerencias',
                    'campanhas',
                    'editora',
                    'hoteis',
                  ),
                  'compare' 	=> 'IN',
                ),

                //FINALIDADE
                array(
                  'key'		=> 'finalidade',
                  'value'		=> array(
                    'dcurso',
                    'devento',
                    'outrafinalidade',
                  ),
                  'compare'	=> 'IN',
                ),
          ),
    );

    $cd_author = $current_user->ID;

}

//FEED PORTAL

if ( current_user_can( 'portal' ) ) {

  $feed_cd =

  array(

    'relation'		=> 'OR',

    // PUBLICACAO
    array(
      'key'		=> 'publicacao_pecas',
      'value'		=> '"publicacao"',
      'compare' => 'LIKE'
    ),

    // PAUTA
    array(
      'key'		=> 'finalidade',
      'value'		=> array('pauta'),
      'compare'	=> 'IN',
    ),
  );

  $cd_author = $current_user->ID;

}

// FEED REPRESENTANTES

if ( current_user_can( 'senac' ) ) {

  $args_query1 = array(
  		'post_type'		=> 'tarefa',
  		'posts_per_page' => -1,
      'fields' => 'ids',
      'meta_query'  =>  array(
        array(
        'key' => 'participante',
        'value' => $current_user->ID,
        'compare' => 'LIKE',
        ),
      ),
  );

  $query1 = new WP_Query($args_query1);

  $args_query2 = array(
  		'post_type'		=> 'tarefa',
  		'posts_per_page' => -1,
      'fields' => 'ids',
  		'author'		=> $current_user->ID,
  );

  $query2 = new WP_Query($args_query2);

  $allTheIDs = array_merge($query1->posts,$query2->posts);

  if (empty($allTheIDs)) {
       $cd_author = $current_user->ID;
       $feed_rc = $current_user->ID;
  }

  $privado = array(
  'key' => 'privado_interacao',
  'value' => '1',
  'compare' => '!=',
  );

};

?>
