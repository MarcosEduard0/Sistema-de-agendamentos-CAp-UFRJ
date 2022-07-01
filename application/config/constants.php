<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Versão do Agendamentos CAp UFRJ
//
define('VERSION', '3.1.1');

// Tipos de autenticação do usuário
//
define('ADMINISTRADOR', 1);
define('PROFESSOR', 2);

// Modo de demonstração
define('DEMO_MODE', is_file(FCPATH . 'local/.demo'));


/*
|--------------------------------------------------------------------------
| Exibir rastreamento de depuração
|--------------------------------------------------------------------------
|
| Se definido como TRUE, um backtrace será exibido junto com os erros de php. Se
| error_reporting está desabilitado, o backtrace não será exibido, independentemente
| desta configuração
|
*/
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Modos de arquivo e diretório
|--------------------------------------------------------------------------
|
| Essas preferências são usadas ao verificar e definir os modos ao trabalhar
| com o sistema de arquivos. Os padrões são bons em servidores com
| segurança, mas você pode desejar (ou mesmo precisar) alterar os valores em
| certos ambientes (Apache executando um processo separado para cada
| usuário, PHP sob CGI com Apache suEXEC, etc.). Os valores octais devem
| sempre ser usado para definir o modo corretamente.
|
*/
defined('FILE_READ_MODE')  or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| Modos de fluxo de arquivo
|--------------------------------------------------------------------------
|
| Esses modos são usados ao trabalhar com fopen () / popen ()
|
*/
defined('FOPEN_READ')                           or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncar os dados do arquivo existente, usar com cuidado
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncar os dados do arquivo existente, usar com cuidado
defined('FOPEN_WRITE_CREATE')                   or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Códigos de status de saída
|--------------------------------------------------------------------------
|
| Usado para indicar as condições sob as quais o script é exit () ing.
| Embora não haja um padrão universal para códigos de erro, existem alguns
| convenções amplas. Três dessas convenções são mencionadas abaixo, para
| aqueles que desejam fazer uso deles. Os padrões do CodeIgniter eram
| escolhido para o mínimo de sobreposição com essas convenções, embora ainda
| deixando espaço para que outros sejam definidos em versões futuras e pelo usuário
| formulários.
|
| As três principais convenções usadas para determinar os códigos de status de saída
| são como segue:
|
|    Biblioteca C / C ++ padrão (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (Este link também contém outras convenções específicas do GNU)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        or define('EXIT_SUCCESS', 0); // Sem erros
defined('EXIT_ERROR')          or define('EXIT_ERROR', 1); // erro genetico
defined('EXIT_CONFIG')         or define('EXIT_CONFIG', 3); // erro de configuração
defined('EXIT_UNKNOWN_FILE')   or define('EXIT_UNKNOWN_FILE', 4); // arquivo não encontrado
defined('EXIT_UNKNOWN_CLASS')  or define('EXIT_UNKNOWN_CLASS', 5); // classe desconhecida
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // membro da classe desconhecido
defined('EXIT_USER_INPUT')     or define('EXIT_USER_INPUT', 7); // entrada de usuário inválida
defined('EXIT_DATABASE')       or define('EXIT_DATABASE', 8); // erro de banco de dados
defined('EXIT__AUTO_MIN')      or define('EXIT__AUTO_MIN', 9); // menor código de erro atribuído automaticamente
defined('EXIT__AUTO_MAX')      or define('EXIT__AUTO_MAX', 125); // código de erro atribuído automaticamente mais alto
