<?php acf_form_head();

/*
Template Name: Formulário Solicitação
*/

get_header(); ?>

<link rel="stylesheet" href="<?php bloginfo('url'); ?>/wp-content/themes/comunicacao-digital/css/form-tarefa.css">

<?php
$current_user = wp_get_current_user();
$current_user_id = get_current_user_id();
$test_users = array(114, 77, 57, 151, 113, 132, 55, 1, 47, 51, 50, 49, 48, 53, 97, 37, 99, 76, 67, 146);
?>

<?php if ( !in_array($current_user_id, $test_users) ) : ?>

  <style media="screen">
    .acf-field-5787b4caf1816 ul li:nth-child(3){
       display:none;
    }
    .cd-hidden {
      display: none;
    }
  </style>

<?php endif; ?>

<?php

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

<!-- TESTE 2 -->

<div class="ui container cd-margem">
  <h2>Calcular prazo</h2>
  <form class="ui form" id="form-prazo">
    <div class="required field">
      <label>Data inicial</label>
      <input type="text" name="data-inicial" placeholder="Data inicial" id="data-inicial">
      <input type="hidden" name="data-inicial-url" id="data-inicial-url">
    </div>
    <div class="required field">
      <label>Prazo (dias úteis)</label>
      <input type="number" name="prazo" placeholder="Prazo" id="prazo">
    </div>
    <a class="ui green button calcular" onclick="calcular()">Calcular</a>
    <a class="ui button">Limpar</a>
  </form>
  <div class="ui hidden divider"></div>
  <h3 id="data-final"></h3>
</div>

<script>

// CONFIGURACAO DO DATE PICKER
$('#data-inicial').datepicker({
    constrainInput: true,   // prevent letters in the input field
    autoSize: true,         // automatically resize the input field
    dateFormat: 'dd/mm/yy',  // Date format to display
    altField: '#data-inicial-url',  // Date to use (hidden)
    altFormat: 'yy-mm-dd',  // Date format to use (hidden)
    firstDay: 0 // Start with Sunday
})

$("#form-error").hide();

function calcular() {

  var dataInicial = $("input#data-inicial").val();
  var prazo = $("input#prazo").val();
  var dataInicialURL = $( "#data-inicial-url" ).val();

  // if (dataInicial == "") {
  //   $("#error").show();
  //   // return false;
  // }
  //
  // if (prazo == "") {
  //   $("#error").show();
  //   // return false;
  // }

  $.ajax({

      url: 'http://elekto.com.br/api/Calendars/' + 'br-SP' + "/Add?initialDate=" + dataInicialURL + "&days=" + prazo + "&type=work&finalAdjust=none",
      type: 'GET',
      dataType: 'json',

      beforeSend: function(){
        $("#data-final").html('<i class="ui loading refresh icon" id="loading"></i>');
      },

      complete: function(){
        $("label#form-error").hide();
      },

      success: function(response) {
        // Cria a data com base na data retornada
        date = new Date(response);

        // GET as partes da data
        year = date.getFullYear();
        month = date.getMonth()+1; // Mês começa em 0
        dt = date.getDate()+1; // Dia começa em 0

        // Acrescenta 0 a esquerda
        if (dt < 10) {
          dt = '0' + dt;
        }
        if (month < 10) {
          month = '0' + month;
        }

        $('#data-final').html('<i class="ui green check icon"></i> Data final: ' + dt + '/' + month + '/'+year);
      },

      error: function(jqXHR, textStatus, errorThrown) {
        var err = textStatus + ', ' + errorThrown;
				console.log( "Request Failed: " + err);
				// alert("Problemas: " + err);
        $("#loading").hide();
        $("#data-final").html('<i class="ui red close icon"></i>Alguns campos não foram preenchidos corretamente');
      }

  });
}

</script>

<!-- /TESTE 2 -->

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
