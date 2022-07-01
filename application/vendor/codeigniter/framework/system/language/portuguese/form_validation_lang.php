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

$lang['form_validation_required']		= 'O campo {field} é obrigatório.';
$lang['form_validation_isset']			= 'O campo {field} deve ter um valor.';
$lang['form_validation_valid_email']		= 'O campo {field} deve conter um endereço de e-mail válido.';
$lang['form_validation_valid_emails']		= 'O campo {field} deve conter todos os endereços de e-mail válidos.';
$lang['form_validation_valid_url']		= 'O campo {field} deve conter um URL válido.';
$lang['form_validation_valid_ip']		= 'O campo {field} deve conter um IP válido.';
$lang['form_validation_min_length']		= '{field} deve ter pelo menos {param} caracteres.';
$lang['form_validation_max_length']		= 'O campo {field} não pode exceder {param} caracteres de comprimento.';
$lang['form_validation_exact_length']		= 'O campo {field} deve ter exatamente {param} caracteres de comprimento.';
$lang['form_validation_alpha']			= 'O campo {field} pode conter apenas caracteres alfabéticos.';
$lang['form_validation_alpha_numeric']		= 'O campo {field} pode conter apenas caracteres alfanuméricos.';
$lang['form_validation_alpha_numeric_spaces']	= 'O campo {field} pode conter apenas caracteres alfanuméricos e espaços.';
$lang['form_validation_alpha_dash']		= 'O campo {field} pode conter apenas caracteres alfanuméricos, sublinhados e travessões.';
$lang['form_validation_numeric']		= 'O campo {field} deve conter apenas números.';
$lang['form_validation_is_numeric']		= 'O campo {field} deve conter apenas caracteres numéricos.';
$lang['form_validation_integer']		= 'O campo {field} deve conter um inteiro.';
$lang['form_validation_regex_match']		= 'O campo {field} não está no formato correto.';
$lang['form_validation_matches']		= '{field}s não estão iguais.';
$lang['form_validation_differs']		= 'O campo {field} deve ser diferente do campo {param}.';
$lang['form_validation_is_unique'] 		= '{field} já em uso.';
$lang['form_validation_is_natural']		= 'O campo {field} deve conter apenas dígitos.';
$lang['form_validation_is_natural_no_zero']	= 'O campo {field} deve conter apenas dígitos e deve ser maior que zero.';
$lang['form_validation_decimal']		= 'O campo {field} deve conter um número decimal.';
$lang['form_validation_less_than']		= 'O campo {field} deve conter um número menor que {param}.';
$lang['form_validation_less_than_equal_to']	= 'O campo {field} deve conter um número menor ou igual a {param}.';
$lang['form_validation_greater_than']		= 'O campo {field} deve conter um número maior que {param}.';
$lang['form_validation_greater_than_equal_to']	= 'O campo {field} deve conter um número maior ou igual a {param}.';
$lang['form_validation_error_message_not_set']	= 'Não foi possível acessar uma mensagem de erro correspondente ao seu nome de campo {field}.';
$lang['form_validation_in_list']		= 'O campo {field} deve ser um dos seguintes: {param}.';
