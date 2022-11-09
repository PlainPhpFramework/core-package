<script>
function ppTogglePassword(clicked, id) {
	var e = document.getElementById(id);
	if (e.type === "password") {
		e.type = "text";
	} else {
		e.type = "password";
	}
	clicked.querySelectorAll('svg').forEach(function(e){
		e.classList.toggle('d-none');
	})
}
</script>