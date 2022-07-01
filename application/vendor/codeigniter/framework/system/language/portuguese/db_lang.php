<?php
/**
 * CodeIgniter
 *
 * Uma estrutura de desenvolvimento de aplicativos de código aberto para PHP
 *
 * Este conteúdo é lançado sob a licença MIT (MIT)
 *
 * Copyright (c) 2014 - 2018, British Columbia Institute of Technology
 *
 * A permissão é concedida, gratuitamente, a qualquer pessoa que obtenha uma cópia
 * deste software e arquivos de documentação associados (o "Software"), para lidar
 * no Software sem restrição, incluindo, sem limitação, os direitos
 * usar, copiar, modificar, mesclar, publicar, distribuir, sublicenciar e / ou vender
 * cópias do Software, e para permitir as pessoas a quem o Software é
 * fornecido para tanto, sujeito às seguintes condições:
 *
 * O aviso de direitos autorais acima e este aviso de permissão devem ser incluídos em
 * todas as cópias ou partes substanciais do Software.
 *
 * O SOFTWARE É FORNECIDO "COMO ESTÁ", SEM QUALQUER TIPO DE GARANTIA, EXPRESSA OU
 * IMPLÍCITA, INCLUINDO, MAS NÃO SE LIMITANDO ÀS GARANTIAS DE COMERCIABILIDADE,
 * ADEQUAÇÃO A UM DETERMINADO FIM E NÃO VIOLAÇÃO. EM NENHUMA HIPÓTESE O
 * AUTORES OU TITULARES DE DIREITOS AUTORAIS SÃO RESPONSÁVEIS POR QUALQUER RECLAMAÇÃO, DANOS OU OUTROS
 * RESPONSABILIDADE, SEJA EM AÇÃO DE CONTRATO, DELITO OU DE OUTRA FORMA, DECORRENTE DE,
 * FORA DE OU EM CONEXÃO COM O SOFTWARE OU O USO OU OUTRAS NEGOCIAÇÕES EM
 * O SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2018, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	Licença MIT
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('Nenhum acesso direto ao script permitido');

$lang['db_invalid_connection_str'] = 'Não é possível determinar as configurações do banco de dados com base na string de conexão enviada.';
$lang['db_unable_to_connect'] = 'Não foi possível conectar ao servidor de banco de dados usando as configurações fornecidas.';
$lang['db_unable_to_select'] = 'Incapaz de selecionar o banco de dados especificado: %s';
$lang['db_unable_to_create'] = 'Incapaz de criar o banco de dados especificado: %s';
$lang['db_invalid_query'] = 'A consulta que você enviou não é válida.';
$lang['db_must_set_table'] = 'Você deve definir a tabela do banco de dados a ser usada com sua consulta.';
$lang['db_must_use_set'] = 'Você deve usar o método "set" para atualizar uma entrada.';
$lang['db_must_use_index'] = 'Você deve especificar um índice para corresponder às atualizações em lote.';
$lang['db_batch_missing_index'] = 'Uma ou mais linhas enviadas para atualização em lote não possuem o índice especificado.';
$lang['db_must_use_where'] = 'As atualizações não são permitidas a menos que contenham uma cláusula "where".';
$lang['db_del_must_use_where'] = 'Exclusões não são permitidas, a menos que contenham uma cláusula "where" ou "like".';
$lang['db_field_param_missing'] = 'Para buscar campos, é necessário o nome da tabela como parâmetro.';
$lang['db_unsupported_function'] = 'Este recurso não está disponível para o banco de dados que você está usando.';
$lang['db_transaction_failure'] = 'Falha na transação: reversão realizada.';
$lang['db_unable_to_drop'] = 'Incapaz de descartar o banco de dados especificado.';
$lang['db_unsupported_feature'] = 'Recurso sem suporte da plataforma de banco de dados que você está usando.';
$lang['db_unsupported_compression'] = 'O formato de compactação de arquivo escolhido não é compatível com o seu servidor.';
$lang['db_filepath_error'] = 'Não é possível gravar dados no caminho do arquivo que você enviou.';
$lang['db_invalid_cache_path'] = 'O caminho do cache que você enviou não é válido ou gravável.';
$lang['db_table_name_required'] = 'É necessário um nome de tabela para essa operação.';
$lang['db_column_name_required'] = 'Um nome de coluna é necessário para essa operação.';
$lang['db_column_definition_required'] = 'Uma definição de coluna é necessária para essa operação.';
$lang['db_unable_to_set_charset'] = 'Não foi possível definir o conjunto de caracteres de conexão do cliente: %s';
$lang['db_error_heading'] = 'Ocorreu um erro de banco de dados';
