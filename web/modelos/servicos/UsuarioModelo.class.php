<?php 	
/** 	
 * Apenas extende a classe TrataDados para a criação dos 	
 * campos dos formulários. 	
 * 	
 * @author Camilla Nicolau 	
 * @version 1.0 	
 * @copyright 2019	
 */ 	
class UsuarioModelo extends Tratamentos 	
{ 	
 	
    const PREFIXO_MINIATURA = 'mini_'; 	
    const PREFIXO_ORIGINAL = 'original_'; 	
  	
    public function __construct() 	
    { 	
        // nada a fazer aqui... 	
    } 	
     	
    public static function verificaTamanhoImagem($tamanho) { 	
        $siglas = array(" Bytes", " KB", " MB", " GB", " TB"); 	
        $tamanho = round($tamanho/pow(1024, ($i = floor(log($tamanho, 1024)))), 2) . $siglas[$i]; 	
        return $tamanho; 	
    } 	
   	
    public static function verificaPasta(Usuario $Usuario) 	
    { 	
        if (!file_exists(PATH_USUARIO . $Usuario->idUsuario)) { 	
            mkdir(PATH_USUARIO . $Usuario->idUsuario, 0777, true); 	
        } 	
        return $Usuario->idUsuario . '/'; 	
    }
    
    /** 	
     * Carrega o arquivo de imagem e armazena os dados da foto no banco de dados. 	
     * 	
     * @param string $path_imagem Caminho para o arquivo. 	
     * @return bool 	
     */ 	
    public static function salvaFoto($path_imagem) { 	
        	
        $Usuario = new Usuario(); 	
        	
        $image_path_info = pathinfo($path_imagem['name']); 	
       	
        if(!$Usuario->urlImagem) { 	
            if ($Usuario->nome) { 	
                $nomeImagem = Tratamentos::padraoUrl($Usuario->nome); 	
            } else { 	
                $nomeImagem = Tratamentos::padraoUrl($image_path_info['filename']); 	
            } 	
            $Usuario->urlImagem = $nomeImagem . '.' . $image_path_info['extension']; 	
          	
        } 	
        	
        //Imagem Original 	
        $ImagemOriginal = new Imagem($path_imagem['tmp_name']); 	
        $ImagemOriginal->redimensionar(true, IMAGEM_ORIGINAL_MAX_LARGURA, IMAGEM_ORIGINAL_MAX_ALTURA); 	
        $ImagemOriginal->salvar(PATH_USUARIO . UsuarioModelo::verificaPasta($Usuario). self::PREFIXO_ORIGINAL . $Usuario->urlImagem); 	
 	
        //Imagem miniatura 	
        $ImagemMiniatura = new Imagem($path_imagem['tmp_name']); 	
        $ImagemMiniatura->redimensionar(true, IMAGEM_MINI_LARGURA, IMAGEM_MINI_ALTURA);
        $ImagemMiniatura->salvar(PATH_USUARIO . UsuarioModelo::verificaPasta($Usuario). self::PREFIXO_MINIATURA .  $Usuario->urlImagem);      	
    } 	
} 