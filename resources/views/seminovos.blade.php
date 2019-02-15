@extends('master')

@section('body')  
    <div id='mensagem'></div>
    <div class="row">      
      <div class="">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title"> <strong>Pesquisar</strong></h3>            
            <div class="input-line" id="boxselecao">
                <fieldset class="boxveiculo">
                    <input type="radio" id="carro" name="veiculo" value="carro" checked>
                    <label class="box boxcarro" for="carro">Carro</label>
                    <input type="radio" id="moto" name="veiculo"value="moto">
                    <label class="box boxmoto" for="moto">moto</label>
                    <input type="radio" id="caminhao" name="veiculo" value="caminhao">
                    <label class="box boxcaminhao" for="caminhao">caminhão</label>
                </fieldset>
            </div>
                <div class="input-line">
                <dl>
                    <dd class="boxPart checkbox-set">
                    <input type="radio" name="veiculo_zero_km" id="0km" value="0km" checked /> 0 KM 
                    <input type="radio" name="veiculo_zero_km" id="seminovo" value="seminovo" /> Seminovo
                    </dd>
                </dl>
                </div>
            {!! $html !!}
            <button type="button" onclick="pesquisar()">pesquisar</button>
          </div>
        </div>
      </div>            
      <div id="idTable">
        <h5 style='text-align: center'class='card-title'> Lista de Produtos</h5>                    
          <table class='table' id='tableVeiculos' style="max-width: 800px">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Valor</th>
                    <th>Ano</th>
                    <th>Km</th>
                    <th>Portas</th>
                    <th>Banco</th>
                    <th>Gasolina</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>                  
            </tbody>
            </table>
      </div>
    </div>

@endsection

@section('javaScript')
    <script src="{{ asset('js/loadItems.js') }}" type='text/javascript'></script>
@endsection