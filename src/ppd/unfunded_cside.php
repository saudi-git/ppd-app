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
            max-width: 1800px;
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
        <h3 style="text-align: left; color: #0a376e;">Unfunded</h3>
        <a href="" style="align-items: right;"></a>
        <!-- Filter -->

        <div style="text-align: left;">
            <label for="deo-filter">Filter by DEO:</label>
            <select id="deo-filter" class="form-control d-inline-block" style="width: auto;">
                <option value="">All</option>
            </select>
        </div>

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
                <form id="addUnfundedForm" enctype="multipart/form-data">


                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-plus"></i> New </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="user-message" class="alert text-center" style="display:none;"></div>


                        <div class="form-group">
                            <label>District Engineering Office:</label>
                            <select name="deo" class="form-control" required>
                                <option value="">District Engineering Office</option>
                                <option value="BAS">Basilan</option>
                                <option value="SUL1">Sulu District 1</option>
                                <option value="SUL2">Sulu District 2</option>
                                <option value="TAW">Tawi-Tawi</option>
                                <option value="MDN">Maguindanao Del Norte</option>
                                <option value="MDS">Maguindanao Del Sur</option>
                                <option value="LDS1">Lanao Del Sur District 1</option>
                                <option value="LDS2">Lanao Del Sur District 2</option>
                                <option value="SGA">Special Geographic Area</option>
                                <option value="COT">Cotabato City</option>
                                <option value="OSB">Outside Barmm</option>
                            </select>
                        </div>
                        <!-- <div class="form-group">
                            <label>Code</label>
                            <input style="text-align:center" name="stud_no" class="form-control" type="text">
                        </div> -->

                        <div class="form-group">
                            <label for="">Project Title or (Subjects):</label>
                            <textarea class="form-control" name="proj_name" rows="2" required="required"></textarea>
                            <!-- <input type="text" maxlength="100" name="stud_no" class="form-control" required="required" autocomplete="off" placeholder="Enter Code" oninput="this.value = this.value.replace(/\s/g, '')"> -->
                        </div>


                        <div class="form-group">
                            <label for="">Municipality:</label>
                            <input class="form-control" name="municipality">
                        </div>

                        <div class="form-group">
                            <label for="">Barangay:</label>
                            <input class="form-control" name="barangay">
                        </div>

                        <div class=" form-group">
                            <label for="">Sitio/Purok:</label>
                            <input class="form-control" name="sitio">
                        </div>

                        <div class="form-group">
                            <label for="">Project Length (Km/Unit):</label>
                            <input class="form-control" name="scale">
                        </div>

                        <div>
                            <label for="">Project Cost:</label>
                            <input class="form-control" name="cost">
                        </div>
                        <div>
                            <label for="">Proponent:</label>
                            <input class="form-control" name="proponent">
                        </div>
                        <div>
                            <label for="">Position:</label>
                            <input class="form-control" name="position">
                        </div>
                        <div>
                            <label for="">Date:</label>
                            <input type="date" class="form-control" name="dat">
                        </div>
                        <div>
                            <label for="">Forwarded to:</label>
                            <input class="form-control" name="forwarded">
                        </div>

                        <div class="form-group">
                            <label class="required">Remarks:</label>
                            <textarea class="form-control" name="remarks" rows="2"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Attach-URL</label>
                            <textarea class="form-control" name="attachment" rows="2"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <textarea class="form-control" name="stat" rows="2"></textarea>
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
            $('#addUnfundedForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: 'save_unfunded_cside.php',
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
                                $('#addUnfundedForm')[0].reset();
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









    <!-- ✅ Edit Modal -->
    <div class="modal fade" id="edit_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editUserForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-edit"></i> Update</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Alert placeholder -->
                        <!-- <div id="modalAlert"></div> -->
                        <input type="hidden" name="stud_id5" id="stud_id5">

                        <div class="form-group">
                            <label>District Engineering Office</label>
                            <select name="deo" id="deo" class="form-control" required>
                                <option value="BAS">Basilan</option>
                                <option value="SUL1">Sulu District 1</option>
                                <option value="SUL2">Sulu District 2</option>
                                <option value="TAW">Tawi-Tawi</option>
                                <option value="MDN">Maguindanao Del Norte</option>
                                <option value="MDS">Maguindanao Del Sur</option>
                                <option value="LDS1">Lanao Del Sur District 1</option>
                                <option value="LDS2">Lanao Del Sur District 2</option>
                                <option value="SGA">Special Geographic Area</option>
                                <option value="COT">Cotabato City</option>
                                <option value="OSB">Outside Barmm</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Project Title or (Subjects)</label>
                            <textarea class="form-control" name="proj_name" id="proj_name" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Municipality</label>
                            <input class="form-control" name="municipality" id="municipality">
                        </div>

                        <div class="form-group">
                            <label>Barangay</label>
                            <input class="form-control" id="barangay" name="barangay">
                        </div>

                        <div class="form-group">
                            <label>Sitio</label>
                            <input class="form-control" id="sitio" name="sitio">
                        </div>
                        <div class="form-group">
                            <label>Appropriation</label>
                            <input class="form-control" id="cost" name="cost">
                        </div>

                        <div class="form-group">
                            <label>Proponent</label>
                            <input class="form-control" name="proponent" id="proponent">
                        </div>

                        <div class="form-group">
                            <label>Position</label>
                            <input class="form-control" name="position" id="position">
                        </div>

                        <div class="form-group">
                            <label>Date</label>
                            <input class="form-control" name="dat" id="dat">
                        </div>

                        <div class="form-group">
                            <label>Remarks</label>
                            <textarea class="form-control" name="remarks" id="remarks" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Attachment</label>
                            <textarea class="form-control" name="attachment" id="attachment" rows="3" readonly></textarea>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <textarea class="form-control" name="stat" id="stat" rows="3"></textarea>
                        </div>

                        <!-- Progress Bar for Edit -->
                        <div id="uploadProgressContainerEdit" class="mt-3" style="display:none;">
                            <div class="progress">
                                <div id="uploadProgressBarEdit" class="progress-bar progress-bar-striped progress-bar-animated"
                                    role="progressbar" style="width:0%"></div>
                            </div>
                            <small id="uploadPercentTextEdit" class="text-muted d-block text-center mt-1"></small>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-success">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ✅ Script -->
    <script>
        function openModal(rowData) {
            document.getElementById('stud_id5').value = rowData.stud_id5 || '';
            document.getElementById('deo').value = rowData.deo || '';
            document.getElementById('stud_no').value = rowData.stud_no || '';
            document.getElementById('proj_name').value = rowData.proj_name || '';
            document.getElementById('municipality').value = rowData.municipality || '';
            document.getElementById('barangay').value = rowData.barangay || '';
            document.getElementById('sitio').value = rowData.sitio || '';
            document.getElementById('scale').value = rowData.scale || '';
            document.getElementById('cost').value = rowData.cost || '';
            document.getElementById('proponent').value = rowData.proponent || '';
            document.getElementById('position').value = rowData.position || '';
            document.getElementById('dat').value = rowData.dat || '';
            document.getElementById('remarks').value = rowData.remarks || '';
            document.getElementById('attachment').value = rowData.attachment || '';
            document.getElementById('forwarded').value = rowData.forwarded || '';
            document.getElementById('stat').value = rowData.stat || '';
            $('#edit_modal').modal('show');
        }

        $('#editUserForm').submit(function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();

            const progressContainer = document.getElementById('uploadProgressContainerEdit');
            const progressBar = document.getElementById('uploadProgressBarEdit');
            const submitBtn = form.querySelector('button[type="submit"]');

            submitBtn.disabled = true;
            progressContainer.style.display = 'block';
            progressBar.style.width = '0%';
            progressBar.classList.remove('bg-danger', 'bg-success', 'glow');

            // Upload progress
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable && e.total > 0) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = percent + '%';
                }
            });

            // Response from server
            xhr.addEventListener('load', function() {
                let res;
                try {
                    res = JSON.parse(xhr.responseText);
                } catch {
                    res = {
                        status: 'success'
                    };
                }

                if (res.status !== 'success') {
                    progressBar.classList.add('bg-danger');
                    submitBtn.disabled = false;
                    return;
                }

                if ($.fn.DataTable.isDataTable('#your-table')) {
                    $('#your-table').DataTable().ajax.reload(null, false);
                }

                // Reset after short delay
                setTimeout(() => {
                    $('#edit_modal').modal('hide');
                    form.reset();
                    progressContainer.style.display = 'none';
                    progressBar.style.width = '0%';
                    progressBar.classList.remove('bg-success', 'bg-danger', 'glow');
                    submitBtn.disabled = false;
                }, 1000);
            });

            // Error handling
            xhr.addEventListener('error', function() {
                progressBar.classList.add('bg-danger');
                submitBtn.disabled = false;
            });

            xhr.open('POST', 'update_status.php', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.send(formData);
        });
    </script>



    <!-- ✅ Styles -->
    <style>
        .progress {
            height: 25px;
            background-color: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            margin-top: 10px;
        }

        .progress-bar {
            background-color: #28a745;
            transition: width 0.8s ease-in-out, box-shadow 0.8s ease-in-out;
            font-weight: bold;
            font-size: 14px;
            color: white;
        }

        .progress-bar.glow {
            box-shadow: 0 0 8px #28a745, 0 0 16px #28a745, 0 0 24px #28a745;
            animation: glowPulse 2s infinite alternate;
        }

        @keyframes glowPulse {
            0% {
                box-shadow: 0 0 5px #28a745, 0 0 10px #28a745, 0 0 15px #28a745;
            }

            100% {
                box-shadow: 0 0 12px #28a745, 0 0 24px #28a745, 0 0 36px #28a745;
            }
        }

        #uploadPercentTextEdit {
            position: absolute;
            width: 100%;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            color: #000;
            top: 0;
            left: 0;
            height: 100%;
            line-height: 25px;
            pointer-events: none;
        }
    </style>











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
                const id = $(this).data('id');
                $('#modal_confirm').modal('show');
                $('#btn_yes').attr('data-id', id);
            });

            // When "Yes" is clicked in the modal
            $('#btn_yes').on('click', function() {
                const id = $(this).attr('data-id');
                $('#modal_confirm').modal('hide');

                $.ajax({
                    url: 'delete_unfunded_cside.php',
                    type: 'POST',
                    data: {
                        stud_id5: id
                    },
                    success: function(response) {
                        if (response.trim() === "success") {
                            $("#row_" + id).fadeOut(500, function() {
                                $(this).remove();
                            });

                            const alertBox = $(`
                        <div class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999; width: 300px;" role="alert">
                            <strong>Success!</strong> Record deleted successfully.
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    `);
                            $('body').prepend(alertBox);
                            setTimeout(() => {
                                alertBox.fadeOut(500, () => {
                                    alertBox.remove();
                                    location.reload();
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
                    url: 'fetch_unfunded_data.php',
                    type: 'GET',
                    dataSrc: ''
                },
                lengthMenu: [
                    [10, 25, 50, 100, ],
                    [10, 25, 50, 100, ]
                    //  [10, 25, 50, 100, -1],
                    // [10, 25, 50, 100, "All"]
                ],
                pageLength: 10,
                columns: [{
                        title: 'DEO',
                        data: 'deo'
                    },
                    {
                        title: 'Project Name or Title',
                        data: 'proj_name'
                    },
                    {
                        title: 'Municipality',
                        data: 'municipality'
                    },
                    {
                        title: 'Barangay',
                        data: 'barangay'
                    },
                    {
                        title: 'Sitio',
                        data: 'sitio'
                    },
                    {
                        title: 'Length',
                        data: 'scale'
                    },
                    {
                        title: 'Appropriation',
                        data: 'cost',
                        render: function(data, type, row) {
                            if (data == null || data === '') return ''; // handle empty values
                            // Convert to number and format with PHP peso sign
                            let num = parseFloat(data);
                            if (isNaN(num)) return data; // return raw if not numeric
                            return '₱ ' + num.toLocaleString('en-PH', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    },
                    {
                        title: 'Proponent',
                        data: 'proponent'
                    },
                    {
                        title: 'Position',
                        data: 'position'
                    },
                    {
                        title: 'Date',
                        data: 'dat'
                    },
                    {
                        title: 'Remarks',
                        data: 'remarks'
                    },
                    {
                        title: 'Forwarded to',
                        data: 'forwarded'
                    },
                    {
                        title: 'Status',
                        data: 'stat'
                    },
                    {
                        title: 'ACTION',
                        data: null,
                        className: 'text-center align-middle',
                        render: function(data, type, row) {
                            return `
                        <div class="text-center">
                            <a href="${row.attachment}" target="_blank">
                                <button class="btn btn-success btn-sm" style="margin-bottom:1px;">
                                    <i class="fas fa-link"></i> Link
                                </button>
                            </a>
                            
                            <button class="btn btn-info btn-sm edit-btn" style="margin-bottom:1px;"
                                data-stud_id5="${row.stud_id5}"
                                data-deo="${row.deo}"
                                data-stud_no="${row.stud_no}"
                                data-proj_name="${row.proj_name}"
                                data-municipality="${row.municipality}"
                                data-barangay="${row.barangay}"
                                data-sitio="${row.sitio}"
                                data-scale="${row.scale}"
                                data-cost="${row.cost}"
                                data-proponent="${row.proponent}"
                                data-position="${row.position}"
                                data-dat="${row.dat}"
                                data-remarks="${row.remarks}"
                                data-attachment="${row.attachment}"
                                data-forwarded="${row.forwarded}"
                                data-stat="${row.stat}">
                                <i class="fas fa-edit"></i> Edit
                            </button>

                            <button class="btn btn-danger btn-sm btn-delete" data-id="${row.stud_id5}">
                                <i class="fas fa-trash"></i> Del
                            </button>
                        </div>
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



            // Handle Edit button click
            $(document).on('click', '.edit-btn', function() {
                const rowData = {
                    stud_id5: $(this).data('stud_id5'),
                    deo: $(this).data('deo'),
                    stud_no: $(this).data('stud_no'),
                    proj_name: $(this).data('proj_name'),
                    municipality: $(this).data('municipality'),
                    barangay: $(this).data('barangay'),
                    sitio: $(this).data('sitio'),
                    scale: $(this).data('scale'),
                    cost: $(this).data('cost'),
                    proponent: $(this).data('proponent'),
                    position: $(this).data('position'),
                    dat: $(this).data('dat'),
                    remarks: $(this).data('remarks'),
                    attachment: $(this).data('attachment'),
                    forwarded: $(this).data('forwarded'),
                    stat: $(this).data('stat')
                };

                // Fill modal
                for (const key in rowData) {
                    $('#' + key).val(rowData[key] || '');
                }

                $('#modalAlert').html(''); // Clear previous alerts
                $('#edit_modal').modal('show'); // Open modal
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