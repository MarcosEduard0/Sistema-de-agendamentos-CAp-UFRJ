<?php
$attrs = [
	'class' => 'cssform-stacked up-form',
	'ldap-test' => '',
	'up-target' => '#ldap_test_results',
	'up-history' => 'false',
];

$hidden = [
	'ldap_server' => '',
	'ldap_port' => '',
	'ldap_version' => '',
	'ldap_use_tls' => '',
	'ldap_ignore_cert' => '',
	'ldap_bind_dn_format' => '',
	'ldap_base_dn' => '',
	'ldap_search_filter' => '',
	'ldap_attr_firstname' => '',
	'ldap_attr_lastname' => '',
	'ldap_attr_displayname' => '',
	'ldap_attr_email' => '',
];

echo form_open('settings/authentication/ldap_test', $attrs, $hidden);

?>

<fieldset>

	<div class="fieldset-description">
		<p><small>Altere as configurações à esquerda e insira um nome de usuário e senha aqui para testá-los. Você não precisa clicar em Salvar antes de testar as credenciais.</small></p>
		<p><small>Essas credenciais são passadas apenas para o servidor LDAP e nunca são salvas ou armazenadas.</small></p>
		<br>
	</div>

	<legend accesskey="T" tabindex="<?php echo tab_index() ?>">Configurações de teste</legend>

	<p class="input-group">
		<?php
		echo form_label('Usuário', 'username');
		echo form_input([
			'name' => 'username',
			'id' => 'username',
			'size' => '30',
			'maxlength' => '50',
			'tabindex' => tab_index(),
			'class' => 'form-control',
		]);
		?>
	</p>

	<p class="input-group">
		<?php
		echo form_label('Senha', 'password');
		echo form_password([
			'name' => 'password',
			'id' => 'password',
			'size' => '30',
			'maxlength' => '50',
			'tabindex' => tab_index(),
			'class' => 'form-control',
		]);
		?>
	</p>

	<?php
	echo form_submit([
		'value' => 'Test credentials',
		'tabindex' => tab_index(),
	]);
	?>

</fieldset>

<div class="loading-notice">Testando a conexão...</div>

<div id="ldap_test_results"></div>

<?= form_close() ?>