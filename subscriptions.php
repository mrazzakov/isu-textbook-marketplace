<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>

<?php 
	if(!logged_in()){
		header("Location: index.php");
	}
?>
<?php display_message(); ?>
<?php if(isset($_GET['class_num'])) { $row=add_class($_GET['class_num']); } ?>

<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<h1 class="text-center text-dark">Subscriptions</h1>
            <h4 class="text-center text-dark">Subscribe To Classes For Emails When New Book Postings Appear For The Classes</h4>
            <form class="text-center form-inline" action="subscriptions.php">
            <div class="form-group">
                <label for="class_num">Add New Class Number:</label>
                <input type="text" name="class_num" class="form-control">
            </div>
            <button type="submit" class="btn btn-default">Add</button>
            </form>
            <br>
		</div>
	</div>
</div>

<?php $user_result=get_all_user_notifications(); ?>
<?php $unique_array=get_all_unique_notifications(); ?>
    <div class="col-sm-6 col-sm-offset-3">
        <div class="list-group">
            <?php while($row = fetch_assoc($user_result)){ ?>
                <a href="subscriptions.php?class_num=<?= $row['class_num'] ?>" class="list-group-item list-group-item-success"><?= strtoupper($row['class_num']); ?></a>
            <?php } ?>
            <?php foreach($unique_array as $value){ ?>
                <a href="subscriptions.php?class_num=<?= $value ?>" class="list-group-item"><?= strtoupper($value); ?></a>
            <?php } ?>
        </div>
    </div>
</div>
