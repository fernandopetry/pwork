<?php

namespace PWork\Upload;

/**
 *    FERNANDO PETRY
 *                                                   
 *     > 
 *     
 *     Classe: upload
 *     @filesource upload.class.php
 *     @package NC-TRANSPARENCIA
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 26/11/2015 11:12:59
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */
abstract class upload {

    private $destination;
    private $maxFileSize;
    private $Files;
    private $customRename;

//    private $name;
//    private $type;
//    private $size;
//    private $error;
    private $maxUploadServer;
    private $newName;

    /**
     * Método construtor
     * @param array $Files Files do arquivo. Ex.: $_FILES['arquivo']
     * @param string $destination Path completo do destino do arquivo
     * @param mixed $customRename Nome customizado para o arquivo
     * @throws \Exception
     */
    public function __construct($Files, $destination,$customRename=false) {
        
        $this->customRename = $customRename;
        
        $this->Files = $Files;
        
        // RECUPERA O MAXIMO DE TAMANHO PERMITIDO PELO SERVIDOR
        $this->maxUploadServer = PHPUploadMaxSize::getByBytes();

        // VERIFICANDO SE O FILES FOI ENVIADO CORRETAMENTE
        if (!isset($this->Files['error'])) {
            throw new \Exception('Envio incorreto, tente novamente mais tarde!',E_USER_ERROR);
        }

        // INFORMA O DESTINO DO ARQUIVO
        $this->setDestination($destination);

        // VERIFICA SE O TAMANHO DO ARQUIVO ENVIADO É MENOR QUE O PERMITIDO PELO SERVER
        $this->validateSizeFile();

        // VERIFICANDO O ERRO
        if ($this->Files['error'] != 0) {
            throw new \Exception($this->getErrorString($this->Files['error']),E_USER_ERROR);
        }
        
        // GERANDO O NOME DO ARQUIVO
        $this->generateName();
    }

    /**
     * Validar o tamanho do arquivo enviado com o limite do servidor
     * @throws \Exception
     */
    private function validateSizeFile() {
        if ($this->maxUploadServer < $this->Files['size']) {
            throw new \Exception('O arquivo enviado é maior que o permitido pelo servidor. Maximo do servidor é de: ' . PHPUploadMaxSize::getByMegaBytes() . 'Mb por arquivo. Seu arquivo é de '.$this->Files['size'].' Bytes',E_USER_ERROR);
        }
    }

    /**
     * Retorna o mimetype do arquivo
     * @return string
     */
    public function getMimetype() {
        return $this->Files['type'];
    }

    public function getNameOriginal() {
        return $this->Files['name'];
    }

    public function getTmpName() {
        return $this->Files['tmp_name'];
    }

    public function getError() {
        return $this->Files['error'];
    }

    public function getSize() {
        return $this->Files['size'];
    }

    /**
     * Recupera a extensão do arquivo
     * @return string
     */
    public function getExtension() {
        $partials = explode('.', $this->Files['name']);
        $extension = strtolower(end($partials));
        return $extension;
    }

    /**
     * Gerando o nome do arquivo
     * @return string
     */
    private function generateName() {
        
        if($this->customRename&&$this->customRename!=''){
            $newName = \PWork\Util\Helper::removeAccents($this->customRename,'-'); // nome sem acentos
        }else{
            $newName = \PWork\Util\Helper::removeAccents($this->Files['name'],'-'); // nome sem acentos
        }
        
        $extension = $this->getExtension(); // extenção do arquivo
        $nameNoExtension = str_replace('-' . $extension, '', $newName); // nome sem a extensao
        $destination = $this->getDestination();
        
        $reload = true;
        $i = 0;

        do {
            
            $aditional = ($i===0) ? '' : '-' . $i;
            
            $nameEnd = $nameNoExtension . $aditional . '.' . $extension;
            $validate = $destination . DIRECTORY_SEPARATOR . $nameEnd;


            if (!file_exists($validate)) {
                $reload = false;
                $i = '';
            }
            $i++;
            
        } while ($reload);

        $this->newName = $nameEnd;
        return $nameEnd;
    }
    
    public function getNewName(){
        return $this->newName;
    }

    protected function setDestination($destination) {
        $this->destination = $destination;
        return $this;
    }

    protected function setMaxFileSize($maxFileSize) {
        $this->maxFileSize = $maxFileSize;
        return $this;
    }

    protected function getMaxFileSize() {
        if (is_null($this->maxFileSize)) {
            return PHPUploadMaxSize::getByBytes();
        } else {
            return $this->maxFileSize;
        }
    }

    /**
     * Recupera o caminho da pasta de upload
     * @return string
     * @throws \Exception
     */
    protected function getDestination() {

        if (empty($this->destination)) {
            throw new \Exception('Caminho para armazenar o arquivo não foi informado',E_USER_ERROR);
        }

        if (is_dir($this->destination)) {
            return $this->destination;
        } else {
            if (mkdir($this->destination, 0775, true)) {
                return $this->destination;
            } else {
                throw new \Exception('Não foi possível criar o diretório para armazenar o arquivo!',E_USER_ERROR);
            }
        }
    }

    protected function getErrorString($error) {
        // Array com os tipos de erros de upload do PHP
        $_ERROR[0] = 'Não houve erro';
        $_ERROR[1] = 'O arquivo no upload enviado, é maior do que o limite do PHP. Máximo permitido do servidor é : <strong>'.\petry\util\PHPUploadMaxSize::getByMegaBytes().'Mb</strong>.';
        $_ERROR[2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
        $_ERROR[3] = 'O upload do arquivo foi feito parcialmente';
        $_ERROR[4] = 'Não foi feito o upload do arquivo';

        if (array_key_exists($error, $_ERROR)) {
            return $_ERROR[$error];
        } else {
            throw new \Exception('Erro não identificado ao efetuar o upload.',E_USER_ERROR);
        }
    }

}

/*

  COLA $_FILES[arquivo]
  array (size=5)
  'name' => string 'Fotos-da-Natureza.jpg' (length=21)
  'type' => string 'image/jpeg' (length=10)
  'tmp_name' => string '/tmp/phpszBI22' (length=14)
  'error' => int 0
  'size' => int 201787

 */




//Algoritomo:
//- Verificar se tem erro no upload
//- Verificar se o arquivo enviado está permitido ser enviado
//- Gerar um novo nome para o arquivo
//-- Verificar se o nome do arquivo está disponivel
//- Verificar se a pasta de destino existe
//-- Se não existir tentar criar a mesma
//- Mover o arquivo para o disco
//-- Se foi movido com sucesso, gravar no banco de dados
//--- Se a gravação no BD foi ok, finalizar, senão, excluir o arquivo enviado

if (false) {


// Pasta onde o arquivo vai ser salvo
    $_UP['pasta'] = 'uploads/';
// Tamanho máximo do arquivo (em Bytes)
    $_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb
// Array com as extensões permitidas
    $_UP['extensoes'] = array('jpg', 'png', 'gif');
// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
    $_UP['renomeia'] = false;
// Array com os tipos de erros de upload do PHP
    $_UP['erros'][0] = 'Não houve erro';
    $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
    $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
    $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
    $_UP['erros'][4] = 'Não foi feito o upload do arquivo';
// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
    if ($_FILES['arquivo']['error'] != 0) {
        die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['arquivo']['error']]);
        exit; // Para a execução do script
    }
// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
// Faz a verificação da extensão do arquivo
    $extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
    if (array_search($extensao, $_UP['extensoes']) === false) {
        echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
        exit;
    }
// Faz a verificação do tamanho do arquivo
    if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
        echo "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
        exit;
    }
// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
// Primeiro verifica se deve trocar o nome do arquivo
    if ($_UP['renomeia'] == true) {
        // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
        $nome_final = md5(time()) . '.jpg';
    } else {
        // Mantém o nome original do arquivo
        $nome_final = $_FILES['arquivo']['name'];
    }

// Depois verifica se é possível mover o arquivo para a pasta escolhida
    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
        // upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
        echo "upload efetuado com sucesso!";
        echo '<a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
    } else {
        // Não foi possível fazer o upload, provavelmente a pasta está incorreta
        echo "Não foi possível enviar o arquivo, tente novamente";
    }
}