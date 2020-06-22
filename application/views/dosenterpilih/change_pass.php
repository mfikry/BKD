<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <?php $this->load->view('dosenterpilih/V_sidebar'); ?>
    <main class="page-content">
        <div class="container">
            <h1>Change Password</h1>
            <?= $this->session->flashdata('message'); ?>
            <form method="post" action="<?= base_url('dosenterpilih/ganti_User') ?>" enctype="multipart/form-data">
                <div class="form-group col-sm-7">
                    <label>input Old Password</label>
                    <!-- <input type="file" name="img_news"> -->
                    <input class="form-control" type="password" name="oldpass" placeholder="Masukkan password Lama ">
                    <?= form_error('oldpass', ' <small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group col-sm-7">
                    <label>input New Password</label>
                    <!-- <input type="file" name="img_news"> -->
                    <input class="form-control" type="password" name="newpass" placeholder="Masukkan Password Baru">
                    <?= form_error('newpass', ' <small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group col-sm-7">
                    <label>Re-Type New Password</label>
                    <!-- <input type="file" name="img_news"> -->
                    <input class="form-control" type="password" name="passconf" placeholder="Masukkan ulang Password Baru">
                    <?= form_error('passconf', ' <small class="text-danger pl-3">', '</small>'); ?>
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