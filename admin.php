<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>

<?php 
	if(!logged_in() || !is_admin()){
		header("Location: index.php");
	}
?>

<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<h1 class="text-center text-dark">Admin Page</h1>
		</div>
	</div>
</div>
<?php if(isset($_GET['strike'])) {strike_user($_GET['strike']);} ?>
<?php if(isset($_GET['delete'])) {delete_user($_GET['delete']);} ?>
<?php if(isset($_GET['admin'])) {admin_user($_GET['admin'], $_GET['isAdmin']);} ?>	
<?php $result=get_all_users(); ?>
	<h3 class="text-center text-info">Users</h3>
	<table class ="table table-bordered table-hover table-condensed">
		<thead>
			<tr>
				<th style="font-size: 18px;">Name</th>
				<th style="font-size: 18px;">Username</th>
				<th style="font-size: 18px;">Email</th>
				<th style="font-size: 18px;">Active Account?</th>
				<th style="font-size: 18px;">Strike Count</th>
				<th style="font-size: 18px;">Admin?</th>
				<th style="font-size: 18px;">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php while($row = fetch_assoc($result)){ ?>
			<tr>
				<td style="font-size: 18px;"><?= $row['first_name'].' '.$row['last_name']; ?></td>
				<td style="font-size: 18px;"><?= $row['username'] ?></td>
				<td style="font-size: 18px;"><?= $row['email']; ?></td>
				<td style="font-size: 18px;"><?= $row['active']; ?></td>
				<td style="font-size: 18px;"><?= $row['strike']; ?></td>
				<td style="font-size: 18px;"><?= $row['admin']; ?></td>
				<td style="font-size: 18px;">
					<div class="btn-group">
						<a href="admin.php?strike=<?= $row['userid']; ?>" onclick="return confirm('Confirm Strike?');" class="btn btn-warning">Strike User</a>
						<a href="admin.php?delete=<?= $row['userid']; ?>" onclick="return confirm('Are you sure you want to delete this user?  This action will permanently delete the profile.');" class="btn btn-danger">Delete User</a>
						<?php if($row['admin'] == 0) { ?>
							<a href="admin.php?admin=<?= $row['userid']; ?>&isAdmin=<?= $row['admin']; ?>" onclick="return confirm('Are you sure you want to give admin rights to this user?');" class="btn btn-primary">Give Admin</a>
						<?php } else { ?>
							<a href="admin.php?admin=<?= $row['userid']; ?>&isAdmin=<?= $row['admin']; ?>" onclick="return confirm('Are you sure you want to take away admin rights from this user?');" class="btn btn-info">Take Admin</a>
						<?php } ?>
					</div>
				</td>
			</tr>
			<?php } ?>
		</tbody>	
	</table>
