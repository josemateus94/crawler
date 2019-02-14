<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeminovosController extends Controller{
    
    private $url;

    public function index(){
        $this->url = 'https://www.seminovosbh.com.br/';
        $pesquisa = file_get_contents($this->url);
        $pesquisa = explode('class="input-line"', $pesquisa);        
        unset($pesquisa[0]);        
        //dd($pesquisa);
        $dadosPesquisa = $this->crawlerPesquisa($pesquisa[1]);
        $zeroSemeNovo = $this->zeroSemeNovo($pesquisa[2]);
        $marca = $this->marca($pesquisa[3]);
        
        return view('seminovos',[
            'dadosPesquisa' =>$dadosPesquisa,
            'zeroSemeNovo' =>$zeroSemeNovo,
            'marca' =>$marca
            ]
        );        
    }

    private function crawlerPesquisa($dadosPesquisa){
        $dadosVeiculos = explode('<input',$dadosPesquisa);
        unset($dadosVeiculos[0]);
        $dadosPesquisa = array();                
        $aux = array();
        foreach ($dadosVeiculos as $key => $dadosVeiculo) {
            $aux = array();
            $dados = explode(' ', strstr($dadosVeiculo, 'id'))[0]; 
            $dados = (str_replace('"', "", explode('id=', $dados)[1]));                       
            array_push($aux, $dados);  

            $dados = explode(' ', strstr($dadosVeiculo, 'name'))[0];            
            array_push($aux, $dados);  

            $dados = (explode(' ', strstr($dadosVeiculo, 'value'))[0]);  
            $dados = (str_replace('"', "", explode('value=', $dados)[1]));                    
            $dados = (explode('>',$dados))[0];
            array_push($aux, $dados);  
            
            array_push($dadosPesquisa, $aux);                          
        }
        return $dadosPesquisa;
    }
    
    private function zeroSemeNovo($dadosPesquisa){   
        $dadosVeiculos = explode('<input type="checkbox"', $dadosPesquisa);
        unset($dadosVeiculos[0]);
        $dadosPesquisa = array();                
        $aux = array();
        foreach ($dadosVeiculos as $key => $dadosVeiculo) {
            $aux = array();
            $dados = explode(' ', strstr($dadosVeiculo, 'id'))[0]; 
            $dados = (str_replace('"', "", explode('id=', $dados)[1]));                       
            array_push($aux, $dados);  

            $dados = explode(' ', strstr($dadosVeiculo, 'name'))[0];            
            array_push($aux, $dados);  

            $dados = (explode(' ', strstr($dadosVeiculo, 'value'))[0]);  
            $dados = (str_replace('"', "", explode('value=', $dados)[1]));                    
            $dados = (explode('>',$dados))[0];
            array_push($aux, $dados);  

            $dados = explode('/>', $dadosVeiculo)[1];
            $dados = str_replace(" ","", explode('<img', $dados)[0]);            
            array_push($aux, $dados);  
            
            array_push($dadosPesquisa, $aux);                          
        }
        return $dadosPesquisa;
    }

    private function marca($dadosPesquisa){
        $dadosVeiculos = explode('class="input-line"', $dadosPesquisa)[0];        
        $dadosVeiculos = explode('<option', $dadosVeiculos);
        unset($dadosVeiculos[0]);
        return $dadosVeiculos;
    }
}
