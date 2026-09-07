 <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MPW-BARMM PIMS Navbar</title>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <style>
            body {
                margin: 0;
                font-family: Arial, Helvetica, sans-serif;
            }

            /* Navbar container */
            .topnav {
                display: flex;
                justify-content: space-between;
                align-items: center;
                background-color: #12446e;
                border-top: 4px solid #12446e;
                border-bottom: 2px solid #12446e;
                min-height: 88px;
                padding: 0 22px;
                flex-wrap: nowrap;
                box-sizing: border-box;
            }

            /* Left and right sections */
            .topnav .left-section,
            .topnav .right-section {
                display: flex;
                align-items: center;
            }

            .topnav .right-section {
                gap: 12px;
                flex-wrap: wrap;
                justify-content: flex-end;
            }

            .topnav .left-section {
                min-width: 0;
                flex: 1 1 auto;
            }

            /* Navbar brand/logo */
            .navbar-logo {
                width: 40px;
                height: 40px;
                margin-right: 14px;
                object-fit: contain;
            }

            .navbar-brand {
                display: flex;
                align-items: center;
                color: #ffffff;
                text-decoration: none;
                min-width: 0;
            }

            .brand-text {
                display: flex;
                flex-direction: column;
                line-height: 1.2;
                min-width: 0;
            }

            .brand-title {
                font-size: 21px;
                font-weight: 700;
                color: #ffffff;
                overflow-wrap: anywhere;
            }

            .brand-subtitle {
                margin-top: 4px;
                font-size: 12px;
                font-weight: 400;
                color: #d8e4ee;
                overflow-wrap: anywhere;
            }

            /* Dropdown */
            .dropdown {
                position: relative;
            }

            .dropbtn {
                background: none;
                border: none;
                font-size: 16px;
                cursor: pointer;
                color: #ffffff;
                padding: 15px 10px;
                display: flex;
                align-items: center;
                gap: 5px;
                border-radius: 4px;
                line-height: 1;
            }

            .dropbtn i {
                margin-right: 5px;
            }

            .dropbtn a {
                color: inherit;
                text-decoration: none;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                top: 100%;
                left: 50%;
                transform: translateX(-50%);
                background-color: #ffffff;
                min-width: 160px;
                padding: 0;
                box-shadow: 0 8px 18px rgba(0, 0, 0, 0.18);
                z-index: 1000;
            }

            .dropdown-content a {
                color: #000000;
                padding: 13px 16px;
                text-decoration: none;
                display: block;
                font-size: 16px;
                line-height: 1.15;
                white-space: nowrap;
            }

            .dropdown-content a:hover {
                background-color: #f1f5f9;
                color: #12446e;
            }

            .dropdown:hover .dropdown-content {
                display: block;
            }

            .dropdown:hover .dropbtn {
                background-color: rgba(255, 255, 255, 0.1);
            }

            /* Hamburger menu */
            .icon {
                display: none;
                font-size: 24px;
                cursor: pointer;
                color: #ffffff;
                flex: 0 0 auto;
            }

            @media screen and (max-width: 1100px) {
                .topnav {
                    padding: 0 16px;
                }

                .topnav .right-section {
                    gap: 4px;
                }

                .brand-title {
                    font-size: 18px;
                }

                .dropbtn {
                    font-size: 15px;
                    padding: 14px 8px;
                }
            }

            @media screen and (max-width: 768px) {

                .topnav {
                    align-items: flex-start;
                    padding: 12px 18px;
                    flex-wrap: wrap;
                    min-height: 76px;
                }

                .topnav .left-section {
                    width: calc(100% - 42px);
                    flex: 1 1 calc(100% - 42px);
                }

                .navbar-logo {
                    width: 36px;
                    height: 36px;
                    margin-right: 10px;
                }

                .topnav .right-section {
                    display: none;
                    flex-direction: column;
                    width: 100%;
                    align-items: flex-start;
                    gap: 0;
                    margin-top: 12px;
                    order: 3;
                }

                .topnav.responsive .right-section {
                    display: flex;
                }

                .brand-title {
                    font-size: 16px;
                }

                .brand-subtitle {
                    font-size: 10px;
                }

                .dropdown {
                    width: 100%;
                }

                .dropdown-content {
                    position: relative;
                    top: auto;
                    left: auto;
                    transform: none;
                    display: block;
                    width: calc(100% - 24px);
                    margin-left: 24px;
                    box-shadow: none;
                    background-color: rgba(255, 255, 255, 0.08);
                }

                .dropdown-content a {
                    color: #ffffff;
                    padding: 12px 14px;
                }

                .dropdown-content a:hover {
                    background-color: rgba(255, 255, 255, 0.12);
                    color: #ffffff;
                }

                .topnav.responsive .dropbtn {
                    width: 100%;
                    text-align: left;
                    justify-content: flex-start;
                }

                .icon {
                    display: block;
                }
            }

            @media screen and (max-width: 480px) {
                .topnav {
                    padding: 10px 12px;
                }

                .navbar-logo {
                    width: 32px;
                    height: 32px;
                    margin-right: 8px;
                }

                .brand-title {
                    font-size: 14px;
                }

                .brand-subtitle {
                    font-size: 9px;
                }

                .icon {
                    font-size: 22px;
                }
            }
        </style>
    </head>

    <body>

        <div class="topnav" id="myTopnav">
            <!-- Left Section -->
            <div class="left-section">
                <a href="#" class="navbar-brand">
                    <img src="images/mpw-icon.png" alt="MPW Logo" class="navbar-logo">
                    <span class="brand-text">
                        <span class="brand-title">Ministry of Public Works</span>
                        <span class="brand-subtitle">Bangsamoro Autonomous Region in Muslim Mindanao</span>
                    </span>
                </a>
            </div>

            <!-- Right Section -->
            <div class="right-section">
                <!-- Home -->
                <div class="dropdown">
                    <!-- <button class="dropbtn"><i class="fas fa-home"></i> Home</button> -->
                    <button class="dropbtn" style="margin-top: 1px;"><a href="admin.php"><i class='fas fa-home'></i> Home</a></button>
                    <div class="dropdown-content">
                        <!-- <a href="home.php">Main Home</a> -->
                    </div>
                </div>

                <!-- Project List -->
                <div class="dropdown">
                    <button class="dropbtn"><i class="far fa-list-alt"></i> List <i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <a href="admin.php">User</a>
                        <a href="indexdocs_cside_funded.php">Funded</a>
                        <a href="unfunded_cside.php">Unfunded</a>
                        <a href="indexdocs_cside_planning.php">Planning</a>
                        <a href="adminviewdocs2.php">Documents</a>
                        <a href="indexdocs_cside_fundedprojects.php">Funded 2.0</a>
                        <!-- <a href="#">Planning</a> -->
                    </div>
                </div>

                <!-- Communication -->
                <!-- <div class="dropdown">
                    <button class="dropbtn"><i class="fas fa-share"></i> Communication <i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <a href="incoming.php">Incoming</a>
                        <a href="outgoing.php">Outgoing</a>
                        <a href="planningsection.php">Planning</a>
                        <a href="test.php">Test</a>
                        <a href="documents.php">Documents</a>
                        <a href="/admin/indexdocs_cside.php" target="_blank">Documents 2.0</a>
                    </div>
                </div> -->

                <!-- User -->
                <div class="dropdown">
                    <button class="dropbtn"><i class="fas fa-cog"></i>Settings <i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </div>

            <!-- Hamburger icon -->
            <a href="javascript:void(0);" class="icon" onclick="toggleNavbar()">
                <i class="fa fa-bars"></i>
            </a>
        </div>

        <script>
            function toggleNavbar() {
                const navbar = document.getElementById("myTopnav");
                navbar.classList.toggle("responsive");
            }
        </script>

    </body>

    </html>

