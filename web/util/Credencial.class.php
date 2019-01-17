<?php

class Credencial {
  
    public function __construct($email_usuario = null, $senha_fornecida = null)
    {
          if(!is_null($email_usuario) && !is_null($senha_fornecida)){
              return $this->autenticar($email_usuario, $senha_fornecida);
          }
    }
    public function autenticar($email, $senha)
    {
          $emails = explode('\|', $email);
        if($email)
          {
              return $this->estaAutenticado($email, $senha);
          }
          else //nao foi passado emails validos
          {
              return false;
          }
    }
    public static function estaAutenticado($email,$senha) {

      $idUsuarioLogin = Usuario::buscar(array("email = '" . $email . "'"));
      if ($idUsuarioLogin)
      {
          $Usuario = new Usuario($idUsuarioLogin["idUsuario"]);
          if (($Usuario->senha == crypt($senha, $Usuario->senha)) && $Usuario->ativo)
          {
              $this->registrarLogCredenciaisSession($Usuario, $email);
          }
          else
          {
              self::registrarTentativaFalhaLogin($email, $senha, $Usuario->ativo ? self::NIVEL_ERRO_SENHA : self::NIVEL_ERRO_DESATIVADO);
              return false;
          }
      } else {
          self::registrarTentativaFalhaLogin($email, $senha, self::NIVEL_ERRO_LOGIN);
          return false;
      }
      
    }
      
      
//       /**
//      * Lista com todas as permissões do usuário autenticado no momento.
//      * Definido no método 'estaAutenticado'.
//      *
//      * @var array
//      * @see Credencial::estaAutenticado()
//      */
//     private static $permissoes_conhecidas = array();

//     /**
//      * Armazena o Usuário autenticado atualmente (definido no método 'estaAutenticado') de maneira estática, para que em todo
//      * o restante DESTA mesma execução não seja necessário mais instanciar o objeto fazendo consultas no banco de dados.
//      *
//      * @var Usuario
//      * @see Credencial::estaAutenticado()
//      */
//     private static $UsuarioLogado;

//     /**
//      * Armazena o datetime do momento em que foi registrado o log da passagem do usuário durante essa execução.
//      * Esse valor é armazenado em uma variável estática para que em todo o restante DESTA execução não seja necessário
//      * escrever no banco de dados o log desta passagem, já que trata-se de apenas uma execução.
//      * Apenas o método 'estaAutenticado' utiliza esse recurso.
//      *
//      * @var string
//      * @see Credencial::estaAutenticado()
//      */
//     private static $registrado_log_execucao;

//     /**
//      * Delimitador de erro em nível de senha errada.
//      */
//     const NIVEL_ERRO_SENHA = 'senha';

//     /**
//      * Delimitador de erro em nível de autenticação errada.
//      */
//     const NIVEL_ERRO_LOGIN = 'login';

//     /**
//      * Delimitador de erro em nível de não ser usuário do suporte.
//      */
//     const NIVEL_ERRO_SUPORTE = 'suporte';

//     /**
//      * Delimitador de erro de conta desativada.
//      */
//     const NIVEL_ERRO_DESATIVADO = 'desativado';

//     /**
//      * Delimitador de erro em nível desconhecido.
//      */
//     const NIVEL_ERRO_DESCONHECIDO = 'desconhecido';

//     /**
//      * Determina o tempo em minutos de espera para notificar do usuário após uma série de tentativas de login com senha errada
//      */
//     const TEMPO_ESPERA_NOTIFICACAO = 5;

//     /**
//      * Nome do arquivo que contém a lista de usuários de suporte que fazem login através de smtp do gmail.
//      */
//     const LISTA_USUARIOS_SUPORTE = 'usuarios-suporte.json';

//     /**
//      * Nome do arquivo de cache que contém a lista de usuários de suporte que fazem login através de smtp do gmail.
//      */
//     const LISTA_USUARIOS_SUPORTE_LOCAL = 'cache-usuarios-suporte.json';

//     /**
//      * Cria uma série de dados na sessão que formam um credencimento que irá possobilitar o acesso do usuário em páginas específicas de acordo com seus privilégios.
//      * Atenção: O construtor oferece uma 'porta dos fundos' para o suporte Vector.
//      * Os usuários de suporte são autenticados via gmail e pertencem a uma lista de usuarios de suporte.
//      * Ao fazer o login é possível passar dois emails como parametro separados por pipe. O primeiro email deve pertencer a lista de suporte.
//      * O segundo email deve ser não suporte. Dessa maneira, o usuário suporte loga como um usuário diferente.
//      * @param String $email_usuario Endereço eletrônico (já formatado, esse método não irá validar o e-mail) que deverá estar presente no banco e associado a mesma senha fornecida no segundo parâmetro.
//      * @param String $senha_fornecida Senha (ainda sem a criptografia) fornecida pelo usuário, essa é a mesma senha fornecida pelo usuário no cadastro.
//      * @return bool Caso os dados fornecidos coincidam com os dados presentes no banco, valores são armazenados na sessão formando a credencial de reconhecimento do usuário.
//      */
//     public function __construct($email_usuario = null, $senha_fornecida = null)
//     {
//         if(!is_null($email_usuario) && !is_null($senha_fornecida))
//             return $this->autenticar($email_usuario, $senha_fornecida);
//     }
// /*
//      * Verifica se os emails sao validos, e checa qual tipo de autenticacao sera realizada.
//      * Caso apenas um email foi passado como parametro, realiza autenticacao padrao.
//      * Caso apenas um email de suporte, realiza autentica de suporte.
//      * Caso dois emails, o primeiro de suporte e o outro comum, realiza a autenticacao direcionada. Na qual o suporte entra com o perfil
//      * do email comum
//      * @param string $email
//      * @param string $senha
//      * @return bool Se esta autentica retorna true, senao, retorna false
//      */
//     private function autenticar($email, $senha)
//     {
//         $emails = explode('\|', $email);

//         //$emails = split('\|', $email);

//         $validacao_email_1 = (isset($emails[0]) && Util::validarEmail($emails[0]))? true : false; //email de login
//         $validacao_email_2 = (isset($emails[1]) && Util::validarEmail($emails[1]))? true : false; //email de autorizacao
//         $eh_suporte = ($validacao_email_1 && (self::pertenceListaAuthGmail($emails[0]))) ? true : false;

//         if($eh_suporte && $validacao_email_2)
//         {
//             $this->autenticarSuporteDirecionado($emails[0],$emails[1],$senha);
//         }
//         else if($eh_suporte && !$validacao_email_2)
//         {
//             $this->autenticarSuporte($emails[0],$senha);
//         }
//         else if($validacao_email_1 && !$eh_suporte && !$validacao_email_2)
//         {
//             $this->autenticarPadrao($emails[0], $senha);
//         }
//         else //nao foi passado emails validos
//         {
//             return false;
//         }
//         return self::estaAutenticado();
//     }
//        /**
//      * Realiza a autenticacao padrao de um email que pertenca a lista de usuarios no banco
//      * @param string $email
//      * @param string $senha
//      * @return void
//      */
//     private function autenticarPadrao($email_usuario, $senha_fornecida)
//     {
//         $id_usuario_login = Usuario::buscar(array("email = '" . $email_usuario . "'"));
//         if ($id_usuario_login)
//         {
//             $Usuario = new Usuario($id_usuario_login[0]["id_usuario"]);
//             if (($Usuario->senha == crypt($senha_fornecida, $Usuario->senha)) && $Usuario->ativo)
//             {
//                 $this->registrarLogCredenciaisSession($Usuario, $email_usuario);
//             }
//             else
//             {
//                 self::registrarTentativaFalhaLogin($email_usuario, $senha_fornecida, $Usuario->ativo ? self::NIVEL_ERRO_SENHA : self::NIVEL_ERRO_DESATIVADO);
//                 return false;
//             }
//         }
//         else
//         {
//             self::registrarTentativaFalhaLogin($email_usuario, $senha_fornecida, self::NIVEL_ERRO_LOGIN);
//             return false;
//         }
//     }
//        /**
//      * Este método é um dos mais importantes dessa classe, pois ele é o que dará acesso ou não do usuário ao resto do sistema.
//      * Primeiro ele verifica se há dados de credencial na sessão. Caso exista ele registra a passagem
//      * do usuário registrando um log da verificação e armazenando essa informação em uma variável estática para evitar escrever no banco
//      * todas as vezes nesta mesma execução. Depois ele verifica se o usuário está ativo, pois
//      * caso ele seja desativado no meio de uma sessão autenticada, sua sessão deverá cair.
//      * Caso esteja desativado a credencial é apagada.
//      * Caso o usuário esteja autenticado corretamente, o método armazena o objeto do usuário autenticado numa
//      * variável estática privada e lista todos os privilégios do usuário, inclusive herdados de grupos, em um
//      * array e em uma variável também estática e privada.
//      *
//      * @return bool Retorna true caso os dados na sessão existam e estejam de acordo com os dados no banco de dados ou false caso contra.
//      */
//     public static function estaAutenticado()
//     {
//         /*
//          * Esta constante só precisa ser setada ou verificada uma vez POR REQUISIÇÃO. Repare bem que essa constante não se comporta como sessão
//          * ou cookie, que permanecem com o mesmo valor por várias requisições! Portanto a cada requisição esse método só fará as verificações
//          * de login, senha, sessão, ativo, etc. UMA VEZ, pq para o resto da requisição os dados permanecerão os mesmos! (a não ser que em uma milhonésimo
//          * de segundo a senha do camarada mude ou ele seja desativado...
//          */
//         if (!is_null(self::$UsuarioLogado))
//             return true;
//         if (isset($_SESSION["credenciais"]["id_usuario"])) {

//             $Usuario = new Usuario($_SESSION["credenciais"]["id_usuario"]);

//             $log = new UsuarioLog($_SESSION["credenciais"]["id_session_log"]);
//             $log->data_ult_contato = date("Y-m-d H:i:s");
//             $log->salvar();
//             self::$registrado_log_execucao = $log->data_ult_contato;
//             if (!$Usuario->ativo) {
//                 self::apagarCredencial();
//                 return false;
//             }
//             if ($_SESSION["credenciais"]["email"] == $Usuario->email && $_SESSION["credenciais"]["senha"] == $Usuario->senha) {
//                 /*
//                  * Verifica se o atributo estárico que armazena o usuário autenticado já foi criado, caso contrário cria.
//                  */
//                 self::$UsuarioLogado = $Usuario;
//                 foreach ($Usuario->getPrivilegios() as $registro_privilegio)
//                     self::$permissoes_conhecidas[$registro_privilegio['nick']] = true;
//                 foreach ($Usuario->getPrivilegiosHerdados() as $registro_privilegio)
//                     self::$permissoes_conhecidas[$registro_privilegio['nick']] = true;
//                 return true;
//             } else {
//                 self::abrirSession();
//                 $email_sessao = $_SESSION["credenciais"]["email"];
//                 $senha_sessao = $_SESSION["credenciais"]["senha"];
//                 self::$UsuarioLogado = null;
//                 self::$permissoes_conhecidas = array();
//                 try {
//                     /*
//                      * Esta exceção é disparada em silêncio para não deixar o usuário final perceber que foi detectada os dados incorretos.
//                      */
//                     throw new Excecao("ID de usuário encontrado na sessão, porém valores de e-mail e/ou senha não conferem ($email_sessao e " . $Usuario->email . ") ou ($senha_sessao e " . $Usuario->senha . ")");
//                 } catch (Excecao $r) {
//                     $_SESSION["credenciais"] = null;
//                     self::fecharSession();
//                     return false;
//                 }
//             }
//         } else
//             return false;
//     }
//        /**
//      * Abre a sessão para escrita para a classe poder alterar os dados da sessão.
//      * A sessão deve permanecer fechada para escrita enquanto não estiver sendo utilizada, para evitar que as
//      * requisições assíncronas tenham que fazer 'fila' para re-escrever o resultado, pois como a sessão só pode
//      * ser aberta para escrita por um script por vez, os scripts precisavam aguardar que o atual finalizasse a requisição.
//      *
//      * @see http://www.php.net/manual/pt_BR/function.session-write-close.php
//      */
//     private static function abrirSession()
//     {
//         session_start();
//     }

//     /**
//      * Fecha a sessão para escrita.
//      * Nota: Para que fazer um método que só faz executar uma função nativa?
//      * Resposta: Como nós queríamos encapsular a abertura da escrita da sessão no método 'abrirSession' para que
//      * os parâmetros de abertura fossem sempre os mesmos, não ficaria padronizado e organizado se para abrir
//      * fosse um método emcapsulado e para fechar fosse a função nativa do PHP.
//      *
//      * @see http://www.php.net/manual/pt_BR/function.session-write-close.php
//      */
//     private static function fecharSession()
//     {
//         session_write_close();
//     }
//   }
}