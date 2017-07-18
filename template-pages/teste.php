<?php /*Template Name: Teste*/
get_header();

$terms = get_terms(array(
        'taxonomy' => 'area',
        'hide_empty' => false,
    )
);

?>
<label for="area-select">Área </label>
<select id="area-select" name="area-select"></select>

<label for="subarea-select">Subarea</label>
<select id="subarea-select" name="subarea-select"></select>

<script>
    var terms = <?php echo json_encode($terms); ?> ;

    var areaSelect = document.getElementById("area-select");
    var subareaSelect = document.getElementById("subarea-select");

    for(var i=0; i<terms.length; i++){
        if(terms[i].parent == 0){
            var option = document.createElement("option");
            option.value = terms[i].term_id;
            option.textContent = terms[i].name;
            areaSelect.appendChild(option);
        }
    }

    function preencheSubarea(area){
        for (var i=0; i<terms.length; i++){
            if(terms[i].parent == area){
                var option = document.createElement("option");
                option.value = terms[i].term_id;
                option.textContent = terms[i].name;
                subareaSelect.appendChild(option);
            }
        }
    }
    
    preencheSubarea(areaSelect.value);
    
    console.log(subareaSelect.length);
    console.log(subareaSelect[0]);
    console.log(subareaSelect[1]);
    console.log(subareaSelect[2]);
    
    areaSelect.addEventListener("change", function(event){
        while(subareaSelect.length){
            subareaSelect.remove(0);
        }
        
        preencheSubarea(this.value);
        
    });
    
</script>


    
<?php

var_dump($terms);

//$term_json = json_encode($terms);
//echo $term_json;

?>




<?php get_footer();?>