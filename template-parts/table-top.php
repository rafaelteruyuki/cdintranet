<thead>
<tr class="center aligned">
  <th data-sort="string">Unidade</th>
  <th data-sort="string">Finalidade</th>
  <th data-sort="string" class="left aligned">Título</th>
  <th data-sort="string">Área</th>
  <th data-sort="int">Data solicitação</th>
  <!-- <th data-sort="int">Data início</th> -->
  <!-- <th data-sort="int">Previsão publicação</th> -->
  <!-- <th data-sort="int">Previsão peças</th> -->

  <?php 
    $current_user = wp_get_current_user();
    $current_user_roles = $current_user->roles;
    global $wp_roles;

    foreach ($current_user_roles as $role): 
      if ($role != 'senac'): ?>
    <th data-sort="int">Prazo <?= $wp_roles->roles[$role]['name']?> </th>
  <?php 
    endif;
    endforeach; ?>

  <th data-sort="string">Responsáveis</th>
  <th data-sort="int"><i class="comment icon"></i></th>
  <th data-sort="string">Status</th>
</tr>
</thead>
