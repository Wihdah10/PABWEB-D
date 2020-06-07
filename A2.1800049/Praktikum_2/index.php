<?php
//panggil file database.php untuk koneksi ke database
require_once "config/database.php";
?>

<!doctype html>				<!-- HTML 5 -->
<html lang="en">			<!-- tag pembuka html -->
	<head>
		<!--Required meta tag -->
		<meta carshet="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Aplikasi Pengelolaan Data Siswa dengan PHP7, MySQLi, dan Bootstrap 4">
		<meta name="keywords" content="Aplikasi Pengelolaan Data Siswa dengan PHP7, MySQLi, dan Bootstrap 4">
		<meta name="author" content="Fajar Lukman Nugraha">

		<!-- favicon -->
		<link rel="shortcut icon" href="assets/img.favicon.png">
		<!-- bootstrap CSS -->
		<link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-4.1.3/dist/css/bootstrap.min.css">
		<!-- datepicker CSS -->
		<link rel="stylesheet" type="text/css" href="assets/plugins/datepicker/css/datepicker.min.css">
		<!-- font awesome -->
		<link rel="stylesheet" type="text/css" href="assets/plugins/fontawesome-free-5.4.2-web/css/all.min.css">
		<!-- Custom CSS -->
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<!--tittle-->
		<tittle>Data Siswa</tittle>
	</head>
	<body>
		<div class="container-fluid">	
			<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 md-3 bg-white border-bottom shadow-sm">
				<h5 class="my-0 mr-md-auto font-weight-normal"><i class="fas fa-user title-icon"></i> Data Siswa</h5>
			</div>
		</div>

		<div class="container-fluid">
		<?php
		// fungsi untuk pemanggilan halaman 
		// jika page = kosong atau saat aplikasi pertama dijalankan,tampilkankan halaman tampil_data.php
		if (empty($_GET["page"])) {
			include "tampil_data.php";
		}
		//jika page = tambah, maka tampilan halaman form_tambah_data.php
		elseif ($_GET['page']=='tambah') {
			include "form_tambah.php";
		}
		// jika page = ubah, maka tampilkan halaman form_ubah_data.php
		elseif ($_GET['page']=='ubah') {
			include "form_ubah";
		}
		?>
	</div>

		<div class="container-fluid">
			<footer class="pt-4 my-md-4 pt-md-3 border-top">
				<div class="row">
					<div class="col-12 col-md center">
						&copy; 2020 - <a class="text-info" href="https://stmik-sumedang.ac.id/">❤STMIK Sumedang</a>
					</div>
				</div>
			</footer>
		</div>

	<!--Pemanggilan Library jQuery-->
	<!--yang pertama jQuery, kemudian bootstrap js-->
	<script type="text/javascript" src="assets/js/jquery-3.3.1.js"></script>
	<script type="text/javascript" src="assets/plugins/bootstrap-4.1.3/dist/js/bootstrap.min.js"></script>
	<!--fontawesome js-->
	<script type="text/javascript" src="assets/plugins/fontawesome-free-5.4.2-web/js/all.min.js"></script>
	<!--datepicker js-->
	<script type="text/javascript" src="assets/plugins/datepicker/js/bootstrap-datepicker.min.js"></script>

	<script type="text/javascript">
	// initiate plugin ==============================================================
	//-------------------------------------------------------------------------------
	$(document).ready(function() {
		// datepicker plugins
		$('.date-picker').datepicker({
			autoclose: true,
			todayHighlight: true
		});
	} );
	//===============================================================================

	// validasi form tambah dan form ubah ===========================================
	// ------------------------------------------------------------------------------
	// validasi form input tidak boleh kosong
	(function() {
		'use strict';
		window.addEventListener('load',function() {
			// fetch all the form we want to aplly custom bootstrap validation styles to
			var forms = document.getElementsByClassName("needs-validation");
			// loop over them and prevent submission 
			var validation = Array.prototype.filter.call(forms, function(form) {
				form.addEventListener('submit',function(event) {
					if (form.checkValidity() === false) {
						event.preventDefault();
						event.stopPropagation();
					}
					form.classList.add('was-validated');
				}, false);
			});
		}, false);
	})();

	//validasi karakter yang boleh diinputkan pada form
	function getkey(e) {
		if (window.event)
			return window.event.keyCode;
		else if (e)
			return e.which;
		else
			return null;
	}

	function goodchars(e, good, field) {
		var key, keychar;
		key = getkey(e);
		if (key == null) return true;

		keychar = String.fromCharCode(key);
		keychar = keychar.toLowerCase();
		goods 	= goods.toLowerCase();

		//check goodkeys
		if (goods.indexOf(keychar) != -1)
			return true;
		//control keys
		if (key==null || key==0 || key==8 || key==9 || key==27 )
			return true;

		if (key==13) {
			var i;
			for (i = 0; i < field.form.elements.length; i++)
				if (field == field.form.elements[i])
				break;
				i = (i + 1) %field.form.elements.length;
				field.form.elements[i].focus();
			return false;
		};
		// else return false
		return false
	}

	// validasi image dan priview image sebelum upload
	function validasFile() {
		var fileInput		= document.getElementById('foto');
		var filePath		= fileInput.value;
		var fileSize		= $('#foto')[0].files[0].size;
		//tentukan extension yang diperbolehkan 
		var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
		//jika tipe file yang diupload tidak sesuai dengan allowedExtensions, tampilkan pesan : 
		if (!allowedExtensions.exec(filePath)) {
			alert('Tipe file foto tidak sesuai. Harap unggah file foto yang memiliki tipe *.jpg atau *.png');
			fileInput.value = '';
			document.getElementById('imagePreview').innerHTML = '<img class="foto-preview" src="foto/default.png"/>';
			return false;
		}
		// jika ukuran file yang diupload lebih dari sama dengan 1 Mb
		else if (fileSize >= 1000000) {
			alert('Ukuran file foto lebih dari 1 Mb. Harap unggah file foto yang memiliki ukuran maksimal 1 Mb.');
			fileInput.value = '';
			document.getElementById('imagePreview').innerHTML = '<img class="foto-preview" src="foto/default.png"/>';
			return false;
		}
		//selain itu
		else {
			// image priview
			if (fileInput.files && fileInput.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
				document.getElementById('imagePreview').innerHTML = '<img class="foto-preview"src="'+e.target.result+'"/>';
				};
			reader.readAsDataURL(fileInput.files[0]);
			}
		}} 
		//=========================================================================
		</script>
	</body>
</html>