<!--Footer-->

<div class="ui inverted vertical segment" style="font-size:0.9em; background-image:url(<?php bloginfo('template_url'); ?>/images/bg.png); background-attachment:fixed;">
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
        <div>Juliano Márcio Calderero</div>
      </div>

    </div>
</div>

<div class="ui inverted vertical segment">
    <div class="ui container center aligned cd-margem">
    	<img src="<?php bloginfo('template_url'); ?>/images/logo-senac-branco.png" width="130">
    </div>
</div>

<!-- MODAL MARCAR LIDAS -->
<div class="ui mini modal marcar-lidas">
  <i class="close icon"></i>
  <div class="header">
    Marcar interações como lidas
  </div>
  <div class="content">
    <p>Tem certeza que deseja marcar todas as interações como lidas?</p>
  </div>
  <form class="actions" method="post">
    <div class="ui cd-cancel-btn button">Cancelar</div>
    <input type="submit" name="marcar-lidas" value="Marcar todas como lidas" class="ui positive button">
  </form>
</div>

<?php wp_footer();?>

<?php // get_template_part('template-parts/modal-natal') ?>

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
