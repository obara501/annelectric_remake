<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
?>
	<!DOCTYPE html>
	<html lang="en" class="no-js">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Geofrey Obara">
		<meta name="theme-color" content="#3e454c">

		<title>Laptop Rental Portal | Admin Dashboard</title>

		<!-- Font awesome -->
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<!-- Sandstone Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Bootstrap Datatables -->
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
		<!-- Bootstrap social button library -->
		<link rel="stylesheet" href="css/bootstrap-social.css">
		<!-- Bootstrap select -->
		<link rel="stylesheet" href="css/bootstrap-select.css">
		<!-- Bootstrap file input -->
		<link rel="stylesheet" href="css/fileinput.min.css">
		<!-- Awesome Bootstrap checkbox -->
		<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
		<!-- Admin Stye -->
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
		<?php include('includes/header.php'); ?>

		<div class="ts-main-content">
			<?php include('includes/leftbar.php'); ?>
			<div class="content-wrapper">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-12">

							<h2 class="page-title" style="text-align: center;">Dashboard</h2>

							<div class="row">
								<div class="col-md-12">
									<div class="row">

										<div class="col-md-3">
											<div class="panel panel-default">
												<div class="panel-body bk-primary text-light">
													<div class="stat-panel text-center">
														<?php
														$sql = "SELECT id from tblproducts ";
														$query = $dbh->prepare($sql);
														$query->execute();
														$results = $query->fetchAll(PDO::FETCH_OBJ);
														$regproducts = $query->rowCount();
														?>
														<div class="stat-panel-number h1 "><?php echo htmlentities($regproducts); ?></div>
														<div class="stat-panel-title text-uppercase">Registered Products</div>
													</div>
												</div>
												<a href="manage-products.php" class="block-anchor panel-footer">Full Details <i class="fa fa-arrow-right"></i></a>
											</div>
										</div>

										<div class="col-md-3">
											<div class="panel panel-default">
												<div class="panel-body bk-success text-light">
													<div class="stat-panel text-center">
														<?php
														$sql1 = "SELECT parent_id from category where  parent_id IS NULL";
														$query1 = $dbh->prepare($sql1);;
														$query1->execute();
														$results1 = $query1->fetchAll(PDO::FETCH_OBJ);
														$categories = $query1->rowCount();
														?>
														<div class="stat-panel-number h1 "><?php echo htmlentities($categories); ?></div>
														<div class="stat-panel-title text-uppercase">Listed Categories</div>
													</div>
												</div>
												<a href="manage-category.php" class="block-anchor panel-footer text-center">Full Details &nbsp; <i class="fa fa-arrow-right"></i></a>
											</div>
										</div>

										<div class="col-md-3">
											<div class="panel panel-default">
												<div class="panel-body bk-success text-light">
													<div class="stat-panel text-center">
														<?php
														$br = $dbh->prepare("SELECT id from tblbrand");
														$br->execute();
														$brands = $br->fetchAll(PDO::FETCH_OBJ);
														$brands = $br->rowCount();
														?>
														<div class="stat-panel-number h1 "><?php echo htmlentities($brands); ?></div>
														<div class="stat-panel-title text-uppercase">Listed Brands</div>
													</div>
												</div>
												<a href="manage-brand.php" class="block-anchor panel-footer text-center">Full Details &nbsp; <i class="fa fa-arrow-right"></i></a>
											</div>
										</div>

										<div class="col-md-3">
											<div class="panel panel-default">
												<div class="panel-body bk-info text-light">
													<div class="stat-panel text-center">
														<?php
														$sql2 = "SELECT id from category where parent_id IS NOT NULL";
														$query2 = $dbh->prepare($sql2);
														$query2->execute();
														$results2 = $query2->fetchAll(PDO::FETCH_OBJ);
														$subcategories = $query2->rowCount();
														?>

														<div class="stat-panel-number h1 "><?php echo htmlentities($subcategories); ?></div>
														<div class="stat-panel-title text-uppercase">Listed Sub Categories</div>
													</div>
												</div>
												<a href="#" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
									
				</div>
			</div>
		</div>

		<!-- Loading Scripts -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap-select.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>
		<script src="js/Chart.min.js"></script>
		<script src="js/fileinput.js"></script>
		<script src="js/chartData.js"></script>
		<script src="js/main.js"></script>
	</body>

	</html>
<?php } ?>