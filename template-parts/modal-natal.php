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

// Cookies.set('mostrar', 'yes', { expires: 40 });
// Cookies.remove('mostrar');

function dontShow() {
  Cookies.set('mostrar', 'no', { expires: 40 });
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
