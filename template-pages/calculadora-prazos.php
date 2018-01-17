<?php
/*
Template Name: Calculadora de Prazos
*/
?>

<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php bloginfo('name'); ?> | <?php is_home() ? bloginfo('description') : wp_title(''); ?></title>
<?php wp_head(); ?>
</head>

<body>

<style media="screen">
  body {
    padding: 50px 50px;
  }
  html {
    margin-top: 0 !important;
  }
</style>

<!-- TESTE 2 -->

<div class="ui container">
  <h2>Calculadora de prazos</h2>
  <p><em>Contabiliza os dias úteis, considerando os feriados de São Paulo.</em></p>
  <div class="ui hidden divider"></div>
  <form class="ui form" id="form-prazo">
    <div class="required field">
      <label>Data inicial</label>
      <input type="text" name="data-inicial" placeholder="Data inicial" id="data-inicial" autocomplete="off">
      <input type="hidden" name="data-inicial-url" id="data-inicial-url">
    </div>
    <div class="required field">
      <label>Prazo</label>
      <input type="number" name="prazo" placeholder="Prazo" id="prazo" autocomplete="off">
    </div>
    <a class="ui green button calcular" onclick="calcular()">Calcular</a>
  </form>
  <div class="ui hidden divider"></div>
  <h3 id="data-final"></h3>
</div>

<?php wp_footer(); ?>

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

$("#wpadminbar").remove();

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

</body>
</html>
