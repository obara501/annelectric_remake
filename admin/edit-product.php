<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
    # Assign form input with variables.
	if (isset($_POST['submit'])) {
		$partNumber = $_POST['partnumber'];
		$productName = $_POST['productname'];
		$category = $_POST['category'];
		$subCategory = $_POST['subcategory'];
		$brand = $_POST['brandname'];
		$productDescription= $_POST['productdescription'];
		$pack = $_POST['pack'];

        #Insert form data into database tbllaptops.
		$sql = "update tblproducts
                set PartNo=:partnumber,ProductName=:productname,Category=:category,SubCategory=:subcategory,Brand=:brandname,Description=:productdescription,Pack=:pack";

		$query = $dbh->prepare($sql);
		$query->bindParam(':partnumber', $partNumber, PDO::PARAM_STR);
		$query->bindParam(':productname', $productName, PDO::PARAM_STR);
		$query->bindParam(':category', $category, PDO::PARAM_STR);
		$query->bindParam(':subcategory', $subCategory, PDO::PARAM_STR);
		$query->bindParam(':brandname', $brand, PDO::PARAM_STR);
		$query->bindParam(':productdescription', $productDescription, PDO::PARAM_STR);
		$query->bindParam(':pack', $pack, PDO::PARAM_STR);
		$query->execute();

		$msg = "Product edited succesfully";
		
	}

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

		<title>Ann Electric | Admin Edit Product</title>

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
		<style>
			.errorWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #fff;
				border-left: 4px solid #dd3d36;
				-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}

			.succWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #fff;
				border-left: 4px solid #5cb85c;
				-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}
		</style>

	</head>

	<body>

		<?php include('includes/header.php'); ?>
		<div class="ts-main-content">
			<?php include('includes/leftbar.php'); ?>
			<div class="content-wrapper">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-12">

							<h2 class="page-title">Edit Product</h2>

							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-default" style="overflow: inherit !important;">
										<div class="panel-heading">Basic Info</div>
										<div class="panel-body">
										    <?php if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
											<?php
                                            $id = intval($_GET['id']);
                                            $sql = "SELECT tblproducts.*, tblbrand.id as bid, tblbrand.BrandName, category.id as cid, category.CategoryName, category.parent_id as pid from tblproducts
											        join tblbrand on tblbrand.id = tblproducts.Brand
													join category on category.id = tblproducts.Category
											        where tblproducts.id=:id";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':id', $id,PDO::PARAM_STR);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            
                                            if($query->rowCount() > 0){ foreach ($results as $result){ ?> 
										    <form method="post" class="form-horizontal" enctype="multipart/form-data">
											    <div class="form-group">
											    	<label class="col-sm-2 control-label">PartNo<span style="color: red;">*</span></label>
											    	<div class="col-sm-4">
											    		<input type="text" name="partnumber" class="form-control" value="<?php echo htmlentities($result->PartNo); ?>" required>
											    	</div>

											    	<label class="col-sm-2 control-label">ProductName<span style="color: red;">*</span></label>
											    	<div class="col-sm-4">
											    		<input type="text" name="productname" class="form-control" value="<?php echo htmlentities($result->ProductName); ?>" required>
											    	</div>
											    </div>
        
											    <div class="hr-dashed"></div>

												<div class="form-group">
													
													<label class="col-sm-2 control-label">Select Category<span style="color: red;">*</span></label>
													<div class="col-sm-4">
														<select class="selectpicker" name="category" required>
															<option value="<?php echo htmlentities($result->cid);?>"><?php echo htmlentities($catname = $result->CategoryName);?></option>
															<?php
															$cats = $dbh->prepare("SELECT id, parent_id, CategoryName from category where parent_id IS NULL");
															$cats->execute();
															$categories = $cats->fetchAll(PDO::FETCH_OBJ);
															if ($cats->rowCount()>0){
																foreach ($categories as $category){ ?>
																<option value="<?php echo htmlentities($category->id)?>"><?php echo htmlentities($category->CategoryName);?></option>
																<?php 
																}
															}
															?>
														</select>
													</div>

													<label class="col-sm-2 control-label">Select SubCategory</span></label>
													<div class="col-sm-4">
														<select class="selectpicker" name="subcategory">
															<option value="<?php echo htmlentities($result->SubCategory);?>"><?php echo htmlentities($subname = $result->SubCategory);?></option>
															<?php
															$subcats = $dbh->prepare("SELECT id,parent_id,CategoryName from category where parent_id IS NOT NULL ORDER BY id");
															$subcats->execute();
															$subcategories = $subcats->fetchAll(PDO::FETCH_OBJ);
															if ($subcats->rowCount()>0){
																foreach ($subcategories as $subcategory){ ?>
																<option value="<?php echo htmlentities($subcategory->id)?>"><?php echo htmlentities($subcategory->CategoryName);?></option>
																<?php }
															}
														
															?>
														</select>
													</div>
												</div>

											    <div class="hr-dashed"></div>

												<div class="form-group">
												    <label class="col-sm-2 control-label">Pack<span style="color: red;">*</span></label>
													<div class="col-sm-4">
														<input type="text" name="pack" class="form-control" value="<?php echo htmlentities($result->Pack)?>" required>
													</div>

													<label class="col-sm-2 control-label">Select Brand<span style="color:red">*</span></label>
													<div class="col-sm-4">
														<select class="selectpicker" name="brandname" required>
															<option value="<?php echo htmlentities($result->bid); ?>"><?php echo htmlentities($bdname = $result->BrandName); ?></option>
															<?php 
															$brandquery = $dbh->prepare("select id,BrandName from tblbrand");
															$brandquery->execute();
															$brands = $brandquery->fetchAll(PDO::FETCH_OBJ);
															if ($brandquery->rowCount() > 0) {
																foreach ($brands as $brand) {
															?>
																<option value="<?php echo htmlentities($brand->id); ?>"><?php echo htmlentities($brand->BrandName); ?></option>
															<?php }
															} ?>

														</select>
													</div>
												</div>

												<div class="hr-dashed"></div>

												<div class="form-group">
													<label class="col-sm-2 control-label">Product Description<span style="color:red">*</span></label>
													<div class="col-sm-10">
														<textarea class="form-control" name="productdescription" rows="3" required><?php echo htmlentities($result->Description); ?></textarea>
													</div>
												</div>

												<div class="hr-dashed"></div>
        
											    <div class="form-group">
											    	<div class="col-sm-12">
											    		<h4><b>Product Images</b></h4>
											    	</div>
											    </div>

											    <div class="form-group">
                                                    <div class="col-sm-4">
											    		Image 1 <img src="img/productimages/<?php echo htmlentities($result->Image1); ?>" width="300" height="300" style="border:solid 1px #d9d2d2">
											    		<a href="changeimage1.php?imgid=<?php echo htmlentities($result->id) ?>">Change Image 1</a>
											    	</div>
											    	<div class="col-sm-4">
											    		Image 2<img src="img/productimages/<?php echo htmlentities($result->Image2); ?>" width="300" height="300" style="border:solid 1px #d9d2d2">
											    		<a href="changeimage2.php?imgid=<?php echo htmlentities($result->id) ?>">Change Image 2</a>
											    	</div>
											    	<div class="col-sm-4">
											    		Image 3<img src="img/productimages/<?php echo htmlentities($result->Image3); ?>" width="300" height="300" style="border:solid 1px #d9d2d2">
											    		<a href="changeimage3.php?imgid=<?php echo htmlentities($result->id) ?>">Change Image 3</a>
											    	</div>
											    </div>
        
											    <div class="form-group">
											    	<div class="col-sm-4">
											    		Description Image<img src="img/productimages/<?php echo htmlentities($result->DetImage); ?>" width="300" height="800" style="border:solid 1px #d9d2d2">
											    		<a href="changedetailimage.php?imgid=<?php echo htmlentities($result->id) ?>">Change Description Image</a>
											    	</div>
											    </div>
                                                
											    <div class="hr-dashed"></div>

												<?php }}?>

                                                <div class="form-group">
											        <div class="col-sm-8 col-sm-offset-2" style="text-align:center; margin-bottom: 30px;">
											            <button class="btn btn-primary" name="submit" type="submit">Save changes</button>
											        </div>
											    </div>

                                            </form>
											
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