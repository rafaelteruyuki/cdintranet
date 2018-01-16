<?php acf_form_head();

/*
Template Name: Calculadora de Prazos
*/

get_header(); ?>

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

<?php


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

<?php acf_form( $args ); ?>


<?php get_footer(); ?>
