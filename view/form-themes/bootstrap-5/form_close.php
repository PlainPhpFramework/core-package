</form>
<script>
!function(form) {
	form[form.length-1].addEventListener('submit', (event) => {
		event.target.querySelectorAll('button').forEach((button) => {
			button.disabled = true;
		});
	});
}(document.getElementsByTagName('form'));
</script>