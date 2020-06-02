<?php

namespace Galoa\ExerciciosPhp\TextWrap;

require_once 'TextWrapInterface.php';

class Resolucao implements TextWrapInterface {

  /**
   * {@inheritdoc}
   */
  public function textWrap(string $text, int $length): array {
    $textoFinal = array();
    $inicio = 0;
    $fim = $length-1;
    $verificaCarac;

    // Retornar vazio caso o length seja menor que 1
    if($length<1){
      return $textoFinal;
    }

    if($length >= mb_strlen($text)){ // Se o tamanho do texto for menor do que a largura máxima da linha é só printar o texto inteiro
      $textoFinal[] = $text;
    }
    else{  
      while($inicio <= mb_strlen($text)-$length){ 
        //Verificando posição do primeiro caractere de cada linha
        $verificaCarac = false;
        $auxTexto = "";
        while(!$verificaCarac && $inicio<=mb_strlen($text)){
          if($text[$inicio] == " "){
            $inicio++;
          }
          else{
            $verificaCarac = true;
          }
        }
        if($inicio <= mb_strlen($text)){
          //Verificando posição do último caractere da linha
          $verificaCarac = false;
          $fim = $inicio + $length;
          while($fim>=$inicio && !$verificaCarac){
            if($fim > mb_strlen($text))
              $fim--;
            if($text[$fim] != " "){
              $fim--;
            }
            else{
              $fim--;
              $verificaCarac = true;
            }
          }
          if($inicio>$fim){
            $fim = $inicio+$length-1;
          }
        }

        //Criando as linhas de acordo com inicio e fim dos caracteres no texto
        for($inicio; $inicio<=$fim; $inicio++){
          $auxTexto = $auxTexto . $text[$inicio];
        }
        $textoFinal[] = $auxTexto;
      }

      // Inserindo últimos caracteres do texto, caso o final seja menor que o length
      if($inicio <= mb_strlen($text)){
        $auxTexto = "";
        $verificaCarac = true;
        for($inicio; $inicio<=mb_strlen($text); $inicio++){
          if($text[$inicio] != " " || !$verificaCarac){
            $auxTexto = $auxTexto . $text[$inicio];
            $verificaCarac = false;
          }
        }
        $textoFinal[] = $auxTexto;
      }
    }
    return $textoFinal;
  }
}