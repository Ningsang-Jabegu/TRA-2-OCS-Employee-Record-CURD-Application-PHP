<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Dashboard | Om Services Consultancy Pvt. Ltd.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap 4.5.2 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome 4.7.0 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Google Fonts for luxury look -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Roboto:wght@400;500&display=swap"
        rel="stylesheet">
    <!-- Your custom style -->
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">
            <i class="fa fa-diamond mr-2"></i>Om Services Consultancy Pvt. Ltd.
        </a>
    </nav>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-2 mb-4 clearfix">
                        <span class="dashboard-title pull-left">Employees Details</span>
                        <a href="create.php" class="btn btn-success float-right shadow-sm"><i class="fa fa-plus color-white"></i>
                            Add New Employee</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    // Format salary in Nepali number system (lakh/crore)
                    function nepali_number_format($num)
                    {
                        $num = (string) $num;
                        $len = strlen($num);
                        if ($len > 3) {
                            $last3 = substr($num, -3);
                            $restUnits = substr($num, 0, $len - 3);
                            $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
                            $formatted = $restUnits . "," . $last3;
                        } else {
                            $formatted = $num;
                        }
                        return $formatted;
                    }

                    // Attempt select query execution
                    $sql = "SELECT * FROM employees";
                    if ($result = mysqli_query($link, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo '<table class="table table-bordered table-striped">';
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>ID</th>";
                            echo "<th>Name</th>";
                            echo "<th>Address</th>";
                            echo "<th>Salary</th>";
                            echo "<th>Action</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['address'] . "</td>";
                                // For individual salary
                                $salary = $row['salary'];
                                $salary_parts = explode('.', number_format($salary, 2, '.', ''));
                                $salary_int = nepali_number_format($salary_parts[0]);
                                $salary_dec = isset($salary_parts[1]) ? '.' . $salary_parts[1] : '';
                                // echo "<td>" . $row['salary'] . "</td>";
                                echo "<td class='right-align'>रु " . $salary_int . $salary_dec . "</td>";
                                echo "<td>";
                                echo '<a href="read.php?id=' . $row['id'] . '" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                echo '<a href="update.php?id=' . $row['id'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                echo '<a href="delete.php?id=' . $row['id'] . '" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "<tfoot>";
                            echo "<tr>";
                            echo "<th colspan='1'>Total</th>";

                            // Count total rows and sum salary
                            $total_ids = mysqli_num_rows($result);
                            mysqli_data_seek($result, 0); // Reset pointer
                            echo "<th colspan='2'>$total_ids Employees</th>";
                            // For total salary
                            $total_salary = 0;
                            while ($row_sum = mysqli_fetch_array($result)) {
                                $total_salary += $row_sum['salary'];
                            }
                            $total_salary_parts = explode('.', number_format($total_salary, 2, '.', ''));
                            $total_salary_int = nepali_number_format($total_salary_parts[0]);
                            $total_salary_dec = isset($total_salary_parts[1]) ? '.' . $total_salary_parts[1] : '';
                            echo "<th colspan='1' class='right-align'>रु " . $total_salary_int . $total_salary_dec . "</th>";
                            echo "<th colspan='1'> </th>";
                            // echo "<th><a href='download.php' class='btn btn-primary btn-sm'><i class='fa fa-download'></i> Download</a></th>";
                            echo "</tr>";
                            echo "</tfoot>";
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else {
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close db connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center mt-5 mb-3">
        <hr>
        <p class="mb-1">&copy; 2024 - <?php echo date('Y'); ?> Online Student Record Management System. All rights
            reserved.</p>
        <small>
            Developed by <a href="https://ningsangjabegu.com.np" target="_blank">Ningsang Jabegu</a> as part of
            Trainingship Program conducted by OM Consultancy Services.<br>
            For support or queries, contact: <a href="mailto:info@ningsangjabegu.com.np">info@ningsangjabegu.com.np</a>
        </small>
    </footer>
</body>

</html>