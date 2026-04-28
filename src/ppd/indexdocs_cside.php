<?php
ini_set('session.gc_maxlifetime', 3600); // 1 hour
ini_set('session.cookie_lifetime', 0);   // expires when browser closes
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>PPD-PIMS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/mpw-icon.png">

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




    <?php include 'navbardocs.php' ?>
    <br>


    <div class="container">
        <!-- <?php echo "<a href='logout_docs_user.php' style='float:right; margin-right:10px;'>Logout</a>"; ?> -->
        <h3 style="text-align: left; color: #0a376e;">Incoming Document List</h3>
        <a href="" style="align-items: right;"></a>
        <!-- Filter -->
        <!-- <label for="deo-filter">Filter by DEO:</label>
        <select id="deo-filter">
            <option value="">All</option>
        </select> -->


        <!-- REL Filter Dropdown -->
        <div class="mb-3" style="text-align: left;">
            <label for="rel-filter" class="form-label fw-bold">Filter by SECTION:</label>
            <select id="rel-filter" class="form-select" style="max-width:300px;">
                <option value="">All</option>
                <option value="PLANNING SECTION">PLANNING SECTION</option>
                <option value="PROGRAMMING SECTION">PROGRAMMING SECTION</option>
                <option value="ENVIRONMENTAL SECTION">ENVIRONMENTAL SECTION</option>
                <option value="E-BARMM UNIT">E-BARMM UNIT</option>
            </select>
        </div>


        <!-- Add button -->

        <div class="d-flex justify-content-end mb-2">
            <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#form_modal">
                <i class="fas fa-plus"></i> Add
            </button>
        </div>

        <div id="user-message" class="alert" style="display:none;"></div>

        <!-- DataTable -->
        <table id="your-table" class="display" style="width:100%"></table>
    </div>

    <!-- Add Document Modal -->
    <div class="modal fade" id="form_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- <form id="add_document_form" method="POST" action="save_documents_cside.php" enctype="multipart/form-data"> -->
                <form id="addDocsForm" enctype="multipart/form-data">

                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-plus"></i> New Document</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label>RECEIVED BY</label>
                            <!-- <input class="form-control" name="stud_no" required> -->
                            <input type="text" name="inputBy"
                                value="<?php echo htmlspecialchars($_SESSION['name'] ?? ''); ?>"
                                class="form-control" required>
                        </div>

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
                        <!-- 
                        <input type="text" name="inputBy"
                            value="<?php echo htmlspecialchars($_SESSION['name'] ?? ''); ?>"
                            class="form-control" hidden>
                        <br> -->

                        <div class="form-group">
                            <label>TITLE/SUBJECT</label>
                            <textarea class="form-control" name="subject" rows="2" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>CONTENT</label>
                            <textarea class="form-control" name="con" rows="2" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>TYPE</label>
                            <select required name="type" class="form-control">
                                <option value="" disabled selected>-- Please select TYPE --</option>
                                <option value="Communication(External)">Communication (External)</option>
                                <option value="Communication(Internal)">Communication (Internal)</option>
                                <option value="Communication(External) DEO">Communication (External) DEO</option>
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

                        <!-- Upload Progress UI -->
                        <div id="uploadProgressContainerAdd" style="display:none;">
                            <div class="progress mt-3 oneui-progress">
                                <div id="uploadProgressBarAdd" class="progress-bar" style="width:0%"></div>
                            </div>

                            <div class="text-center mt-2" id="uploadPercentTextAdd">0%</div>
                            <div class="text-center small text-muted" id="uploadStatsAdd">0 MB / 0 MB • ETA: --</div>
                        </div>

                        <div id="uploadLoaderAdd"></div>

                        <!-- Cancel Upload Button -->
                        <div class="text-center mt-2" style="display:none;" id="cancelUploadAddContainer">
                            <button type="button" class="btn btn-warning btn-sm" id="cancelUploadAddBtn">
                                ✖ Cancel Upload
                            </button>
                        </div>


                        <div class="form-group">
                            <label>RELEASE TO</label>
                            <select name="rel" class="form-control">
                                <option value=" "> </option>
                                <option value="PLANNING SECTION">PLANNING SECTION</option>
                                <option value="PROGRAMMING SECTION">PROGRAMMING SECTION</option>
                                <option value="ENVIRONMENTAL SECTION">ENVIRONMENTAL SECTION</option>
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




    <script>
        $(document).ready(function() {

            let addXhr = null;
            let uploadCanceledAdd = false;

            $('#addDocsForm').on('submit', function(e) {
                e.preventDefault();

                uploadCanceledAdd = false;

                let formData = new FormData(this);

                $.ajax({
                    url: 'save_documents_cside.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',

                    xhr: function() {
                        addXhr = new window.XMLHttpRequest();

                        let lastTime = Date.now();
                        let lastLoaded = 0;
                        let speedSamples = [];

                        addXhr.upload.addEventListener("loadstart", function() {
                            $("#uploadLoaderAdd").fadeIn(150);
                            $("#uploadProgressContainerAdd").fadeIn(200);
                            $("#cancelUploadAddContainer").fadeIn(200);
                        });

                        addXhr.upload.addEventListener("progress", function(e) {
                            if (!e.lengthComputable) return;

                            let percent = Math.round((e.loaded / e.total) * 100);
                            let loadedMB = (e.loaded / (1024 * 1024)).toFixed(2);
                            let totalMB = (e.total / (1024 * 1024)).toFixed(2);

                            $("#uploadProgressBarAdd").css("width", percent + "%");

                            let now = Date.now();
                            let timeDiffSec = (now - lastTime) / 1000;
                            let bytesDiff = e.loaded - lastLoaded;

                            lastTime = now;
                            lastLoaded = e.loaded;

                            let mbps = (bytesDiff * 8) / (1024 * 1024) / timeDiffSec;
                            speedSamples.push(mbps);
                            if (speedSamples.length > 5) speedSamples.shift();

                            let avgMbps = (
                                speedSamples.reduce((a, b) => a + b, 0) / speedSamples.length
                            ).toFixed(2);

                            let remainingBytes = e.total - e.loaded;
                            let remainingSeconds = avgMbps > 0 ?
                                (remainingBytes * 8) / (avgMbps * 1024 * 1024) :
                                0;

                            let etaText = remainingSeconds > 0 ? Math.ceil(remainingSeconds) + "s" : "--";

                            $("#uploadPercentTextAdd").text(`${percent}% – ${avgMbps} Mbps`);
                            $("#uploadStatsAdd").text(`${loadedMB} MB / ${totalMB} MB • ETA: ${etaText}`);

                            if (percent >= 100) {
                                $("#uploadPercentTextAdd").text("Processing…");
                                $("#uploadStatsAdd").text(`${totalMB} MB / ${totalMB} MB • ETA: 0s`);
                                $("#uploadLoaderAdd").hide();
                            }
                        });

                        // ABORT HANDLER
                        addXhr.addEventListener("abort", function() {
                            if (!uploadCanceledAdd) return;

                            $("#uploadLoaderAdd").hide();
                            $("#uploadPercentTextAdd").text("Upload Cancelled");
                            $("#uploadStatsAdd").text("0 MB / 0 MB • ETA: --");
                            $("#uploadProgressBarAdd").css("width", "0%");
                        });

                        return addXhr;
                    },

                    success: function(response) {
                        if (uploadCanceledAdd) return;

                        const msgBox = $('#user-message');

                        msgBox.removeClass('alert-success alert-danger')
                            .addClass(response.status === 'success' ? 'alert-success' : 'alert-danger')
                            .text(response.message)
                            .fadeIn();

                        $("#cancelUploadAddContainer").fadeOut(200);

                        if (response.status === 'success') {

                            setTimeout(() => {
                                $("#uploadProgressContainerAdd").fadeOut(300, function() {
                                    $("#uploadProgressBarAdd").css("width", "0%");
                                    $("#uploadPercentTextAdd").text("0%");
                                    $("#uploadStatsAdd").text("0 MB / 0 MB • ETA: --");
                                });
                            }, 900);

                            setTimeout(() => {
                                msgBox.fadeOut();
                                $('#form_modal').modal('hide');
                                $('#addDocsForm')[0].reset();
                                $('#your-table').DataTable().ajax.reload();
                            }, 1500);
                        }
                    },

                    error: function() {
                        if (uploadCanceledAdd) return;

                        $("#uploadLoaderAdd").hide();
                        $("#cancelUploadAddContainer").fadeOut(200);

                        $('#user-message')
                            .removeClass('alert-success')
                            .addClass('alert-danger')
                            .text('An unexpected error occurred.')
                            .fadeIn();
                    }
                });
            });

            // CANCEL BUTTON CLICK
            $('#cancelUploadAddBtn').on('click', function() {
                uploadCanceledAdd = true;

                if (addXhr) {
                    addXhr.abort();
                }

                $("#uploadProgressContainerAdd").fadeOut(300);
                $("#cancelUploadAddContainer").fadeOut(300);
            });

        });
    </script>





    <style>
        /* One UI style gradient progress bar */
        .oneui-progress {
            height: 22px;
            border-radius: 50px;
            overflow: hidden;
            background: #ebebeb;
        }

        .oneui-progress .progress-bar {
            background: linear-gradient(90deg, #4c8df6, #2563eb, #1e40af);
            background-size: 300% 100%;
            animation: gradientMove 3s ease infinite;
            transition: width 0.25s ease;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 0%;
            }

            50% {
                background-position: 100% 0%;
            }

            100% {
                background-position: 0% 0%;
            }
        }

        /* Spinning Loader */
        #uploadLoaderAdd {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #007bff;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            margin: 10px auto;
            animation: spin 1.2s linear infinite;
            display: none;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>













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
                <form method="POST" action="update_documents_cside.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title"><span class="glyphicon glyphicon-edit"></span> Update</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="stud_id8" id="stud_id8">


                        <!-- <label for="">Incoming/Received</label> -->

                        <div class="form-group">
                            <label for="">RECEIVED BY</label>
                            <input class="form-control" name="inputBy" id="inputBy" rows="1">
                        </div>

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
                        <!-- <div class="form-group">
                            <label for="">INPUTBY</label>
                            <textarea class="form-control" name="inputBy" id="inputBy" rows="3"></textarea>
                        </div> -->

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

                        <!-- Progress Bar -->
                        <div class="position-relative mt-2" style="display: none;" id="uploadProgressContainer">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%;" id="uploadProgressBar"></div>
                            </div>
                            <div id="uploadPercentText">0%</div>
                        </div>

                        <!-- Cancel Upload Button -->
                        <div class="mt-2 text-center" style="display:none;" id="cancelUploadContainer">
                            <button type="button" class="btn btn-warning btn-sm" id="cancelUploadBtn">
                                ✖ Cancel Upload
                            </button>
                        </div>


                        <div class="form-group">
                            <label>RELEASE TO</label>
                            <select name="rel" id="rel" class="form-control">
                                <option value="PLANNING SECTION">PLANNING SECTION</option>
                                <option value="PROGRAMMING SECTION">PROGRAMMING SECTION</option>
                                <option value="ENVIRONMENTAL SECTION">ENVIRONMENTAL SECTION</option>
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


    <style>
        /* One UI style gradient progress bar */
        .progress {
            height: 28px;
            background-color: #d9d9d9;
            border-radius: 14px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar {
            background: linear-gradient(90deg,
                    #6dd5ed,
                    #2193b0,
                    #6dd5ed);
            background-size: 300% 300%;
            animation: gradientMove 3s ease infinite;
            transition: width 0.25s ease;
            font-weight: bold;
            font-size: 14px;
            color: #fff;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Glow on success */
        .progress-bar.glow {
            box-shadow: 0 0 12px #00e676, 0 0 24px #00e676;
        }

        /* Centered text (percentage, speed, ETA) */
        #uploadPercentText {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            font-size: 14px;
            font-weight: bold;
            color: #fff;
            text-align: center;
            line-height: 28px;
            pointer-events: none;
        }

        /* Upload info (speed, ETA, MB uploaded) */
        #uploadInfo {
            font-size: 13px;
            margin-top: 5px;
            text-align: center;
            color: #555;
            font-weight: 500;
        }
    </style>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editForm = document.querySelector('#edit_modal form');
            if (!editForm) return;

            let xhr = null;
            let uploadCanceled = false;

            editForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData(form);
                xhr = new XMLHttpRequest();

                const progressContainer = document.getElementById('uploadProgressContainer');
                const progressBar = document.getElementById('uploadProgressBar');
                const percentText = document.getElementById('uploadPercentText');
                const cancelContainer = document.getElementById('cancelUploadContainer');
                const cancelBtn = document.getElementById('cancelUploadBtn');
                const editedId = document.getElementById('stud_id8').value;

                // Info box
                let infoBox = document.getElementById("uploadInfo");
                if (!infoBox) {
                    infoBox = document.createElement("div");
                    infoBox.id = "uploadInfo";
                    progressContainer.appendChild(infoBox);
                }

                progressContainer.style.display = 'block';
                cancelContainer.style.display = 'block';
                progressBar.style.width = '0%';
                percentText.textContent = '0%';
                infoBox.innerHTML = '';
                progressBar.classList.remove('bg-danger', 'bg-success', 'glow');

                uploadCanceled = false;

                let startTime = Date.now();
                let lastLoaded = 0;

                // CANCEL BUTTON
                cancelBtn.onclick = function() {
                    uploadCanceled = true;
                    if (xhr) xhr.abort();

                    progressBar.classList.add('bg-danger');
                    percentText.textContent = 'Upload Cancelled';
                    infoBox.innerHTML = '<b>❌ Upload cancelled by user</b>';

                    setTimeout(() => {
                        progressContainer.style.display = 'none';
                        cancelContainer.style.display = 'none';
                        progressBar.style.width = '0%';
                        percentText.textContent = '0%';
                        progressBar.classList.remove('bg-danger', 'glow');
                        infoBox.innerHTML = '';
                    }, 1200);
                };

                // PROGRESS
                xhr.upload.addEventListener('progress', function(e) {
                    if (!e.lengthComputable) return;

                    const percent = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = percent + '%';
                    percentText.textContent = percent + '%';

                    const uploadedMB = (e.loaded / (1024 * 1024)).toFixed(2);
                    const totalMB = (e.total / (1024 * 1024)).toFixed(2);

                    const speedMbps = ((e.loaded - lastLoaded) * 8 / 1_000_000).toFixed(2);
                    lastLoaded = e.loaded;

                    const remaining = e.total - e.loaded;
                    const eta = speedMbps > 0 ?
                        Math.round((remaining * 8 / 1_000_000) / speedMbps) :
                        1;

                    infoBox.innerHTML = `
                <span>📤 ${uploadedMB} MB / ${totalMB} MB</span><br>
                <span>⚡ Speed: ${speedMbps} Mbps</span><br>
                <span>⏳ ETA: ${eta}s</span>
            `;
                });

                // SUCCESS
                xhr.addEventListener('load', function() {
                    if (uploadCanceled) return;

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
                        percentText.textContent = 'Upload Failed';
                        cancelContainer.style.display = 'none';
                        return;
                    }

                    progressBar.classList.add('bg-success', 'glow');
                    progressBar.style.width = '100%';
                    percentText.textContent = 'Upload Complete ✓';
                    infoBox.innerHTML += '<br><b>✔ Successfully Updated</b>';
                    cancelContainer.style.display = 'none';

                    // Update DataTable
                    if ($.fn.DataTable.isDataTable('#your-table')) {
                        const table = $('#your-table').DataTable();

                        $.ajax({
                            url: 'get_single_document.php',
                            method: 'GET',
                            data: {
                                id: editedId
                            },
                            dataType: 'json',
                            success: function(newData) {
                                if (newData && newData.stud_id8) {
                                    const row = table.row('#' + newData.stud_id8);
                                    row.node() ? row.data(newData).draw(false) :
                                        table.ajax.reload(null, false);
                                } else {
                                    table.ajax.reload(null, false);
                                }
                            },
                            complete: function() {
                                setTimeout(() => {
                                    $('#edit_modal').modal('hide');
                                    form.reset();
                                    progressContainer.style.display = 'none';
                                    progressBar.style.width = '0%';
                                    percentText.textContent = '0%';
                                    progressBar.classList.remove('bg-success', 'bg-danger', 'glow');
                                    infoBox.innerHTML = '';
                                }, 900);
                            }
                        });
                    } else {
                        location.reload();
                    }
                });

                // ERROR
                xhr.addEventListener('error', function() {
                    progressBar.classList.add('bg-danger');
                    percentText.textContent = 'Upload Failed';
                    cancelContainer.style.display = 'none';
                });

                xhr.open('POST', form.action, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.send(formData);
            });
        });
    </script>











    <script>
        function openModal(rowData) {
            document.getElementById('inputBy').value = rowData.inputBy;
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
                    // `Current File: <a href="/admin/uploads/${encodeURIComponent(rowData.file)}" target="_blank">${rowData.file}</a>`;
                    `Current File: ${rowData.file}`;
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
            let inputBy = rowData.inputBy || "";
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
        <p style="margin-left: 324;margin-top:100;"> ${stud_no}</p>
        <p style="margin-top: 25;margin-left:10;">${req}</p>
        <p style="margin-top: 25;margin-left:10;"> ${formattedDate}</p>
        <p style="position:absolute; margin-top: -13; margin-left:60; font-size:small;"> ${result}</p>
        <p style="position:absolute; top:173px; left:272px;">${inputBy}</p>
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
                background-image: url('print/bg-image.jpg');
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
                rowId: 'stud_id8',
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
                        data: 'dat',
                        render: function(data, type) {
                            if (!data) return '';

                            let d = new Date(data);

                            // SORTING & TYPE
                            if (type === 'sort' || type === 'type') {
                                return d.getTime();
                            }

                            // DISPLAY: Month DD, YYYY
                            return d.toLocaleDateString('en-US', {
                                month: 'long',
                                day: '2-digit',
                                year: 'numeric'
                            });
                        }
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
                    // {
                    //     title: 'RECEIVED BY',
                    //     data: 'inputBy'
                    // },
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
                            return `<button class="btn btn-sm btn-info view-btn" data-file="${data}">
                                        <i class="fas fa-eye"></i> View
                                    </button> <br>
                    
                            ${row.file2 && row.file2.startsWith("https://drive.google.com/")
                            ? `<a href="${row.file2}" target="_blank">
                            <button class="btn btn-success btn-sm" style="margin-top:1px;">
                            <i class="fas fa-link"></i> Link
                            </button>
                            </a>`
                            : `<button class="btn btn-secondary btn-sm" style="margin-top:1px;" disabled>
                            <i class="fas fa-link"></i> Link
                            </button>`
                            }
                                <br>
                                    <button style="margin-top: 1px;" class="btn btn-warning btn-sm edit-btn" data-row="${meta.row}">
                                    <i class="fas fa-edit"></i> Edit
                                    </button> <br>
                                    <button style="margin-top: 1px;" type="button" class="btn btn-dark btn-sm print-btn" data-id="${row.stud_id8}">
                                    <i class="fas fa-print"></i> Print
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
            // $('#your-table').on('click', '.view-btn', function () {
            //     const file = $(this).data('file');
            //     $('#docFrame').attr('src', '/admin/uploads/' + encodeURIComponent(file));
            //     $('#viewModal').modal('show');
            // });


            // ✅ REL dropdown filter
            $('#rel-filter').on('change', function() {
                table.column(7).search(this.value).draw(); // column 7 = REL
            });


            //  Handle View button click
            $('#your-table').on('click', '.view-btn', function() {
                const file = $(this).data('file');

                if (file && file.trim() !== '') {
                    $('#docFrame').attr('src', 'uploads/' + encodeURIComponent(file)).show();
                    $('#docMessage').hide();
                } else {
                    $('#docFrame').hide().attr('src', ''); // clear iframe
                    $('#docMessage').show();
                }

                $('#viewModal').modal('show');
            });





            // Handle Edit button click
            $('#your-table').on('click', '.edit-btn', function() {
                const rowIndex = $(this).data('row');
                const rowData = $('#your-table').DataTable().row(rowIndex).data();
                openModal(rowData);
            });



            // Handle Print button click
            // $('#your-table').on('click', '.print-btn', function() {
            //     const rowIndex = $(this).closest('tr').index();
            //     const rowData = $('#your-table').DataTable().row(rowIndex).data();
            //     printCustom(rowData);
            // });

            // Handle Print button click
            $('#your-table').on('click', '.print-btn', function() {
                // Use DataTables API to get row data correctly
                const rowData = $('#your-table').DataTable().row($(this).closest('tr')).data();
                printCustom(rowData);
            });


            // If you’re using responsive tables or child rows, add a safeguard:
            // $('#your-table').on('click', '.print-btn', function() {
            //     const table = $('#your-table').DataTable();
            //     const tr = $(this).closest('tr');
            //     const row = table.row(tr.hasClass('child') ? tr.prev() : tr);
            //     const rowData = row.data();
            //     printCustom(rowData);
            // });
            // This handles cases where DataTables creates hidden “child rows” in responsive mode.






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