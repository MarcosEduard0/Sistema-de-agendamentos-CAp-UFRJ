<form class="needs-validation" novalidate="true">
	<div class="form-row" align="center">
		<div class="form-group col-md-5"></div>
		<div class="col-3" style="place-self: center;">
			<label for="multi_select" class="ni" style="display: inline-block;margin-bottom:8px">
				<input type="checkbox" id="multi_select" name="multi_select" value="1" up-switch=".multi-select-content">
				Agendamento recorrente
			</label>
		</div>
		<div class="row" style="padding-left: 15%; visibility: hidden;" id="btn_recurring">
			<p>Caso seja defino outras semanas/ciclos como: 1º Bimestre, 2º Bimestre, etc. O agendamento recursivo do durará até o fim da semana realiazado, ou seja, até o fim do Xª Bimestre.</p>
			<p>Caso contrário, onde só temos uma semana/ciclo definada para representar o Ano Letivo inteiro, os dias e horários selecionados serão agendados até do Ano Letivo, sendo assim, o usuário precisará futuramente fazer o cancelamento manualmente.</p>

			<div class="col-12">
				<!-- <button style="margin-bottom: 0.4%; visibility: hidden;" id="btn_recurring" type="submit" name="btn_recurring" value="recurring" class="btn btn-primary">Fazer agendamentos...</button> -->

				<label for="notes">Descrição:</label> <input class="form-control2" type="text" name="notes" id="notes" size="20" maxlength="100" value="<?php echo html_escape($this->session->userdata('notes')) ?>" />
				&nbsp;<label for="user_ud">Usuário:</label>
				<?php
				$userlist['0'] = '(Nenhum)';
				foreach ($users as $user) {
					if ($user->displayname == '') {
						$user->displayname = $user->username;
					}
					$userlist[$user->user_id] = html_escape($user->displayname);		#@field($user->displayname, $user->username);
				}
				$user_id = $this->userauth->user->user_id;
				echo form_dropdown('user_id', $userlist, $user_id, 'id="user_id" class="form-control2"');
				?>
				<button style="margin-bottom: 0.4%;" type="submit" name="btn_recurring" value="recurring" class="btn btn-primary">Fazer agendamentos...</button>
			</div>
		</div>

	</div>
</form>