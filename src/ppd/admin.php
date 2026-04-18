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



    <?php include 'navbaradmin.php' ?>
    <br>


    <div class="container">
        <!-- <?php echo "<a href='logout_docs_user.php' style='float:right; margin-right:10px;'>Logout</a>"; ?> -->
        <!-- <h3>USERS</h3> -->
        <h3 style="text-align: left; color: #0a376e;">User Access Control</h3>
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
                <!-- <form method="POST" action="save_user.php" enctype="multipart/form-data"> -->
                <form id="addUserForm" enctype="multipart/form-data">


                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-plus"></i> New User</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="user-message" class="alert text-center" style="display:none;"></div>
                        <div class="form-group">
                            <label>USERNAME</label>
                            <input class="form-control" name="username" required>
                        </div>

                        <div class="form-group">
                            <label>FULLNAME</label>
                            <input class="form-control" name="name" required>
                        </div>

                        <div class="form-group">
                            <label>PASSWORD</label>
                            <input class="form-control" name="password" required>
                        </div>

                        <div class="form-group">
                            <label>ROLE</label>
                            <select name="role" class="form-control" required>
                                <option value="" disabled selected>-- Please select ROLE --</option>
                                <option value="admin">ADMIN</option>
                                <option value="encoder">INCOMING</option>
                                <option value="planning">PLANNING</option>
                                <option value="programming">PROGRAMMING</option>
                                <option value="environmental">ENVIRONMENTAL</option>
                                <option value="ebarmm">E-BARMM</option>
                                <option value="outgoing">OUTGOING</option>
                                <option value="viewer">VIEWER</option>
                                <option value="unfunded">UNFUNDED</option>
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



    <script>
        $(document).ready(function() {
            $('#addUserForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: 'save_user.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        const msgBox = $('#user-message');
                        msgBox
                            .removeClass('alert-success alert-danger')
                            .addClass(response.status === 'success' ? 'alert-success' : 'alert-danger')
                            .text(response.message)
                            .fadeIn();

                        // ✅ If success, refresh table and close modal after 1.5s
                        if (response.status === 'success') {
                            setTimeout(() => {
                                msgBox.fadeOut();
                                $('#form_modal').modal('hide');
                                $('#addUserForm')[0].reset();
                                $('#your-table').DataTable().ajax.reload();
                            }, 1500);
                        }
                    },
                    error: function() {
                        const msgBox = $('#user-message');
                        msgBox
                            .removeClass('alert-success')
                            .addClass('alert-danger')
                            .text('An unexpected error occurred.')
                            .fadeIn();
                    }
                });
            });
        });
    </script>









    <!-- View Document Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Document Preview</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body" style="height:80vh;">
                    <!-- Iframe for document -->
                    <iframe id="docFrame" style="width:100%; height:100%; display:none;" frameborder="0"></iframe>

                    <!-- Message when no file -->
                    <div id="docMessage" class="text-center p-3" style="display:none; font-style:italic; color:gray;">
                        📂 No file uploaded yet.
                    </div>
                </div>

            </div>
        </div>
    </div>









    <div class="modal fade" id="edit_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editUserForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-edit"></i> Edit User</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <!-- Alert placeholder -->
                        <div id="modalAlert"></div>

                        <!-- Hidden ID field -->
                        <input type="hidden" name="id" id="id">

                        <div class="form-group">
                            <label for="">USERNAME</label>
                            <input class="form-control" name="username" id="username" required>
                        </div>

                        <div class="form-group">
                            <label for="">FULLNAME</label>
                            <input class="form-control" name="name" id="name" required>
                        </div>

                        <div class="form-group">
                            <label for="">PASSWORD</label>
                            <input class="form-control" name="password" id="password" placeholder="Leave blank to keep current password">
                        </div>

                        <div class="form-group">
                            <label>ROLE</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="" disabled selected>-- Please select ROLE --</option>
                                <option value="admin">ADMIN</option>
                                <option value="incoming">INCOMING</option>
                                <option value="planning">PLANNING</option>
                                <option value="programming">PROGRAMMING</option>
                                <option value="environmental">ENVIRONMENTAL</option>
                                <option value="ebarmm">E-BARMM</option>
                                <option value="outgoing">OUTGOING</option>
                                <option value="viewer">VIEWER</option>
                                <option value="unfunded">UNFUNDED</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remove"></span> Close
                        </button>
                        <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-saved"></span> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(rowData) {
            document.getElementById('id').value = rowData.id || '';
            document.getElementById('username').value = rowData.username || '';
            document.getElementById('name').value = rowData.name || '';
            document.getElementById('password').value = '';
            document.getElementById('role').value = rowData.role || '';
            document.getElementById('modalAlert').innerHTML = ''; // Clear previous messages
            $('#edit_modal').modal('show');
        }

        // AJAX submit
        $('#editUserForm').submit(function(e) {
            e.preventDefault(); // Prevent normal form submission

            $.ajax({
                url: 'update_user.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    let res = JSON.parse(response);

                    let alertClass = res.status === 'success' ? 'alert-success' : 'alert-danger';
                    $('#modalAlert').html(`<div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                                        ${res.message}
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    </div>`);

                    if (res.status === 'success') {
                        setTimeout(() => {
                            $('#edit_modal').modal('hide'); // Close modal after 1.5s
                            location.reload(); // Optional: refresh table
                        }, 1500);
                    }
                },
                error: function() {
                    $('#modalAlert').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Something went wrong. Please try again.
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    </div>`);
                }
            });
        });
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
            // When delete button is clicked
            $(document).on('click', '.btn-delete', function() {
                const id = $(this).data('id'); // Use data-id instead of id
                $('#modal_confirm').modal('show');
                $('#btn_yes').attr('data-id', id);
            });

            // When "Yes" is clicked in the modal
            $('#btn_yes').on('click', function() {
                const id = $(this).data('id');
                $('#modal_confirm').modal('hide');

                $.ajax({
                    url: 'delete_user.php',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "success") {
                            // Fade out the row
                            $("#row_" + id).fadeOut(500, function() {
                                $(this).remove();
                            });

                            // ✅ Show success alert
                            const alertBox = $(`
                        <div class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999; width: 300px;" role="alert">
                            <strong>Success!</strong> User deleted successfully.
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    `);
                            $('body').prepend(alertBox);

                            // Auto fade alert after 1.5s then refresh
                            setTimeout(() => {
                                alertBox.fadeOut(500, () => {
                                    alertBox.remove();
                                    location.reload(); // ✅ Refresh page after fade
                                });
                            }, 1500);
                        } else {
                            alert("Error deleting record. Please try again.");
                        }
                    },
                    error: function() {
                        alert("Something went wrong. Please check your connection.");
                    }
                });
            });
        });
    </script>








    <!-- View Modal 3 -->
    <div class="modal fade" id="viewModal3" tabindex="-1" role="dialog" aria-labelledby="viewModal3Label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="viewModal3Label">Document Preview 3</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="height:80vh;">
                    <!-- Iframe for document -->
                    <iframe id="docFrame3" style="width:100%; height:100%; display:none;" frameborder="0"></iframe>

                    <!-- Message when no file -->
                    <div id="docMessage3" class="text-center p-3" style="display:none; font-style:italic; color:gray;">
                        📂 No file uploaded yet.
                    </div>
                </div>

            </div>
        </div>
    </div>




    <!-- View Modal 2 -->
    <div class="modal fade" id="viewModal2" tabindex="-1" role="dialog" aria-labelledby="viewModal2Label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="viewModal2Label">Document Preview 2</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="height:80vh;">
                    <!-- Iframe for document -->
                    <iframe id="docFrame2" style="width:100%; height:100%; display:none;" frameborder="0"></iframe>

                    <!-- Message when no file -->
                    <div id="docMessage2" class="text-center p-3" style="display:none; font-style:italic; color:gray;">
                        📂 No file uploaded yet.
                    </div>
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
                    url: 'fetch_user_data.php',
                    type: 'GET',
                    dataSrc: ''
                },
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                pageLength: 10,
                columns: [{
                        title: 'ID',
                        data: 'id'
                    },
                    {
                        title: 'USERNAME',
                        data: 'username'
                    },
                    {
                        title: 'FULLNAME',
                        data: 'name'
                    },
                    // {
                    //     title: 'PASSWORD',
                    //     data: 'password'
                    // }, 
                    {
                        title: 'ROLE',
                        data: 'role'
                    },
                    {
                        title: 'DATE CREATED',
                        data: 'created_at'
                    },
                    {
                        title: 'ACTION',
                        data: null,
                        className: 'text-center align-middle', // ✅ centers both horizontally & vertically
                        render: function(data, type, row) {
                            return `
                <div class="text-center">
                  <button class="btn btn-info btn-sm edit-btn"
            data-id="${row.id}"
            data-username="${row.username}"
            data-name="${row.name}"
            data-role="${row.role}">
            <i class="fas fa-edit"></i> Edit
        </button>
                <button class="btn btn-danger btn-sm btn-delete" data-id="${row.id}">
                    <i class="fas fa-trash"></i> Del
                </button>
            </div>
            `;
                        }
                    }
                ]





                // initComplete: function() {
                //     // ✅ Automatically filter REL = PLANNING DIVISION
                //     this.api().column(7).search('PROGRAMMING DIVISION').draw();

                //     // (Optional) still build dropdown for REL  
                //     const relColumn = this.api().column(7);
                //     const uniqueRels = [];

                //     relColumn.data().each(function(value) {
                //         if (!uniqueRels.includes(value)) {
                //             uniqueRels.push(value);
                //         }
                //     });

                //     const relFilter = $('#rel-filter');
                //     uniqueRels.sort().forEach(rel => {
                //         relFilter.append(`<option value="${rel}">${rel}</option>`);
                //     });

                //     relFilter.on('change', function() {
                //         const selectedRel = $(this).val();
                //         relColumn.search(selectedRel).draw();
                //     });
                // }




            });

            //  Handle View button click
            $('#your-table').on('click', '.view-btn', function() {
                const file = $(this).data('file');

                if (file && file.trim() !== '') {
                    $('#docFrame').attr('src', '/admin/uploads/' + encodeURIComponent(file)).show();
                    $('#docMessage').hide();
                } else {
                    $('#docFrame').hide().attr('src', ''); // clear iframe
                    $('#docMessage').show();
                }

                $('#viewModal').modal('show');
            });





            // Handle View2 button click
            $('#your-table').on('click', '.view2-btn', function() {
                const file2 = $(this).data('file2');

                if (file2 && file2.trim() !== '') {
                    // If file exists, show it in iframe
                    $('#docFrame2').attr('src', '/admin/uploads/' + encodeURIComponent(file2)).show();
                    $('#docMessage2').hide();
                } else {
                    // If no file, hide iframe and show message
                    $('#docFrame2').hide().attr('src', '');
                    $('#docMessage2').show();
                }

                $('#viewModal2').modal('show');
            });




            // Optional: reset when modal closes
            $('#viewModal3').on('hidden.bs.modal', function() {
                $('#docFrame3').attr('src', '').hide();
                $('#docMessage3').hide();
            });

            // Handle View2 button click
            $('#your-table').on('click', '.view3-btn', function() {
                const file3 = $(this).data('file3');

                if (file3 && file3.trim() !== '') {
                    // If file exists, show it in iframe
                    $('#docFrame3').attr('src', '/admin/uploads/' + encodeURIComponent(file3)).show();
                    $('#docMessage3').hide();
                } else {
                    // If no file, hide iframe and show message
                    $('#docFrame3').hide().attr('src', '');
                    $('#docMessage3').show();
                }

                $('#viewModal3').modal('show');
            });

            // Optional: reset when modal closes
            $('#viewModal3').on('hidden.bs.modal', function() {
                $('#docFrame3').attr('src', '').hide();
                $('#docMessage3').hide();
            });









            // Handle Edit button click
            // $('#your-table').on('click', '.edit-btn', function() {
            //     const rowIndex = $(this).data('row');
            //     const rowData = $('#your-table').DataTable().row(rowIndex).data();
            //     openModal(rowData);
            // });



            // When Edit button is clicked
            $(document).on('click', '.edit-btn', function() {
                const id = $(this).data('id');
                const username = $(this).data('username');
                const name = $(this).data('name');
                const role = $(this).data('role');

                // Set modal field values
                $('#id').val(id);
                $('#username').val(username);
                $('#name').val(name);
                $('#password').val(''); // leave blank for security
                $('#role').val(role);

                $('#modalAlert').html(''); // clear old alerts
                $('#edit_modal').modal('show');
            });




            // Handle Print button click
            $('#your-table').on('click', '.print-btn', function() {
                const rowIndex = $(this).closest('tr').index();
                const rowData = $('#your-table').DataTable().row(rowIndex).data();
                printCustom(rowData);
            });


            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data('id'); // ✅ use data-id instead of id
                console.log("Deleting ID:", id);
                $("#modal_confirm").modal('show');
                $('#btn_yes').attr('name', id);
            });






        });
    </script>
</body>

</html>