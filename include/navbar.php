<div class="navbar-wrapper" >
    <nav class="navbar navbar-default navstyle " >
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header"  >
          <a class="navbar-brand navImg" href="index.php" id = "sjeclogo">
            <img src="img/long_logo_transparent.png" alt="Faculty Analysis" height="60px" width="250px" style="margin-top:7px;">
          </a>
          <button type="button" style="width:80%; float: right;" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mynav" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <?php if(isset($_SESSION['email'])){?>
          <div class="collapse navbar-collapse" id="mynav">
          <ul class="nav navbar-nav navbar-right">
            <!--<li><a href="admin_dash.php#manageDept">REGISTER</a></li>-->
            <li><a href="dashboard_new.php">DASHBOARD</a></li>
            <li><a href="logout.php">LOGOUT</a></li>
          </ul>
        </div>
       <?php }else{ ?>
        <div class="collapse navbar-collapse" id="mynav">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="login.php">LOGIN</a></li>
            
            <!-- <li><a href="dashboard.php">DASHBOARD</a></li> -->
        </div><!-- /.navbar-collapse -->
        <?php }?>
      </div><!-- /.container-fluid -->
    </nav>
  </div>

