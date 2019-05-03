<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>

<?php 
	if(!logged_in()){
		header("Location: index.php");
	}
?>
<?php if(isset($_GET['id'])) { $row=get_listing($_GET['id']); ?>

<div class="row">
	<div class="col-lg-6 col-lg-offset-3">
	<?php display_message(); ?>			
</div>

<div class="container-fluid">
	<div class="row justify-content-center">
        <div class="col-md-6 col-md-offset-3 bg-info">
            <br>
            <img class="img-responsive center center-block"src="<?= $row['bk_image']; ?>">
            <h1 class="text-center"><?= $row['bk_title']; ?></h1>
            <h4 class="text-center"><?= $row['bk_author']; ?></h4>
            
            <h4 class="text-center" style="font-weight: bold;">$<?= $row['bk_price']; ?></h4>
            <br>
            <h5 class="text-center" style="font-weight: bold;">Description:</h5>
            <div class="center-text">
                <p class="text-center"><?= $row['bk_desc']; ?></p>
            </div>
            <br>
            <h4 class="text-center"><?= $row['class_num']; ?></h4>
            
            <h4 class="text-center">Contact: <a href="mailto: <?= get_user_details($row['userid'], 'email'); ?>"><?= get_user_details($row['userid'], 'email'); ?></a></h4>
            <h4 class="text-center">Created: <?= get_listing_details($row['id'], 'create_date'); ?></h4>
            <h5 class="text-center">ISBN: <?= $row['isbn']; ?></h5>
            <?php if(is_admin()){ ?>
                <?php if(isset($_GET['strike'])) {strike_user_listing($_GET['id'], $_GET['strike']);} ?>
                <a href="details.php?id=<?= $_GET['id'] ?>&strike=<?= $row['userid'] ?>" onclick="return confirm('Confirm Strike?');" class="btn btn-warning center-block">Strike User & Delete Listing</a>
                <br>
            <?php }else { ?>
                <?php if(isset($_GET['report'])) {report_listing($_GET['id']);} ?>
                <a href="details.php?id=<?= $_GET['id'] ?>&report=1" onclick="return confirm('Confirm Report?');" class="btn btn-danger center-block">Report Listing</a>
                <br>
            <?php } ?>
        </div>
	</div>
</div>
<br>
<br>
<br>

<?php } ?>

