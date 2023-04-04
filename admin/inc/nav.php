  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
<!--       <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
 <!--       <li class="nav-item">
      <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li> -->
	<!--   <li><button id="increase-font-size">+</button></li>
		
     <li class="nav-item">
        <a class="nav-link" data-widget="textsize" href="#" role="button">
          <i class="fas fa-text-size"></i>
        </a>
      </li>
	  <li><button id="decrease-font-size">-</button></li> -->
	        <!-- Language Dropdown Menu -->
		<!-- AddAllLanguages -->
		<li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
        <!--  <i class="flag-icon flag-icon-us"></i> -->
		<i class="fas fa-language"></i>
        </a>
		<div class="dropdown-menu dropdown-menu-right p-0">
		<?
		$sql ="select Language_Name, Language_ID, Flag_ID from Languages where Active=?";
		$params=array('1');
		$languages = $FoQusdatabase ->Select($sql,$params);
		foreach($languages as $language){
		echo ('<a href="index.php?lang=' . $language['Language_ID']. '" class="dropdown-item">');
		echo ('<i class="flag-icon flag-icon-' . $language['Flag_ID']. ' mr-2"></i>' . $language['Language_Name'] );
		echo ('</a>');
			}
		
		?>


        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" data-widget="lockscreen"  href="logout.php" role="button">
          <i class="fas fa-lock"></i>
        </a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" data-toggle="modal" data-target="#logoutModal" href="#" role="button">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->