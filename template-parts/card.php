<?php  
$modalidade = get_field_object('modalidade');
$lblModalidade = $modalidade['choices'][ $modalidade['value'] ];
?>
<!-- CARD -->
<a href="<?php the_permalink(); ?>" class="ui fluid card" target="_blank">
  <div class="image"><?php the_post_thumbnail('redes-sociais'); ?></div>
  <div class="content">
    <div class="meta" style="margin-bottom:10px;"><i class="caret right icon"></i><?php echo $lblModalidade ?></div>
    <div class="header"><?php the_title(); ?></div>
  </div>
</a>