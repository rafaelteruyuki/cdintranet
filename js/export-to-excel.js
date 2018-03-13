// $('#btnExport').click(function() {
//
//     var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
//     tab_text = tab_text + '<head><meta charset="UTF-8" /><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet‌​>';
//
//     tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
//
//     tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
//     tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
//
//     tab_text = tab_text + "<table border='1px'>";
//     tab_text = tab_text + $('#table_wrapper').html();
//     tab_text = tab_text + '</table></body></html>';
//
//     var data_type = 'data:application/vnd.ms-excel';
//
//     var ua = window.navigator.userAgent;
//     var msie = ua.indexOf("MSIE ");
//
//     var data_hoje = <?php // echo date( 'Ymd', current_time( 'timestamp', 0 ) ); ?>;
//     var file_name = data_hoje + '_tarefas_exportadas' + '.xls';
//
//     if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
//         if (window.navigator.msSaveBlob) {
//             var blob = new Blob([tab_text], {
//                 type: "application/csv;charset=utf-8;"
//             });
//             navigator.msSaveBlob(blob, file_name);
//         }
//     } else {
//         $('#btnExport').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
//         $('#btnExport').attr('download', file_name);
//     }
//
// });

// PARA TABELAS COM MAIS DE 1500 ROWS

$(document).ready(function() {

  function exportTableToCSV($table, filename) {

    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    tab_text = tab_text + '<head><meta charset="UTF-8" /><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet‌​>';

    tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';

    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

    tab_text = tab_text + "<table border='1px'>";
    tab_text = tab_text + $('#table_wrapper').html();
    tab_text = tab_text + '</table></body></html>';

    // Deliberate 'false', see comment below
    if (false && window.navigator.msSaveBlob) {

      var blob = new Blob([decodeURIComponent(tab_text)], {
        type: 'text/csv;charset=utf8'
      });

      // Crashes in IE 10, IE 11 and Microsoft Edge
      // See MS Edge Issue #10396033
      // Hence, the deliberate 'false'
      // This is here just for completeness
      // Remove the 'false' at your own risk
      window.navigator.msSaveBlob(blob, filename);

    } else if (window.Blob && window.URL) {

      // ESSE É O USADO:

      // HTML5 Blob
      var blob = new Blob([tab_text], {
        type: 'text/csv;charset=utf-8'
      });
      var csvUrl = URL.createObjectURL(blob);

      $(this)
        .attr({
          'download': filename,
          'href': csvUrl
        });
    } else {

      // Data URI
      var csvData = 'data:application/vnd.ms-excel,' + encodeURIComponent(tab_text);

      $(this)
        .attr({
          'download': filename,
          'href': csvData,
          'target': '_blank'
        });
    }
  }

  // This must be a hyperlink
  $(".export").on('click', function(event) {

    // Data hoje
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!

    var yyyy = today.getFullYear();
    if ( dd < 10) {
        dd = '0' + dd;
    }
    if ( mm < 10 ) {
        mm = '0'+ mm;
    }

    var data_hoje = yyyy + mm + dd;
    var arquivo = data_hoje + '_tarefas_exportadas' + '.xls';
    var args = [$('#table_wrapper>table'), arquivo];

    exportTableToCSV.apply(this, args);

    // If CSV, don't do event.preventDefault() or return false
    // We actually need this to be a typical hyperlink
  });
});
