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

$lang['imglib_source_image_required'] = 'Você deve especificar uma imagem de origem em suas preferências.';
$lang['imglib_gd_required'] = 'A biblioteca de imagens GD é necessária para este recurso.';
$lang['imglib_gd_required_for_props'] = 'Seu servidor deve suportar a biblioteca de imagens GD para determinar as propriedades da imagem.';
$lang['imglib_unsupported_imagecreate'] = 'Seu servidor não suporta a função GD necessária para processar este tipo de imagem.';
$lang['imglib_gif_not_supported'] = 'Imagens GIF geralmente não são suportadas devido a restrições de licenciamento. Talvez seja necessário usar imagens JPG ou PNG.';
$lang['imglib_jpg_not_supported'] = 'Imagens JPG não são compatíveis.';
$lang['imglib_png_not_supported'] = 'Imagens PNG não são compatíveis.';
$lang['imglib_jpg_or_png_required'] = 'O protocolo de redimensionamento de imagem especificado em suas preferências funciona apenas com os tipos de imagem JPEG ou PNG.';
$lang['imglib_copy_error'] = 'Foi encontrado um erro ao tentar substituir o arquivo. Certifique-se de que seu diretório de arquivos seja gravável.';
$lang['imglib_rotate_unsupported'] = 'A rotação da imagem não parece ser compatível com o seu servidor.';
$lang['imglib_libpath_invalid'] = 'O caminho para sua biblioteca de imagens não está correto. Defina o caminho correto em suas preferências de imagem.';
$lang['imglib_image_process_failed'] = 'O processamento da imagem falhou. Verifique se o seu servidor suporta o protocolo escolhido e se o caminho para a sua biblioteca de imagens está correto.';
$lang['imglib_rotation_angle_required'] = 'É necessário um ângulo de rotação para girar a imagem.';
$lang['imglib_invalid_path'] = 'O caminho para a imagem não está correto.';
$lang['imglib_invalid_image'] = 'A imagem fornecida não é válida.';
$lang['imglib_copy_failed'] = 'A rotina de cópia da imagem falhou.';
$lang['imglib_missing_font'] = 'Incapaz de encontrar uma fonte para usar.';
$lang['imglib_save_failed'] = 'Incapaz de salvar a imagem. Certifique-se de que a imagem e o diretório do arquivo sejam graváveis.';
