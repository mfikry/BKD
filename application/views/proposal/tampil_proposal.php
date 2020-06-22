<link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<?php $this->load->view('proposal/V_sidebar'); ?>

<body>
    <main class="page-content">
        <div class="container">
            <h1>Home</h1>
            <br>
            <?= $this->session->flashdata('message'); ?>
            <br>
            <table id="data-table" class="table table-bordered table-fit responsive">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">JUDUL</th>
                        <th scope="col">JENIS</th>
                        <th scope="col">FILE</th>
                        <th scope="col">NILAI</th>
                        <th scope="col">ACTION</th>
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
                        "order": [], //Initial no order.
                        // Load data for the table's content from an Ajax source
                        "ajax": {
                            "url": '<?php echo site_url('proposal/json'); ?>',
                            "type": "POST"
                        },
                        //Set column definition initialisation properties.
                        "columns": [{
                                "data": "id_proposal",
                                width: 150
                            },
                            {
                                "data": "judul",
                                width: 150
                            },
                            {
                                "data": "jenis",
                                width: 150
                            },
                            {
                                "data": "file",
                                width: 150
                            },
                            {
                                "data": "nilai",
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