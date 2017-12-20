<!--Footer-->

<div class="ui inverted vertical segment" style="font-size:0.9em; background-image:url(<?php bloginfo('template_url'); ?>/images/bg.png);">
    <div class="ui four column grid container stackable cd-margem">

      <div class="column">
        <h4 class="ui dividing header inverted">Campanhas Institucionais, Gerências Funcionais, Editora e Hotéis</h4>
          Anelise Kalinka de Andrade
          <br>
          Thiago Augusto da Costa
        <h4 class="ui dividing header inverted">GD1 e GD3</h4>
          <!-- Rafael Teruyuki Yamaguchi -->
          <!-- Ana Carolina da Silva Sarneiro -->
          <!-- <br> -->
          Walter Pereira da Fonseca Junior
        <h4 class="ui dividing header inverted">GD2 e GD4</h4>
          Genildo da Silva Marcelo
          <br>
          Rafael Franchin
      </div>

      <div class="column">
        <h3 class="ui dividing header inverted">Portal</h3>
          Carla Pires Gomes
          <br>
          Fernanda Andrade Café
          <br>
          Juliana Lopes Romão Campos
          <br>
          Wendy Maria de Castro
      </div>

      <div class="column">
        <h3 class="ui dividing header inverted">Redes Sociais</h3>
          Davi Toth Gasparotti
          <br>
          Marcos Vinícios Blandino
          <br>
          Stevam Steffen Junior
      </div>

      <div class="column">
        <h3 class="ui dividing header inverted">Coordenador</h3>
        <div>Sandro Neto Ribeiro</div>
        <br>
        <h3 class="ui dividing header inverted">Gerente</h3>
        <div>Otavio Fernando Genta Cordioli</div>
      </div>

    </div>
</div>

<div class="ui inverted vertical segment">
    <div class="ui container center aligned cd-margem">
    	<img src="<?php bloginfo('template_url'); ?>/images/logo-senac-branco.png" width="130">
    </div>
</div>

<?php wp_footer();?>

<!-- Exportar Excel -->

<script type="text/javascript">

function fnExcelReport() {
    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    tab_text = tab_text + '<head><meta charset="UTF-8" /><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet‌​>';

    tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';

    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

    tab_text = tab_text + "<table border='1px'>";
    tab_text = tab_text + $('#table_wrapper').html();
    tab_text = tab_text + '</table></body></html>';

    var data_type = 'data:application/vnd.ms-excel';

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    var data_hoje = <?php echo date( 'Ymd', current_time( 'timestamp', 0 ) ); ?>;
    var file_name = data_hoje + '_tafefas_exportadas' + '.xls';

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        if (window.navigator.msSaveBlob) {
            var blob = new Blob([tab_text], {
                type: "application/csv;charset=utf-8;"
            });
            navigator.msSaveBlob(blob, file_name);
        }
    } else {
        $('#btnExport').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
        $('#btnExport').attr('download', file_name);
    }
}

</script>

<!-- MODAL NATAL -->

<div class="ui tiny modal cd-natal" style="width: 580px; margin: 0 0 0 -290px">
  <i class="close icon"></i>
  <div class="image content">
    <img src="<?php bloginfo('template_url'); ?>/images/natal2.gif">
  </div>
  <div class="actions">
    <a class="ui cd-natal-obrigado button" href="javascript:dontShow()">Não mostrar novamente</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

<script type="text/javascript">

// Cookies.set('mostrar', 'yes', { expires: 7 });
// Cookies.remove('mostrar');

function dontShow() {
  Cookies.set('mostrar', 'no', { expires: 7 });
}

var mostrar = Cookies.get('mostrar');

if (mostrar !== 'no') {
  $('.modal.cd-natal')
    .modal('attach events', '.cd-natal-obrigado', 'hide')
    .modal('show')
  ;
  $('.cd-natal').css({ margin: "-290px 0px 0px -290px" }); // Correção margem
}

// alert(mostrar);

</script>

<!-- // MODAL NATAL -->

<!-- Analytics -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-60818406-1', 'auto');
  ga('send', 'pageview');
</script>

</div> <!-- PUSHER SIDEBAR (header.php) -->

</body>
</html>
