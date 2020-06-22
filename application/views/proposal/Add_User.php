<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Add User</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<?php $this->load->view('proposal/V_sidebar');?>
<main class="page-content">
	<div class="container">
		<h1>Add User</h1>
		<?= $this->session->flashdata('message'); ?>
		<form method="post" action="<?=base_url('proposal/tambah_User')?>" enctype="multipart/form-data">
			<div class="form-group col-sm-7">
				<label>Nama</label>
				<input class="form-control" type="text" name="name" placeholder="Masukan Nama">
				<?= form_error('name', ' <small class="text-danger pl-3">', '</small>'); ?>
			</div>
			<div class="form-group col-sm-7">
				<label>Email</label>
				<input class="form-control" type="text" name="email" placeholder="Masukan Email">
				<?= form_error('email', ' <small class="text-danger pl-3">', '</small>'); ?>
			</div>
			<div class="form-group col-sm-7">
				<label>Password</label>
				<!-- <input type="file" name="img_news"> -->
				<input class="form-control" type="password" name="password1" placeholder="Masukkan Password">
				<?= form_error('password1', ' <small class="text-danger pl-3">', '</small>'); ?>
			</div>
			<div class="form-group col-sm-7">
				<label>Re-Type Password</label>
				<!-- <input type="file" name="img_news"> -->
				<input class="form-control" type="password" name="password2" placeholder="Masukkan ulang Password">
			</div>
			<div class="form-group col-sm-7">
            <p>Please select your gender:</p>
                <input type="radio" id="Admin" name="role_id" value="1">
                <label for="Admin">Admin</label><br>
                <input type="radio" id="Dosen" name="role_id" value="2">
                <label for="Dosen">Dosen</label>
                <input type="radio" id="DosenTerpilih" name="role_id" value="3">
                <label for="DosenTerpilih">Dosen Terpilih</label><br>
                <input type="radio" id="Kaprodi" name="role_id" value="4">
                <label for="Kaprodi">Kaprodi</label>
                <input type="radio" id="Viewer" name="role_id" value="5">
                <label for="Viewwer">Viewer</label>
			</div>
			<div class="form-group col-sm-7">
			<input type="submit" class="btn btn-primary " value="Simpan">
			</div>
		</form>
	</div>
</main>
	<!-- ckeditor -->
	<script src="//cdn.ckeditor.com/4.11.3/standard/ckeditor.js"></script>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>