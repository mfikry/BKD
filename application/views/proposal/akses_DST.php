<head>
    <title>Grant Dosen Terpilih</title>
    <link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        #data-table2_filter {
            padding-left: 500px;
            font-size: 13;
            padding-bottom: 10px;
        }

        #data-table2_paginate {
            padding-left: 430px;
            font-size: 13;
        }

        #data-table2_info {
            font-size: 15;
        }

        #data-table2_length {
            font-size: 13;
        }

        #data-table1_filter {
            padding-left: 500px;
            font-size: 13;
            padding-bottom: 10px;
        }

        #data-table1_paginate {
            padding-left: 430px;
            font-size: 13;
        }

        #data-table1_info {
            font-size: 15;
        }

        #data-table1_length {
            font-size: 13;
        }
    </style>
</head>
<?php $this->load->view('proposal/V_sidebar'); ?>

<body>
    <main class="page-content">
        <div class="container">
            <table id="data-table1" class="table table-bordered table-fit">
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
            <table id="data-table2" class="table table-bordered table-fit">
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
                    table = $('#data-table1').DataTable({
                        "processing": true, //Feature control the processing indicator.
                        "serverSide": true, //Feature control DataTables' server-side processing mode.
                        // "order": [], //Initial no order.
                        // Load data for the table's content from an Ajax source
                        "ajax": {
                            "url": '<?php echo site_url('proposal/dsjson'); ?>',
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
                            "url": '<?php echo site_url('proposal/dstjson'); ?>',
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