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

$lang['email_must_be_array'] = 'O método de validação de e-mail deve ser passado por um array.';
$lang['email_invalid_address'] = 'Endereço de email invalido: %s';
$lang['email_attachment_missing'] = 'Não foi possível localizar o seguinte anexo de e-mail: %s';
$lang['email_attachment_unreadable'] = 'Não foi possível abrir este anexo: %s';
$lang['email_no_from'] = 'Não é possível enviar e-mail sem cabeçalho "De".';
$lang['email_no_recipients'] = 'Você deve incluir destinatários: Para, Cc ou Cco';
$lang['email_send_failure_phpmail'] = 'Não foi possível enviar e-mail usando PHP mail (). Seu servidor pode não estar configurado para enviar e-mail usando este método.';
$lang['email_send_failure_sendmail'] = 'Não foi possível enviar e-mail usando PHP Sendmail. Seu servidor pode não estar configurado para enviar e-mail usando este método.';
$lang['email_send_failure_smtp'] = 'Não foi possível enviar e-mail usando PHP SMTP. Seu servidor pode não estar configurado para enviar e-mail usando este método.';
$lang['email_sent'] = 'Sua mensagem foi enviada com sucesso usando o seguinte protocolo: %s';
$lang['email_no_socket'] = 'Incapaz de abrir um socket para Sendmail. Verifique as configurações.';
$lang['email_no_hostname'] = 'Você não especificou um nome de host SMTP.';
$lang['email_smtp_error'] = 'O seguinte erro SMTP foi encontrado: %s';
$lang['email_no_smtp_unpw'] = 'Erro: você deve atribuir um nome de usuário e senha SMTP.';
$lang['email_failed_smtp_login'] = 'Falha ao enviar comando AUTH LOGIN. Erro: %s';
$lang['email_smtp_auth_un'] = 'Falha ao autenticar o nome de usuário. Erro: %s';
$lang['email_smtp_auth_pw'] = 'Falha ao autenticar a senha. Erro: %s';
$lang['email_smtp_data_failure'] = 'Incapaz de enviar dados: %s';
$lang['email_exit_status'] = 'Código de status de saída: %s';
