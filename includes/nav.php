<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">ISU Textbook Marketplace</a>
        </div>

        <div id="navbar" class="collapse navbar-collapse">
          <?php if(!logged_in()):?>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="login.php">Login</a></li>
            </ul>
          <?php endif; ?>

          <?php if(logged_in()):?>
            <ul class="nav navbar-nav">
              <li><a href="create.php">Create</a></li>
              <li><a href="browse.php?search=&sort=&advanced=0&bk_title=&isbn=&bk_price=&class_num=&bk_desc=&bk_author=">Browse</a></li>
              <li><a href="subscriptions.php">Subscriptions</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            <?php if(is_admin()):?>
              <li><a href="admin.php"><span class="glyphicon glyphicon-user"></span></a></li>
            <?php endif; ?>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          <?php endif; ?>
        </div>
      </div>
  </nav>
<div class="container">
  

