

<?php include("includes/header.php")?>

 <?php include("includes/nav.php")?>



<div class="row">
		<div class="col-lg-6 col-lg-offset-3">

	   <?php display_message(); ?>

	    
	     </div>

	</div>


	<div class="page-header">
	
		<h1 class="text-center">ISU TEXTBOOK MARKETPLACE</h1>
		<h2 class="text-center">Newest Listing Highlight</h2>

		<?php $result = get_newest_listing() ?>

		<ul class="list-group">
			<?php $row = fetch_assoc($result); ?>
				<a href="details.php?id=<?= $row['id']; ?>" class="list-group-item">
					<div>
						<div class="row">
							<span><img class="col-xs-4 col-md-2" src="<?= $row['bk_image']; ?>" ></span>
							<span>
								<div class="col-xs-6 col-md-9">
									<?= date("F d, Y", strtotime($row['create_date'])); ?> 
									<h3 style="font-size: calc(24px + .5vw);"><?= $row['bk_title']; ?></h3>
									<?= "$".$row['bk_price']; ?>
									
								</div>
								<div class="col-xs-2 col-md-1">
									<p class="pull-right"><?= get_user_details($row['userid'], 'email') ?></p>
									<br>
									<p class="pull-right"><?= $row['class_num']; ?></p>
								</div>
							</span>
						</div>
					</div>
				</a>
		</ul>


	
	

	
    
  </div>



	<?php include("includes/footer.php")?>

