<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Proposal</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
	<?php $this->load->view('proposal/V_sidebar'); ?>
	<main class="page-content">
		<div class="container">
			<h1>Edit Data</h1>
			<?= $this->session->flashdata('message'); ?>
			<?php foreach ($data_update->result() as $key) : ?>



				<form method="post" action="<?= base_url('proposal/update') ?>/<?= $key->id_proposal ?>" enctype="multipart/form-data">

					<div class="form-group col-sm-7 ">
						<label>Judul Proposal</label>
						<input class="form-control" type="text" name="judul" value="<?= $key->judul ?>" placeholder="Judul berita">
					</div>
					<div class="form-group col-sm-7">
						<label for="jenis">Jenis Proposal</label>
						<select id="jenis" name="jenis" class="form-control" value="<?= $key->jenis ?>">
							<option value="" selected disabled hidden>--Jenis Proposal--</option>
							<option value="Penelitian">Penelitian</option>
							<option value="Pengajaran">Pengajaran</option>
							<option value="Pengabdian Kepada Masyarakat">Pengabdian Kepada Masyarakat</option>
						</select>
						<!-- <label>Jenis Proposal</label>
						<input class="form-control" name="jenis" value="<?= $key->jenis ?>" placeholder="Jenis Proposal"> -->
					</div>
					<div class="form-group col-sm-7">
						<label>File</label>
						<input class="form-control" type="file" value="<?= $key->file ?>" name="proposal_pdf" placeholder="">
					</div>
					<div class="form-group col-sm-7 ">
						<label>Nilai (1-10)</label>
						<input class="form-control" type="text" name="nilai" value="<?= $key->nilai ?>" placeholder="Nilai Proposal">
					</div>
					<div class="form-group col-sm-7 ">
						<input type="submit" class="btn btn-primary" value="Perbarui">
					</div>
				</form>
		</div>

	<?php endforeach; ?>
	</main>
	<!-- ckeditor -->
	<script src="//cdn.ckeditor.com/4.11.3/standard/ckeditor.js"></script>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>