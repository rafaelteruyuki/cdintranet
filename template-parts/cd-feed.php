<?php

global $current_user;

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

}

//FEED PORTAL

if ( current_user_can( 'portal' ) ) {

  $feed_cd =

      // PUBLICACAO
      array(
        'key'		=> 'publicacao_pecas',
        'value'		=> '"publicacao"',
        'compare' => 'LIKE'
      );

}

// FEED REPRESENTANTES

if ( current_user_can( 'senac' ) ) {

  $feed_rc = $current_user->ID;

};

?>
