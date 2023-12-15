<?php
include "include/config.inc";


$page_name = "User Add";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $mysqli->insert_user_and_customer($_POST['user_email'], $_POST['user_name'], $_POST['user_password'], $_POST['user_level_id'], $_POST['first_name'], $_POST['last_name'], $_POST['primary_address'], $_POST['phone_number']);

    $mysqli->actions_insert("Added User: " . $_POST['user_email'], $_SESSION[PREFIX . '_user_id']);

    $_SESSION[PREFIX . '_action'][] = 'added';
    header("location: user_list.php");
    exit;
}//END POST

$in_id = (int)$_GET['id'];
if (!$in_id) {
    header("location: student_list.php");
    exit;
}
$transaction_info = $mysqli->transaction_info($in_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $app_name; ?> - <?php echo $page_name; ?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png"/>

</head>
<body>
<div class="container-scroller">

    <?php require_once 'partials/_navbar.php'; ?>
    <div class="container-fluid page-body-wrapper">
        <?php require_once 'partials/_sidebar.php'; ?>
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="d-flex align-items-end flex-wrap">
                                <div class="me-md-3 me-xl-5">
                                    <h2><?php echo $page_name; ?></h2>
                                    <p class="mb-md-0">text</p>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $page_name; ?></h4>
                                <p class="card-description">
                                    Horizontal form layout
                                </p>
                                <form class="forms-sample" id="form1" action="" method="post">
                                    <div class="form-group row">
                                        <label for="user_name" class="col-sm-3 col-form-label">User Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="user_name"
                                                   name="user_name"
                                                   placeholder="Enter a Username" autofocus required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="user_name" class="col-sm-3 col-form-label">First Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="user_name"
                                                   name="first_name"
                                                   placeholder="First Name" autofocus required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="user_name" class="col-sm-3 col-form-label">Last Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="user_name"
                                                   name="last_name"
                                                   placeholder="Last Name" autofocus required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="user_email" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" id="user_email"
                                                   name="user_email"
                                                   placeholder="Email" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="user_password" class="col-sm-3 col-form-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="user_password"
                                                   name="user_password"
                                                   placeholder="Password" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="user_email" class="col-sm-3 col-form-label">Primary Address</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="user_name"
                                                   name="primary_address"
                                                   placeholder="Primary Address" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="user_email" class="col-sm-3 col-form-label">Phone Number</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="user_email"
                                                   name="phone_number"
                                                   placeholder="Mobile Number" required>
                                        </div>
                                    </div>
                                    <?php
                                    if ($_SESSION[PREFIX . '_security'] > 9) { ?>


                                        <div class="form-group row" id="user_level">
                                            <label for="user_level_id" class="col-sm-3 col-form-label">User
                                                Level</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="user_level_id"
                                                        name="user_level_id" required>
                                                    <?php $results = $mysqli->user_level_list();
                                                    foreach ($results as $result) {
                                                        ?>
                                                        <option value="<?php echo $result['user_level_id']; ?>"><?php echo $result['user_level_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } else {
                                        ?> <input type="hidden" name="user_level_id" value="5"><?php } ?>


                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
            <!-- content-wrapper ends -->
            <?php require_once 'partials/_footer.php'; ?>
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="vendors/base/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="vendors/chart.js/Chart.min.js"></script>
<script src="vendors/datatables.net/jquery.dataTables.js"></script>
<script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="js/off-canvas.js"></script>
<script src="js/hoverable-collapse.js"></script>
<script src="js/template.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->


<!-- End custom js for this page-->

<script src="js/jquery.cookie.js" type="text/javascript"></script>
</body>

</html>

