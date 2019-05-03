<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>

<?php 
	if(!logged_in()){
		header("Location: index.php");
	}
?>

<div class="row">
	<div class="col-lg-6 col-lg-offset-3">
	<?php validate_listing(); ?>
	<?php display_message(); ?>
	<?php if(isset($_GET['delete'])) {delete_listing($_GET['delete']);} ?>
	<?php if(isset($_GET['edit'])) {get_listing($_GET['edit']);} ?>				
</div>

<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<h1 class="text-center text-dark">Create Listings</h1>
		</div>
	</div>
</div>
<h1 class="text-center">
	<div class="row">
		<div class="col-md-4">
			<?php if(isset($_GET['edit'])) { $row=get_listing($_GET['edit']); ?>
				<h3 class="text-center text-info">Edit</h3>			
				<form method="post" enctype="multipart/form-data">
					<div class="form-group">
						<input type="hidden" name="id" value="<?= $row['id']; ?>">
						<input type="text" name="bk_title" class="form-control" placeholder="Enter Title" value="<?= $row['bk_title']; ?>" required>
						<input type="text" name="isbn" class="form-control" placeholder="Enter ISBN" value="<?= $row['isbn']; ?>" required>
						<input type="text" name="bk_price" class="form-control" placeholder="Enter Listing Price" value="<?= $row['bk_price']; ?>" required>
						<input type="text" name="class_num" class="form-control" placeholder="Enter Class Number" value="<?= $row['class_num']; ?>" required>
						<input type="text" name="bk_desc" class="form-control" placeholder="Enter Description" value="<?= $row['bk_desc']; ?>" required>
						<input type="text" name="bk_author" class="form-control" placeholder="Enter Author" value="<?= $row['bk_author']; ?>">
						<label label class="btn btn-default btn-lg btn-block">Upload Image
							<input type="hidden" name="old_image" value="<?= $row['bk_image']; ?>">
							<input type="file" name="bk_image" class="form-control" accept="image/*" style="display: none;">
						</label>
						<input type="submit" name="add" class="btn btn-warning btn-lg btn-block" value="Update Listing">	
					</div>						
				</form>
			<?php }else{ ?>
				<h3 class="text-center text-info">Create</h3>
				<form method="post" enctype="multipart/form-data">
					<div class="form-group">
						<input type="text" name="bk_title" class="form-control" placeholder="Enter Title*" required>
						<input type="text" name="isbn" class="form-control" placeholder="Enter ISBN*" required>
						<input type="text" name="bk_price" class="form-control" placeholder="Enter Listing Price*" required>
						<input type="text" name="class_num" class="form-control" placeholder="Enter Class Number*" required>
						<input type="text" name="bk_desc" class="form-control" placeholder="Enter Description">
						<input type="text" name="bk_author" class="form-control" placeholder="Enter Author">
						<label label class="btn btn-default btn-lg btn-block">Upload Image
							<input type="file" name="bk_image" class="form-control" accept="image/*" style="display: none;">
						</label>
						<input type="submit" name="add" class="btn btn-primary btn-lg btn-block" value="Add Listing">	
					</div>						
				</form>
			<?php } ?>
		</div>
		<div class="col-md-8">
		<?php $result=get_user_listings(); ?>
			<h3 class="text-center text-info">My Listings</h3>
			<table class ="table table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th style="font-size: 18px;">Price</th>
						<th style="font-size: 18px;">Image</th>
						<th style="font-size: 18px;">Book Title</th>
						<th style="font-size: 18px;">Author</th>
						<th style="font-size: 18px;">Class #</th>
						<th style="font-size: 18px;">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php while($row = fetch_assoc($result)){ ?>
					<tr>
						<td style="font-size: 18px;"><?= "$".$row['bk_price']; ?></td>
						<td><img src="<?= $row['bk_image']; ?>" width="75"></td>
						<td style="font-size: 18px;"><?= $row['bk_title']; ?></td>
						<td style="font-size: 18px;"><?= $row['bk_author']; ?></td>
						<td style="font-size: 18px;"><?= $row['class_num']; ?></td>
						<td style="font-size: 18px;">
							<div class="btn-group">
								<a href="details.php?id=<?= $row['id']; ?>" class="btn btn-primary">Details</a>
								<a href="create.php?edit=<?= $row['id']; ?>" class="btn btn-primary">Edit</a>
								<a href="create.php?delete=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');" class="btn btn-primary">Delete</a>
							</div>
						</td>
					</tr>
					<?php } ?>
				</tbody>	
			</table>
		</div>
	</div>
</h1>

<?php include("includes/footer.php") ?>