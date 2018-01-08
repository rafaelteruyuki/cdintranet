

    $("#btn-pesquisar").on("click", function() {

        var dados = {

            'action' : 'query_cursos',
            'query' : $("#campo-pesquisa").val()
        };

        $.post(ajax_object.ajax_url, dados, function(resposta){


            var cursos = $.parseJSON(resposta);
            console.log(cursos);

            var cardsContainer = $('#cards-container');
            cardsContainer.empty();

            if(cursos){
                $.ajax(
                    ajax_object.template_directory_uri + '/template/card-template.html', {
                    dataType: 'text',
                    success: function(data){
                        console.log(data);
                        for(c in cursos){
                            var rendered = Mustache.render(data, cursos[c]);
                            $('#cards-container').append(rendered);
                        }
                    }
                });
            }else{
                 $('#cards-container').append('<h3>Não possui nenhum curso cadastrado.</h3>');
            }
        });

        return false;

    });

    $('.ui.fluid.labeled.icon.dropdown')
    	.dropdown({
        on: 'click'
      })
    ;

    $("input[type=hidden][name=area]").on("change", function(){
        //alert(this.value);
        var dados = {
            'action': 'consulta_subarea',
            'area': this.value
        }

        $.post(ajax_object.ajax_url, dados, function(resposta) {
            var options = $.parseJSON(resposta);

            $("#menu-subarea input").val('0');
            $("#menu-subarea span.text").text('Todas as subáreas');

            var itensList = $("#menu-subarea div.menu");
            itensList.empty();

            $('<div class="item" data-value="0">Todas as subáreas</div>').appendTo(itensList);

            $.each(options, function( key, value ) {
                $('<div>', {
                    class: 'item',
                    'data-value': key
                }).text(value).appendTo(itensList);
            });

        });

        console.log($("#menu-subarea input").val('0'));
        consulta();

        return false;
    });

    $("input[type=hidden][name=modalidade]").on("change", function(){
        consulta();
    });

    $("input[type=hidden][name=subarea]").on("change", function(){
        consulta();
    });

    function consulta(){

        var area = $("input[type=hidden][name=area]").val();
        console.log('area: '+area);
        var subarea = $("input[type=hidden][name=subarea]").val();
        console.log('subarea: '+subarea);
        var modalidade = $("input[type=hidden][name=modalidade]").val();

        var dados = {
            'action' : 'cursos_modalidade',
            'modalidade' : modalidade,
            'area' : area,
            'subarea' : subarea
        };

        $.post(ajax_object.ajax_url, dados, function(resposta){


            var cursos = $.parseJSON(resposta);
            console.log("resposta cursos: " + cursos);

            var cardsContainer = $('#cards-container');
            cardsContainer.empty();

            if(cursos){
                $.ajax(
                    ajax_object.template_directory_uri + '/template/card-template.html', {
                    dataType: 'text',
                    success: function(data){
                        console.log(data);
                        for(c in cursos){
                            var rendered = Mustache.render(data, cursos[c]);
                            $('#cards-container').append(rendered);
                        }
                    }
                });
            }else{
                 $('#cards-container').append('<h3>Não possui nenhum curso cadastrado.</h3>');
            }
            $('.cd-paginacao').hide(); // Esconde a paginação
        });

        return false;
    }
