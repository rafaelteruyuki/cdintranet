// Imagem
$('#input-imagem').keyup(function() {
  $('#imagem').attr('src', this.value);
});

// Fundo
$('#input-fundo').keyup(function() {
  $('#container').attr('bgcolor', this.value);
}).val(function () {
    return this.value.toUpperCase();
});

// Botão
$('#input-botao').keyup(function() {
  $('#cta-bg').attr('bgcolor', this.value);
}).val(function () {
    return this.value.toUpperCase();
});

// Borda
$('#input-linha').keyup(function() {
  $('#container').attr('style', 'border: 1px solid ' + this.value + '; border-collapse: collapse;');
}).val(function () {
    return this.value.toUpperCase();
});

// Texto e CTA
var texto = $('#texto').attr('style');
$('#select-texto').change(function() {
  if ( this.value == 'preto' ) {
    $('#portal span').attr('style', 'color: ' + $('#input-fundo').val()); // cta-texto
    $('#texto').attr('style', texto + ' color: #000001;');
  } else if ( this.value == 'branco' ) {
    $('#portal span').attr('style', 'color: ' + $('#input-fundo').val()); // cta-texto
    $('#texto').attr('style', texto + ' color: #FFFFFF;');
  }
});

// Unidade
var pin_text = $('#pin-text').attr('style');
$('#select-unidade').change(function() {

  var unidade = this.value;
  var sigla = unidades[unidade]['sigla'];
  var nome = unidades[unidade]['nome'];
  var nome_url = unidades[unidade]['nome_url'];
  var endereco = unidades[unidade]['endereco'];
  var telefone = unidades[unidade]['telefone'];
  var url = unidades[unidade]['url'];
  var google_maps = unidades[unidade]['google_maps'];

  var parametro1 = '&utm_source=Email_Marketing&utm_medium=email&utm_campaign=' + sigla;
  var parametro2 = $('.modalidade').html();

  if (parametro2 == 'Curso Livre') {
    parametro2 = '_Livres';
  } else if (parametro2 == 'Extensão Universitária') {
    parametro2 = '_Extensao';
  }

  var tagueamento = parametro1 + parametro2;

  var portal = $('#input-portal').val();
  $('#portal').attr('href', portal + tagueamento);

  $('#link-unidade strong').html('www.sp.senac.br/' + nome_url);
  $('#link-unidade').attr('href', url + tagueamento);
  $('#pin-text').html(endereco).attr('href', google_maps);
  $('#tel-text').html('&nbsp;' + telefone);

  // Portal
  $('#input-portal').keyup(function() {
    $('#portal').attr('href', this.value + tagueamento);
  });

  // Assinatura
  $('#select-assinatura').change(function() {

    var url_img = 'http://www1.sp.senac.br/hotsites/msg/gcr/';

    if ( this.value == 'preto' ) {
      $('#link-unidade').attr('style', 'color: #000001; text-decoration: underline;');
      $('#assinatura').attr('bgcolor', '');
      $('#assinatura').attr('style', 'color: #000001');
      $('#tel-icon').attr('src', url_img + 'tel_preto.png');
      $('#pin-icon').attr('src', url_img + 'pin_preto.png');
      $('#pin-text').attr('style', pin_text +  ' color: #000001');
      $('#logo-senac').attr('src', url_img + 'senac70_preto.png');

    } else if ( this.value == 'branco' ) {
      $('#link-unidade').attr('style', 'color: #FFFFFF; text-decoration: underline;');
      $('#assinatura').attr('bgcolor', '');
      $('#assinatura').attr('style', 'color: #FFFFFF');
      $('#tel-icon').attr('src', url_img + 'tel_branco.png');
      $('#pin-icon').attr('src', url_img + 'pin_branco.png');
      $('#pin-text').attr('style', pin_text +  ' color: #FFFFFF');
      $('#logo-senac').attr('src', url_img + 'senac70_branco.png');

    } else if ( this.value == 'colorido' ) {
      $('#link-unidade').attr('style', 'color: #000001; text-decoration: underline;');
      $('#assinatura').attr('bgcolor', '#F6F6F6');
      $('#assinatura').attr('style', 'color: #000001');
      $('#tel-icon').attr('src', url_img + 'tel_preto.png');
      $('#pin-icon').attr('src', url_img + 'pin_preto.png');
      $('#pin-text').attr('style', pin_text +  ' color: #000001');
      $('#logo-senac').attr('src', url_img + 'senac70_cor.png');

    }
  });

});

  $('#select-unidade').trigger('change');
  if ($('#input-imagem').val() != 'http://www1.sp.senac.br/hotsites/msg/') $('#input-imagem').trigger('keyup');
  $('#input-fundo').trigger('keyup');
  $('#input-botao').trigger('keyup');
  $('#input-linha').trigger('keyup');

  var data_texto = $('#select-texto').data('texto');
  if (data_texto == 'preto') {
    $('#select-texto').val('preto');
  }
  else if (data_texto == 'branco') {
    $('#select-texto').val('branco');
  }
  $('#select-texto').trigger('change');

  var data_assinatura = $('#select-assinatura').data('assinatura');
  if (data_assinatura == 'preto') {
    $('#select-assinatura').val('preto');
  }
  else if (data_assinatura == 'branco') {
    $('#select-assinatura').val('branco');
  }
  else if (data_assinatura == 'colorido') {
    $('#select-assinatura').val('colorido');
  }
  $('#select-assinatura').trigger('change');


$(".cd-label-preto").click(function(){
  $(this).parent().nextAll('input').val('#000001').trigger('keyup');
  var color = $('#input-fundo').val();
  $('#portal span').attr('style', 'color: ' + color);
  // Cancela o eyedropper
  eyedropper_cancel();
})

$(".cd-label-branco").click(function(){
  $(this).parent().nextAll('input').val('#FFFFFF').trigger('keyup');
  var color = $('#input-fundo').val();
  $('#portal span').attr('style', 'color: ' + color);
  // Cancela o eyedropper
  eyedropper_cancel();
})

/* -----------------------------

EYEDROPPER

----------------------------- */

$( ".ui.eyedropper.icon" ).css('cursor', 'pointer').click(function() {

  $('.imagem-single-curso, #imagem').each(function(){
    this.canvas = $('<canvas />')[0];
    this.canvas.width = this.width;
    this.canvas.height = this.height;
    this.canvas.getContext('2d').drawImage(this, 0, 0, this.width, this.height);
  });

  $('.imagem-single-curso, #imagem').mousemove(function(e) {

      // var offX  = (e.offsetX || e.clientX - $(e.target).offset().left);
      // var offY  = (e.offsetY || e.clientY - $(e.target).offset().top);

      var offX = (e.offsetX || e.clientX - $(e.target).offset().left + window.pageXOffset );
      var offY = (e.offsetY || e.clientY - $(e.target).offset().top + window.pageYOffset );

      var pixelData = this.canvas.getContext('2d').getImageData(offX, offY, 1, 1).data;

      function rgb2hex(rgb){
       rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
       return "#" +
        ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[3],10).toString(16)).slice(-2);
      }

      var hex = rgb2hex( 'rgba(' + pixelData[0] + ', ' + pixelData[1] + ', ' + pixelData[2] + ', ' + pixelData[3] + ')' );

      $('.eyedropper-color:focus').val(hex).val(function () {
          return this.value.toUpperCase();
      });

      $('#container').attr('bgcolor', $('#input-fundo').val());
      $('#portal span').attr('style', 'color: ' + $('#input-fundo').val());
      $('#cta-bg').attr('bgcolor', $('#input-botao').val());
      $('#container').attr('style', 'border: 1px solid ' + $('#input-linha').val() + '; border-collapse: collapse;');

  });

  $('.imagem-single-curso, #imagem').css('cursor', 'crosshair');

  $(this).parent().nextAll('input').focus();

  // Cancela eyedropper

  $('.imagem-single-curso, #imagem').click(function(){
    eyedropper_cancel();
  });

  $(document).keyup(function(e) {
      if (e.keyCode == 27) { // escape key maps to keycode `27`
        eyedropper_cancel();
      }
  });

});

function eyedropper_cancel() {
  $('.imagem-single-curso, #imagem').css('cursor', 'default').off('mousemove');
}

/* -----------------------------

SALVAR EMAIL

----------------------------- */

$('#salvar-email').click(function(e) {

  if( !$('#input-portal').val() ) {
    alert('Preencha o campo "Link do portal"');
    return false;
  }

  if (!isUrlValid($('#input-portal').val())) {
    alert('Preencha o campo "Link do portal" com uma URL válida');
    return false;
  }

  $('#imagem').removeAttr('crossorigin', 'anonymous'); // Remove o atributo para salvar. Este atributo serve para permitir capturar os pixel de imagem de URL externo.

  // Email marketing
  var title = $('#imagem').attr('alt');
  var unidade = $('#select-unidade').val();

  var doc_type = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' + '\n';
  var open_html = '<html xmlns="http://www.w3.org/1999/xhtml">' + '\n';
  var head = '<head>' + '\n' + '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />' + '\n' + '<title>' + unidades[unidade]['nome'] + ' - ' + title + '</title>' + '\n' + '</head>' + '\n';
  var open_body = '<body style="margin:0px; padding:10px 0;" bgcolor="#FFFFFF">'
  var email = $('#email-marketing')[0].innerHTML;
  var close_body = '</body>' + '\n';
  var close_html = '</html>';

  var email_final = doc_type + open_html + head + open_body + email + close_body + close_html;
  var email_encoded = he.encode(email_final, {
    'useNamedReferences': true,
    'allowUnsafeSymbols': true
  });

  // var found = $(email_encoded).find("#pin-text").attr('href');
  // console.log(found);
  //
  // var google_maps = unidades[unidade]['google_maps'];
  // console.log(google_maps);
  //
  // var pin_text = $(email_encoded).find("#pin-text");
  // pin_text.attr('href', 'http://teste.com');
  // console.log(pin_text.attr('href'));

  // Data
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth()+1; //January is 0!

  var yyyy = today.getFullYear();
  if(dd<10){
      dd='0'+dd;
  }
  if(mm<10){
      mm='0'+mm;
  }

  // Substituir caracteres acentuados
  function removeDiacritics(input)
  {
      var output = "";

      var normalized = input.normalize("NFD");
      var i=0;
      var j=0;

      while (i<input.length)
      {
          output += normalized[j];

          j += (input[i] == normalized[j]) ? 1 : 2;
          i++;
      }

      return output;
  }

  var data_hoje = yyyy + mm + dd;
  var sigla = $('#select-unidade').val();
  var titulo = removeDiacritics($('.main-title').html()).replace(/[_\W]+/g, "_").toLowerCase();

  var filename = data_hoje + '_' + sigla + '_' + titulo + '.html';

  // e.originalEvent.currentTarget.href = 'data:text/html;charset=utf-8,' + email_encoded;
  // e.originalEvent.currentTarget.download = filename;

  download(email_encoded, filename, "text/html");

  // Copiar link do email

  $('.email').show();
  $('#input-email').val('http://www.sp.senac.br/msg/' + sigla.toLowerCase() + '/' + filename ).select();
  $('#copiar-email').click(function(){
    var copiar = $('#input-email').val();
    copyToClipboard(copiar);
    var copiado = $(this).html('<i class="ui copy icon"></i> Copiado');
    setTimeout(function() {
         copiado.html('<i class="ui copy icon"></i> Copiar');
     }, 1000);
  });

  // Salva no banco de dados

  var post_id = $(this).data('id');
  var save_imagem = $('#input-imagem').val();
  var save_fundo = $('#input-fundo').val();
  var save_botao = $('#input-botao').val();
  var save_linha = $('#input-linha').val();
  var save_texto = $('#select-texto').val();
  var save_assinatura = $('#select-assinatura').val();

  $.ajax({
    method: 'POST',
    url: ajaxurl,
    data: {
      action: 'salvar_email',
      post_id : post_id,
      save_imagem : save_imagem,
      save_fundo : save_fundo,
      save_botao : save_botao,
      save_linha : save_linha,
      save_texto : save_texto,
      save_assinatura : save_assinatura
    },
    beforeSend: function() {
      console.log('Salvando e-mail...');
    },
    success: function() {
      console.log('E-mail salvo!');
    }
  });

});

/* -----------------------------

MOSTRAR EDICAO EMAIL

----------------------------- */

$('#criar-email').click(function(){
  $(this).hide();
  $('#section-email').show();
  $('html, body').animate({
      scrollTop: $("#section-email").offset().top
  }, 500);
});

/* -----------------------------

CHECA SE A URL É VÁLIDA

----------------------------- */

function isUrlValid(url) {
    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
}

/* -----------------------------

COPIAR

----------------------------- */

function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(element).select();
    document.execCommand("copy");
    $temp.remove();
}
