$('#marca').change(function(){
    marca = $(this).val();
    _marca(marca);
    $('#modelo').html('<option value="0">Escolha um modelo</option>');
    $('#idCidade').html('<option value="0">Escolha uma cidade</option>');
});

$('#modelo').change(function(){
    modelo = $('#modelo option:selected').attr('id')
    marca = $('#marca').val();  
    $('#idCidade').html('<option value="0">Escolha uma cidade</option>');              
    _modelo(modelo, marca);
});    

function _marca(marca){
    $.get('https://www.seminovosbh.com.br/json/modelos/buscamodelo/marca/'+marca+'/data.js?v3.47.1-hi', function (data, textStatus, jqXHR) {                
            $.each(data, function(index, value){
                option = '<option id="'+value.idModelo+'" value='+value.idModelo+'>'+value.modelo+'</option>';                    
                $('#modelo').append(option);
            })
        },
        "jSon" 
    );
}

function _modelo(modelo, marca){
    $.get('https://www.seminovosbh.com.br/json/index/busca-cidades/veiculo/1/marca/'+marca+'/modelo/'+modelo+'/cidade/0/data.js?v3.47.1-hi', function (data, textStatus, jqXHR) {
        $.each(data, function(index, value){
            option = '<option value='+value.cod_cidades+'>'+value.nome+'</option>';                    
            $('#idCidade').append(option);
        })
        },
        "jSon" 
    );
}

function pesquisar(){
    arrayData = {};
    /** informar os cados desejados */
    arrayData.veiculo = $("input[type=radio][name='veiculo']:checked").val();
    arrayData.veiculo_zero_km = $("input[type=radio][name='veiculo_zero_km']:checked").val();
    arrayData.marca = ($('#marca').val());
    arrayData.modelo = ($('#modelo').val());
    arrayData.idCidade = ($('#idCidade').val());
    arrayData.valor1 = ($('#valor1').val());
    arrayData.valor2 = ($('#valor2').val());    
    arrayData.ano1 = ($('#ano1').val());
    arrayData.ano2 = ($('#ano2').val());
    arrayData.particular = $("input[type=checkbox][name='particular']:checked").val();
    arrayData.revenda = $("input[type=checkbox][name='revenda']:checked").val();
    console.log(arrayData);
    $('#idTable').hide();
    $("#mensagem").show();
    $("#mensagem").removeClass("alert alert-danger");
    $("#mensagem").addClass("alert alert-primary");
    $("#mensagem").html('Processando...');
    $.getJSON('/api/pesquisar/',arrayData, function(datas){  
        
    }).done(function(datas){
        let tr = '';        
        console.log(datas.length);
        if (datas.length) {
            datas.forEach(data => {              
                tr += _tr(data);
                console.log(tr);
            });   
            $('#mensagem').hide();        
            $('#idTable').show();
            $('#tableVeiculos>tbody').append(tr);
        }else{
            $("#mensagem").addClass("alert alert-danger");
            $("#mensagem").removeClass("alert-primary");
            $("#mensagem").html('Veiculo não encontrado');
        }        
                
    }).fail(function() {
        console.log( "error" );
    })
}

function _tr(data){
    let descricao = '';
    $.each(data.descricao, function(index, value){
       descricao += value +'; ';
    })
    tr = `<tr>
            <td>${ data.nome }</td>
            <td>${ data.valor }</td>
            <td>${ data.ano }</td>
            <td>${ data.km }</td>
            <td>${ data.portas }</td>
            <td>${ data.banco }</td>
            <td>${ data.gasolina }</td>
            <td>${ descricao }</td>
        </tr>`;
    return tr;
}