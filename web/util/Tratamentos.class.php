<?php

/**
 * Esta classe possui métodos estáticos para tratamento
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
 */
class Tratamentos
{

    public static function index($valor) 
    {
        if (preg_match('/_/', $valor)) {
            $valor = str_replace('_', '-', $valor);
        }
        $trata = explode('-', $valor);
        $qte = count($trata);
        for ($i=0; $i < $qte; $i++) { 
            $trata[$i] = ucfirst($trata[$i]);
        }
        return implode('', $trata);
    }
    
    public static function converteData($valor) {
      $data = str_replace("/", "-", $valor);
      return date('Y-m-d', strtotime($data));
    }
    public static function padraoUrl($string = "", $replace = "-")
    {
        $map = array("/À|à|Á|á|å|Ã|â|Ã|ã/" => "a", "/È|è|É|é|ê|ê|ẽ|Ë|ë/" => "e", "/Ì|ì|Í|í|Î|î/" => "i", "/Ò|ò|Ó|ó|Ô|ô|ø|Õ|õ/" => "o", "/Ù|ù|Ú|ú|ů|Û|û|Ü|ü/" => "u", "/ç|Ç/" => "c", "/ñ|Ñ/" => "n", "/ä|æ/" => "ae", "/Ö|ö/" => "oe", "/Ä|ä/" => "Ae", "/Ö/" => "Oe", "/ß/" => "ss", "/[^\w\s]/" => " ", "/\\s+/" => $replace, "/^{$replace}+|{$replace}+$/" => "");
        return strtolower(preg_replace(array_keys($map), array_values($map), $string));
    }
    public static function gerarSenha($qtCaracter = 8)
    {
        $letraMinuscula = str_shuffle('abcdefghijklmnopqrstuvwxyz');

        $letraMaiuscula = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        $numerosAleatorios = (((date('Ymd') / 12) * 24) + mt_rand(800, 9999));
        $numerosAleatorios .= 1234567890;

        $caracterEspeciais = str_shuffle('!@#$%*-');

        $caracteres = $letraMaiuscula.$letraMinuscula.$numerosAleatorios.$caracterEspeciais;

        $senha = substr(str_shuffle($caracteres), 0, $qtCaracter);

        return $senha;
    }
    
}