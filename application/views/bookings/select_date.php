<script>Q.push(function() {
	var input = document.getElementById("chosen_date"),
		form = document.getElementById("bookings_date");
	input.addEventListener("change", function(event) {
		form.submit();
	});
});
</script>
<form action="<?php echo site_url('bookings/load') ?>" method="POST" name="bookings_book" id="bookings_date">
<table>
	<tr>
		<td valign="middle"><label for="chosen_date"><strong>Data:</strong></label></td>
		<td valign="middle">
			<input type="date" name="chosen_date" class="form-control" id="chosen_date" size="10" maxlength="10" value="<?php echo date("Y-m-d", $chosen_date) ?>" onblur="this.form.submit()" />
		</td>
		<td> &nbsp; <input type="submit" class="btn btn-primary" value=" Carregar " /></td>
	</tr>
</table>
</form>

<br />
