      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->

        <a href="#" class="brand-link logo-switch">
          <img src="<?= assets('/assets/img/FOQUS_cam150.png') ?>" alt="FoQus Logo Small" class="brand-image-xl logo-xs">
          <img src="<?= assets('/assets/img/FOQUS_logo_633x144.png') ?>" alt="FoQus Logo Large" class="brand-image-xs logo-xl" style="left: 12px">
          <!--  <span class="brand-text font-weight-light">FoQus</span> -->
        </a>
        <? if (!isset($_SESSION['uname'])) {
          goto FinishSidebar;
        } ?>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="<?= assets('/assets/img/user2-160x160.jpg') ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="#" class="d-block"><? echo $_SESSION['uname']; ?></a>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
                <a href="/admin/dashboard" class="nav-link">
                  <i class="nav-icon fas fa-table-columns"></i>
                  <p>
                    <?= __('dashboard') ?>
                  </p>
                </a>
              </li>
              <? if ($_SESSION['ROLE_ID'] != 1) {
                goto RegistrationStaff;
              }  ?>
              <li class="nav-item">
                <a href="/admin/admin-tools" class="nav-link">
                  <i class="nav-icon fa-solid fa-user-gear"></i>
                  <p>
                    Admin Tools
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/manage-company" class="nav-link">
                  <i class="nav-icon fa-solid fa-pen-to-square"></i>
                  <p>
                    Manage Company
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/system-constants" class="nav-link">
                  <i class="nav-icon fa-solid fa-pen-to-square"></i>
                  <p>
                    System Constants
                  </p>
                </a>
              </li>
              <!-- agendas -->
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fa-solid fa-list-check"></i>
                  <p>
                    Maintain Agendas
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="/admin/agendas/view" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>List Agendas</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/admin/agendas/create" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Create Agenda</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/admin/agendas/create2" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Create Agenda 2</p>
                    </a>
                  </li>
                </ul>
              </li>
              <!--
              <li class="nav-item">
                <a href="shareholderimport.php?lang=<? echo $lang; ?>" class="nav-link">
                  <i class="nav-icon fa-solid fa-file-import"></i>
                  <p>
                    Import Shareholders
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="AGM-Activation.php?lang=<? echo $lang; ?>" class="nav-link">
                  <i class="nav-icon fa-solid fa-square-pen"></i>
                  <p>
                    AGM Activation
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <i class="nav-icon fa-solid fa-users-line"></i>
                  <p>
                    Presenters & Guests
                  </p>
                </a>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">
                    <li class="dropdown">
                      <a href="#" class="nav-link collapsed" data-toggle="collapse" data-target="#Presenters">
                        Presenters<span class="caret"></span></a>
                      <ul class="collapse navbar-collapse dropright bg-black" id="Presenters" role="menu">
                        <li><a href="Presenters-list.php">List</a></li>
                        <li><a href="presenters-create.php">Create</a></li>
                      </ul>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="nav-link collapsed" data-toggle="collapse" data-target="#Guests">
                        Guests<span class="caret"></span></a>
                      <ul class="collapse navbar-collapse dropright bg-black" id="Guests" role="menu">
                        <li><a href="Presenters-Guests.php">List</a></li>
                        <li><a href="#">Create</a></li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a href="approve-online-joiners.php?lang=<? echo $lang; ?>" class="nav-link">
                  <i class="nav-icon fa-solid fa-square-check"></i>
                  <p>
                    Approve Online Joiners
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="Upload-Files.php?lang=<? echo $lang; ?>" class="nav-link">
                  <i class="nav-icon fa-solid fa-file-arrow-up"></i>
                  <p>
                    Upload Files
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="Agendas.php?lang=<? echo $lang; ?>" class="nav-link">
                  <i class="nav-icon fa-solid fa-rectangle-list"></i>
                  <p>
                    Agendas
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="Reports.php?lang=<? echo $lang; ?>" class="nav-link">
                  <i class="nav-icon fa-solid fa-chart-column"></i>
                  <p>
                    Reports
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="Question-list.php?lang=<? echo $lang; ?>" class="nav-link">
                  <i class="nav-icon fa-solid fa fa-bars"></i>
                  <p>
                    Question-list
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin.php?lang=<? echo $lang; ?>" class="nav-link">
                  <i class="nav-icon fa-solid fa-user-tie"></i>
                  <p>
                    Admin
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="translations.php?lang=<? echo $lang; ?>" class="nav-link">
                  <i class="nav-icon fa-solid fa-language"></i>
                  <p>
                    Translations
                  </p>
                </a>
              </li>
              <? RegistrationStaff: ?>
              <li class="nav-item">
                <a href="physical/registration.php?lang=<? echo $lang; ?>" class="nav-link">
                  <i class="nav-icon fa-solid fa-language"></i>
                  <p>
                    Registration
                  </p>
                </a>
              </li> -->
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>
      <? FinishSidebar: ?>