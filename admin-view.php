<?php ob_start(); ?>

<div class="row mr-5">
	<h1>ACF Converter</h1>
	<legend>Plugin ACF, exibe campos personalizados já salvos fazendo converção para Json, assim é possivel importar para o ACF editar sem a necessidade de recriar todos os campos.</legend>
	<form class="mt-5" action="" method="get">
		<input type="hidden" name="page" value="acf_converter">
		<select class="w-25" id="acf_group_select" name="group">
			<?php foreach ($groups as $key => $group) :?>
				<option value="<?php echo $key; ?>" <?php echo ( $_GET['group'] == $key ) ? 'selected' : '';?> ><?php echo $group['title']; ?></option>
			<?php endforeach; ?>
		</select>
		<button class="btn btn-acf-c w-25 right" type="submit">Visualizar Json</button>
	</form>
	<?php if(isset($json)) : ?>
		<div class="view-json">
			<?php echo "<pre>".$json."</pre>"; ?>
		</div>
		<button class="btn btn-acf-c btn-download w-100" type="button" onclick="acf_converter_download()">Download Arquivo</button>
	<?php endif; ?>
</div>

<script type="text/javascript">
	function acf_converter_download(){
		const filename = <?php echo $file; ?>;
		const jsonStr = JSON.stringify(<?php echo $json; ?>);

		let element = document.createElement('a');
		element.setAttribute('href', 'data:application/json;charset=utf-8,' + encodeURIComponent(jsonStr));
		element.setAttribute('download', filename);

		element.style.display = 'none';
		document.body.appendChild(element);

		element.click();

		document.body.removeChild(element);
	}
</script>

<?php return ob_get_clean(); ?>
