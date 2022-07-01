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

$lang['migration_none_found'] = 'Nenhuma migração foi encontrada.';
$lang['migration_not_found'] = 'Nenhuma migração foi encontrada com o número da versão: %s.';
$lang['migration_sequence_gap'] = 'Há uma lacuna na sequência de migração perto do número da versão: %s.';
$lang['migration_multiple_version'] = 'Existem várias migrações com o mesmo número de versão: %s.';
$lang['migration_class_doesnt_exist'] = 'A classe de migração "%s" não foi encontrada.';
$lang['migration_missing_up_method'] = 'A classe de migração "%s" não tem um método "up".';
$lang['migration_missing_down_method'] = 'A classe de migração "%s" não tem um método "down".';
$lang['migration_invalid_filename'] = 'A migração "%s" tem um nome de arquivo inválido.';
