<!DOCTYPE html>
<html lang="en">

<head>
    <title>PPD-PIMS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/admin/images/mpw-icon.png">

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    <!-- DataTables CSS + JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Bootstrap 4 CSS + JS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Font Awesome (for icons instead of glyphicon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .container {
            margin: 0 auto;
            text-align: center;
            max-width: 1500px;
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
        }

        table.dataTable {
            border: 1px solid #ccc;
        }

        div.dataTables_filter {
            margin-bottom: 5px;
        }

        table.dataTable th,
        table.dataTable td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>


    <div class="container">
        <?php echo "<a href='logout_docs_user.php' style='float:right; margin-right:10px;'>Logout</a>"; ?>
        <h2>DOCUMENTS</h2>
        <a href="" style="align-items: right;"></a>
        <!-- Filter -->
        <!-- <label for="deo-filter">Filter by DEO:</label>
        <select id="deo-filter">
            <option value="">All</option>
        </select> -->

        <!-- Add button -->

        <div class="d-flex justify-content-end mb-2">
            <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#form_modal">
                <i class="fas fa-plus"></i> Add
            </button>
        </div>

        <!-- DataTable -->
        <table id="your-table" class="display" style="width:100%"></table>
    </div>

    <!-- Add Document Modal -->
    <div class="modal fade" id="form_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="save_outgoing_docs.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-plus"></i> New Document</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label>TRACKING NO.</label>
                            <input class="form-control" name="stud_no" required>
                        </div>

                        <div class="form-group">
                            <label>FROM/REQUESTER</label>
                            <textarea class="form-control" name="req" rows="2" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>DOCUMENT DATE</label>
                            <input type="date" class="form-control" name="dat" required>
                        </div>

                        <div class="form-group">
                            <label>TITLE/SUBJECT</label>
                            <textarea class="form-control" name="subject" rows="2" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>CONTENT</label>
                            <textarea class="form-control" name="con" rows="2"></textarea>
                        </div>

                        <div class="form-group">
                            <label>TYPE</label>
                            <select name="type" class="form-control" required>
                                <option value="Communication(External)">Communication(External)</option>
                                <option value="Communication(Internal)">Communication(Internal)</option>
                                <option value="Communication(External) DEO">Communication(External) DEO</option>
                                <option value="Program of Works and Plans">Program of Works and Plans</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>REMARKS</label>
                            <textarea class="form-control" name="remarks" rows="2"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Attach Document (PDF only)</label>
                            <input type="file" name="file" accept=".pdf">
                        </div>

                        <div class="form-group">
                            <label>Attach Document (File2*PDF only)</label>
                            <input type="file" name="file2" accept=".pdf">
                        </div>

                        <div class="form-group">
                            <label>RELEASE TO</label>
                            <select name="rel" class="form-control">
                                <option value=" "> </option>
                                <option value="PLANNING DIVISION">PLANNING DIVISION</option>
                                <option value="PROGRAMMING DIVISION">PROGRAMMING DIVISION</option>
                                <option value="E-BARMM UNIT">E-BARMM UNIT</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Document Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Document Preview</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body" style="height:80vh;">
                    <iframe id="docFrame" style="width:100%; height:100%;" frameborder="0"></iframe>
                </div>

            </div>
        </div>
    </div>







    <div class="modal fade" id="edit_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="update_outgoing_docs.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title"><span class="glyphicon glyphicon-edit"></span> Update</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="stud_id8" id="stud_id8">


                        <!-- <label for="">Incoming/Received</label> -->
                        <div class="form-group">
                            <label for="">TRACKING NO</label>
                            <input class="form-control" name="stud_no" id="stud_no" rows="1">
                        </div>

                        <div class="form-group">
                            <label for="">FROM/REQUESTER</label>
                            <textarea class="form-control" name="req" id="req" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">DOCUMENT DATE</label>
                            <small id="existing_date" class="text-muted"></small>
                            <input class="form-control" type="date" name="dat" id="dat">
                        </div>

                        <div class="form-group">
                            <label for="">TITLE/SUBJECT</label>
                            <textarea class="form-control" name="subject" id="subject" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">CONTENT</label>
                            <textarea class="form-control" name="con" id="con" rows="3"></textarea>
                        </div>


                        <div class="form-group">
                            <label>TYPE</label>
                            <select name="type" id="type" class="form-control" required="required">
                                <option value="Communication(External)">Communication(External)</option>
                                <option value="Communication(Internal)">Communication(Internal)</option>
                                <option value="Communication(External) DEO">Communication(External) DEO</option>
                                <option value="Program of Works and Plans">Program of Works and Plans</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">REMARKS</label>
                            <textarea class="form-control" name="remarks" id="remarks" rows="3"></textarea>
                        </div>


                        <div class="form-group">
                            <label for="file">File(*PDF)</label>
                            <input type="file" class="form-control" name="file" id="file" accept=".pdf">
                            <small id="existing_file" class="text-muted"></small>
                        </div>


                        <div class="form-group">
                            <label>RELEASE TO</label>
                            <select name="rel" id="rel" class="form-control">
                                <option value=" "> </option>
                                <option value="PLANNING DIVISION">PLANNING DIVISION</option>
                                <option value="PROGRAMMING DIVISION">PROGRAMMING DIVISION</option>
                                <option value="E-BARMM UNIT">E-BARMM UNIT</option>
                            </select>
                        </div>


                    </div>
                    <div style="clear:both;"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                                class="glyphicon glyphicon-remove"></span> Close</button>
                        <button name="update" class="btn btn-success"><span class="glyphicon glyphicon-saved"></span>
                            Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(rowData) {
            document.getElementById('stud_id8').value = rowData.stud_id8;
            document.getElementById('stud_no').value = rowData.stud_no;
            document.getElementById('req').value = rowData.req;

            // ✅ Handle date
            if (rowData.dat) {
                const dateObj = new Date(rowData.dat);

                // Format for input[type="date"]
                const year = dateObj.getFullYear();
                const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                const day = String(dateObj.getDate()).padStart(2, '0');
                const formattedForInput = `${year}-${month}-${day}`;

                // Set input value
                document.getElementById('dat').value = formattedForInput;

                // Show user-friendly version
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                const formattedForDisplay = dateObj.toLocaleDateString('en-US', options);
                document.getElementById('existing_date').innerText = "Previously saved: " + formattedForDisplay;
            } else {
                document.getElementById('dat').value = ""; // leave empty
                document.getElementById('existing_date').innerText = "No date saved";
            }

            document.getElementById('subject').value = rowData.subject;
            document.getElementById('con').value = rowData.con;
            document.getElementById('type').value = rowData.type;
            document.getElementById('remarks').value = rowData.remarks;
            document.getElementById('rel').value = rowData.rel;

            if (rowData.file) {
                document.getElementById('existing_file').innerHTML =
                    `Current File: <a href="/admin/uploads/${encodeURIComponent(rowData.file)}" target="_blank">${rowData.file}</a>`;
            } else {
                document.getElementById('existing_file').innerHTML = "No file uploaded";
            }

            $('#edit_modal').modal('show');
        }
    </script>













    <!-- for print -->
    <script>
        function printCustom(rowData) {
            // Safe values
            let stud_no = rowData.stud_no || "";
            let req = rowData.req || "";
            let dat = rowData.dat || "";
            let subjectText = rowData.subject || "";

            // Format date (YYYY-MM-DD -> Month DD, YYYY)
            let formattedDate = dat;
            if (dat) {
                let d = new Date(dat);
                if (!isNaN(d)) {
                    formattedDate = d.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                }
            }

            // Break subject into lines every 120 words
            let words = subjectText.split(" ");
            let result = "";
            words.forEach((word, i) => {
                result += word + " ";
                if ((i + 1) % 120 === 0) {
                    result += "<br>";
                }
            });

            // Build print content
            let content = `
        <p style="margin-left: 324;margin-top:100;"><strong></strong> ${stud_no}</p>
        <p style="margin-top: 25;margin-left:10;"><strong></strong> ${req}</p>
        <p style="margin-top: 25;margin-left:10;"><strong></strong> ${formattedDate}</p>
        <p style="margin-top: -13; margin-left:60; font-size:small;"><strong></strong> ${result}</p>
    `;

            // Open print window
            var printWindow = window.open('', '', 'height=600,width=1000');
            printWindow.document.write('<html><head><title>Print Document</title>');
            printWindow.document.write(`
        <style>
            body {
                margin: 0;
                font-family: Arial, sans-serif;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .print-area {
                width: 100%;
                min-height: 99vh;
                padding: 1px;
                background-image: url('/admin/print/bg-image.jpg');
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
            }
        </style>
    `);
            printWindow.document.write('</head><body>');
            printWindow.document.write('<div class="print-area">' + content + '</div>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();

            printWindow.onload = function() {
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            };
        }
    </script>





    <div class="modal fade" id="modal_confirm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">System</h3>
                </div>
                <div class="modal-body">
                    <center>
                        <h4 class="text-danger">All files will be deleted.</h4>
                    </center>
                    <center>
                        <h3 class="text-danger">Are you sure you want to delete this data?</h3>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"
                            aria-hidden="true"></i> NO</button>
                    <button type="button" class="btn btn-success" id="btn_yes"><span
                            class="glyphicon glyphicon-saved">YES</span></button>
                </div>
            </div>
        </div>
    </div>


    <!-- new -->
    <div class="container">

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header</h4>
                    </div>
                    <div class="modal-body">
                        <p>Some text in the modal.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

    </div>



    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.btn-delete', function() {
                var stud_id8 = $(this).attr('id');
                console.log("Deleting ID:", stud_id8); // Check the ID
                $("#modal_confirm").modal('show');
                $('#btn_yes').attr('name', stud_id8);
            });

            $('#btn_yes').on('click', function() {
                var id = $(this).attr('name');
                $.ajax({
                    type: "POST",
                    url: "delete_documents.php",
                    data: {
                        stud_id8: id
                    },
                    success: function(response) {
                        console.log("Server response for ID " + id + ":", response); // Log the server's response
                        $("#modal_confirm").modal('hide');
                        $("#row_" + id).empty();
                        $("#row_" + id).html("<td colspan='6'><center class='text-danger'>Deleting...</center></td>");
                        setTimeout(function() {
                            $("#row_" + id).fadeOut('slow');
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error for ID " + id + ":", status, error); // Log any AJAX errors
                    }
                });
            });
        });
    </script>









    <!-- View Modal 2 -->
    <div class="modal fade" id="viewModal2" tabindex="-1" role="dialog" aria-labelledby="viewModal2Label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModal2Label">View File 2</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="docFrame2" src="" width="100%" height="500px"></iframe>
                </div>
            </div>
        </div>
    </div>



















    <!-- Scripts -->
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            const table = $('#your-table').DataTable({
                ajax: {
                    url: 'fetch_data_cside.php',
                    type: 'GET',
                    dataSrc: ''
                },
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                pageLength: 10,
                columns: [{
                        title: 'TRACKING NO.',
                        data: 'stud_no'
                    },
                    {
                        title: 'FROM/REQUESTER',
                        data: 'req'
                    },
                    {
                        title: 'DOCUMENT DATE',
                        data: 'dat'
                    },
                    {
                        title: 'SUBJECT',
                        data: 'subject'
                    },
                    {
                        title: 'CONTENT',
                        data: 'con'
                    },
                    {
                        title: 'TYPE',
                        data: 'type'
                    },
                    {
                        title: 'REMARKS',
                        data: 'remarks'
                    },
                    {
                        title: 'RELEASED TO',
                        data: 'rel'
                    },
                    {
                        title: 'ACTION',
                        data: 'file',
                        render: function(data, type, row, meta) {
                            return `
                        <button class="btn btn-sm btn-warning view-btn" data-file="${data}">
                            <i class="fas fa-eye"></i> View
                        </button> <br>
                        <button style="margin-top: 1px;" class="btn btn-sm btn-info view2-btn" data-file2="${row.file2}">
                        <i class="fas fa-eye"></i> View2
                        </button> <br>
                        <button style="margin-top: 1px;" class="btn btn-info btn-sm edit-btn" data-row="${meta.row}">
                            <i class="fas fa-edit"></i> Edit
                        </button> <br>
                        <button style="margin-top: 1px;" type="button" class="btn btn-success btn-sm print-btn" data-id="${row.stud_id8}">
                            <i class="fas fa-print"></i> Print
                        </button> <br>
                        <button style="margin-top: 1px;" class="btn btn-danger btn-sm btn-delete" data-id="${row.stud_id8}">
                            <i class="fas fa-trash"></i> Del
                        </button>
                        `;
                        }

                    }
                ],

                initComplete: function() {
                    const deoColumn = this.api().column(0);
                    const uniqueDEOs = [];

                    deoColumn.data().each(function(value) {
                        if (!uniqueDEOs.includes(value)) {
                            uniqueDEOs.push(value);
                        }
                    });

                    const deoFilter = $('#deo-filter');
                    uniqueDEOs.sort().forEach(deo => {
                        deoFilter.append(`<option value="${deo}">${deo}</option>`);
                    });

                    deoFilter.on('change', function() {
                        const selectedDEO = $(this).val();
                        deoColumn.search(selectedDEO).draw();
                    });
                }
            });

            // Handle View button click
            $('#your-table').on('click', '.view-btn', function() {
                const file = $(this).data('file');
                $('#docFrame').attr('src', '/admin/uploads/' + encodeURIComponent(file));
                $('#viewModal').modal('show');
            });

            // Handle View2 button click
            $('#your-table').on('click', '.view2-btn', function() {
                const file2 = $(this).data('file2');
                $('#docFrame2').attr('src', '/admin/uploads2/' + encodeURIComponent(file2));
                $('#viewModal2').modal('show');
            });


            // Handle Edit button click
            $('#your-table').on('click', '.edit-btn', function() {
                const rowIndex = $(this).data('row');
                const rowData = $('#your-table').DataTable().row(rowIndex).data();
                openModal(rowData);
            });



            // Handle Print button click
            $('#your-table').on('click', '.print-btn', function() {
                const rowIndex = $(this).closest('tr').index();
                const rowData = $('#your-table').DataTable().row(rowIndex).data();
                printCustom(rowData);
            });


            $(document).on('click', '.btn-delete', function() {
                var stud_id8 = $(this).data('id'); // ✅ use data-id instead of id
                console.log("Deleting ID:", stud_id8);
                $("#modal_confirm").modal('show');
                $('#btn_yes').attr('name', stud_id8);
            });

        });
    </script>
</body>

</html>