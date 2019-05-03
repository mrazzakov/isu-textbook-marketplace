<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>

<?php 
	if(!logged_in()){
		header("Location: index.php");
	}
?>

<?php 
    $result=get_all_listings($_GET); 
    $advanced = !$_GET['advanced'];
    
?>
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-12">
            <form action="/isu_tb_mp/browse.php?<?= http_build_query(array_merge($_GET)) ?>">
                <div class="input-group">
                    <?php if($_GET['advanced'] == 0) { ?>
                        <input type="text" class="form-control" placeholder="Search" name="search" >
                    <?php } else { ?>
                        <input type="text" class="form-control" placeholder="Search" name="search" disabled>
                    <?php } ?>
                    <?php if($_GET['advanced'] == 0) { ?>
                        <input type="hidden" class="form-control" name="sort">
                        <input type="hidden" class="form-control" name="advanced" value="<?= $_GET['advanced']?>" >
                        <input type="hidden" class="form-control" name="bk_title">
                        <input type="hidden" class="form-control" name="isbn">
                        <input type="hidden" class="form-control" name="class_num">
                        <input type="hidden" class="form-control" name="bk_desc">
                        <input type="hidden" class="form-control" name="bk_author">
                    <?php } ?>

                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="glyphicon glyphicon-search"></i
                        ></button>
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="browse.php?<?= http_build_query(array_merge($_GET, array("sort"=>"create_date"))) ?>">Sort By New</a>
                            </li>
                            <li>
                                <a href="browse.php?<?= http_build_query(array_merge($_GET, array("sort"=>"bk_price"))) ?>">Sort By Price</a>
                            </li>
                            <li>
                                <a href="browse.php?<?= http_build_query(array_merge($_GET, array("sort"=>"bk_title"))) ?>">Sort By Title</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="browse.php?<?= http_build_query(array_merge($_GET, array("advanced"=> $advanced))) ?>">Advanced Search</a> 
                            </li>
                        </ul>
                    </div>
                </div>
                <div>
                <?php if($_GET['advanced'] == 1) { ?>
                    <br>
                    <input type="hidden" class="form-control" name="sort">
                    <input type="hidden" class="form-control" name="search">
                    <input type="hidden" class="form-control" name="advanced" value="<?= $_GET['advanced']?>" >
                    <input type="hidden" class="form-control" name="bk_title">
                    <input type="text" name="bk_title" class="form-control" placeholder="Search By Title" value='<?= $_GET['bk_title'] ?>'>
                    <input type="text" name="isbn" class="form-control" placeholder="Search By ISBN" value='<?= $_GET['isbn'] ?>'>
                    <input type="text" name="class_num" class="form-control" placeholder="Search By Class Number" value='<?= $_GET['class_num'] ?>'>
                    <input type="text" name="bk_desc" class="form-control" placeholder="Search By Description" value='<?= $_GET['bk_desc'] ?>'>
                    <input type="text" name="bk_author" class="form-control" placeholder="Search By Author" value='<?= $_GET['bk_author'] ?>'>
                    <button type="submit" class="btn btn-primary btn-block">Search</button>
                <?php } ?>
            </form>
            <br>
            <ul class="list-group">
                <?php while($row = fetch_assoc($result)){ ?>
                    <a href="/isu_tb_mp/details.php?id=<?= $row['id']; ?>" class="list-group-item">
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
                <?php } ?>
            </ul>
        </div>
    </div>
</div>