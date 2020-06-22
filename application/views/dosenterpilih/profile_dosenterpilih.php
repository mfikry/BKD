<html>

<head>
    <title>My Profile</title>
    <link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<?php $this->load->view('dosenterpilih/V_sidebar'); ?>

<body>
    <main class="page-content ">
        <div class="card mb-3" style="max-width: 540px;">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="<?= base_url('assets/img/user.png'); ?>" class="card-img" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h1 class="card-title"><?= $user['name']; ?></h1>
                        <p style="font-size: 15;" class="card-text"><?= $user['email']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>