<html>

<head>
    <title>Grant Dosen Terpilih</title>
    <link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        #data-table_filter {
            padding-left: 705px;
            font-size: 13;
            padding-bottom: 10px;
        }

        #data-table_paginate {
            padding-left: 580px;
            font-size: 13;
        }

        #data-table_info {
            font-size: 15;
        }

        #data-table_length {
            font-size: 13;
        }
    </style>
</head>
<?php $this->load->view('kaprodi/V_sidebar'); ?>

<body>
    <main class="page-content">
        <div class="container">
            <table id="data-table" class="table table-bordered">
                <h3>Dosen </h3>
                <?= $this->session->flashdata('message1'); ?>
                <br>
                <thead>
                    <tr>
                        <th scope="col">ID </th>
                        <th scope="col">Nama Dosen </th>
                        <th scope="col">Email </th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <table id="data-table2" class="table table-bordered">
                <h3>Dosen Terpilih</h3>
                <br>
                <?= $this->session->flashdata('message2'); ?>
                <br>
                <thead>
                    <tr>
                        <th scope="col">ID </th>
                        <th scope="col">Nama Dosen </th>
                        <th scope="col">Email </th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div id="body">
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
            <script type="text/javascript">
                var save_method; //for save method string
                var table;

                $(document).ready(function() {
                    //datatables
                    table = $('#data-table').DataTable({
                        "processing": true, //Feature control the processing indicator.
                        "serverSide": true, //Feature control DataTables' server-side processing mode.
                        // "order": [], //Initial no order.
                        // Load data for the table's content from an Ajax source
                        "ajax": {
                            "url": '<?php echo site_url('kaprodi/dsjson'); ?>',
                            "type": "POST"
                        },
                        //Set column definition initialisation properties.
                        "columns": [{
                                "data": "id_user",
                                width: 150
                            },
                            {
                                "data": "name",
                                width: 150
                            },
                            {
                                "data": "email",
                                width: 150
                            },
                            {
                                "data": "action",
                                width: 350
                            }
                        ],

                    });
                    table = $('#data-table2').DataTable({
                        "processing": true, //Feature control the processing indicator.
                        "serverSide": true, //Feature control DataTables' server-side processing mode.
                        // "order": [], //Initial no order.
                        // Load data for the table's content from an Ajax source
                        "ajax": {
                            "url": '<?php echo site_url('kaprodi/dstjson'); ?>',
                            "type": "POST"
                        },
                        //Set column definition initialisation properties.
                        "columns": [{
                                "data": "id_user",
                                width: 150
                            },
                            {
                                "data": "name",
                                width: 150
                            },
                            {
                                "data": "email",
                                width: 150
                            },
                            {
                                "data": "action",
                                width: 350
                            }
                        ],

                    });

                });
            </script>
    </main>
</body>

</html>