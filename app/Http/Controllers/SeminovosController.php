<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

class SeminovosController extends Controller{
    
    private $url;

    public function index(){

        $client = new Client();
        $crawler = $client->request('GET', 'https://www.seminovosbh.com.br/');
        $html = '';
        $crawler->filter('#simpleSearch .input-line')->each(function ($node, $index) use(&$html) {
            
            if ($index >=2) {
                $html .=$node->html()."</br>";
            }                     
        });
        return view('seminovos',['html' => $html]);            
    }

    public function pesquisar(Request $request){

        $marca = ($request->marca) ? ('/marca/'.$request->marca) : '' ;
        $modelo = ($request->modelo) ? ('/modelo/'.$request->modelo) : '' ;

        $valor1 = ($request->valor1) ? ('/valor1/'.$request->valor1) : '' ;
        $valor2 = ($request->valor2) ? ('/valor2/'.$request->valor2) : '' ;

        $ano1 = ($request->ano1) ? ('/ano1/'.$request->ano1) : '' ;
        $ano2 = ($request->ano2) ? ('/ano2/'.$request->ano2) : '' ;

        $idCidade = ($request->idCidade) ? ('/cidade/'.$request->idCidade) : '' ;
        
        $usuario ='todos'; 
        if ($request->particular && $request->revenda ) {
            $usuario ='todos';  
        }elseif($request->particular) {
            $usuario ='particular'; 
        }elseif($request->revenda){
            $usuario ='revenda'; 
        }        
        $url = 'https://www.seminovosbh.com.br/resultadobusca/index/veiculo/'.$request->veiculo.'/estado-conservacao/'.$request->veiculo_zero_km.''
        .$marca.''.$modelo.''.$valor1.''.$valor2.''.$ano1.''.$ano2.''.$idCidade.'/usuario/'.$usuario;        
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $html = '';
        $data = array();
        $crawler->filter('.bg-busca')->each(function ($node, $index) use(&$html, &$data) {
            $aux = $node->html();             
            $p = explode('<p>', $aux);
            $ano = explode('</p>', $p[1])[0];
            $km = trim(explode(' </p>', $p[2])[0]);
            $portas = explode('</p>', $p[3])[0];
            $banco = explode('</p>', $p[4])[0];
            $gasolina = explode('</p>', $p[5])[0];
            $descricoes = explode('<span>',$p[5]);
            unset($descricoes[0]);            
            $des = array();
            foreach ($descricoes as $key => $descricao) {
                $descricao = explode('</span>', $descricao)[0];
                array_push($des, $descricao);
            }
            $aux = explode('<h4>', $aux)[1];
            $aux = explode('<span', $aux);
            $nome = $aux[0];
            $nome = explode('<span',$nome)[0];
            $aux = explode('</span>', $aux[1])[0];
            $valor = str_replace(' class="preco_busca"> ','', $aux);
            $valor = explode('<img', $valor)[0];
            $informacao = array();
            $informacao = array('nome'=> $nome, 'valor'=> $valor, 'ano'=> $ano, 'km'=> $km, 'portas'=> $portas, 'banco'=> $banco, 'gasolina'=> $gasolina, 'descricao'=>$des);
            array_push($data, $informacao);            
        });
        return response()->json($data, 200);        
    }
}
