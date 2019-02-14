@extends('master')

@section('body')
<div class="form-group">
    <label for="tipoVeiculo">Selecione o tipo de veiculo</label>
    <select class="form-control" name="tipoVeiculo">
        @foreach ($dadosPesquisa as $itens)
            <option value="{{ $itens[2] }}">{{ $itens[0] }}</option>
        @endforeach
    </select>
    <label for="veiculo_zero_km[]">0km ou Seminovo</label>
    <select class="form-control" name="veiculo_zero_km[]">
        @foreach ($zeroSemeNovo as $itens)
            <option value="{{ $itens[2] }}">{{ $itens[3] }}</option>
        @endforeach
    </select>
    <label for="marca">Marca</label>
    <select class="form-control" name="marca">
        @foreach ($marca as $itens)
            <?php echo('<option'. $itens); ?>
        @endforeach
    </select>
</div>

@endsection