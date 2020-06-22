<?php $this->load->view('viewer/V_sidebar'); ?>

<body>
    <main class="page-content">
        <div class="container">
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
            </table>
        </div>
        <div id="body">
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
                            "url": '<?php echo site_url('viewer/json'); ?>',
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

                            }
                        ],

                    });

                });
            </script>
    </main>
</body>

</html>