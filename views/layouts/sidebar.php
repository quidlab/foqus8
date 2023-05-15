      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->

        <a href="#" class="brand-link logo-switch">
          <img src="<?= assets('/assets/img/FOQUS_cam150.png') ?>" alt="FoQus Logo Small" class="brand-image-xl logo-xs">
          <img src="<?= assets('/assets/img/FOQUS_logo_633x144.png') ?>" alt="FoQus Logo Large" class="brand-image-xs logo-xl" style="left: 12px">
          <!--  <span class="brand-text font-weight-light">FoQus</span> -->
        </a>

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

              <li class="nav-item">
                <a href="/admin/admin-tools" class="nav-link">
                  <i class="nav-icon fa-solid fa-user-gear"></i>
                  <p>
                    <?= __('admin-tools') ?>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/manage-company" class="nav-link">
                  <i class="nav-icon fa-solid fa-pen-to-square"></i>
                  <p>
                    <?= __('manage-company') ?>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/system-constants" class="nav-link">
                  <i class="nav-icon fa-solid fa-pen-to-square"></i>
                  <p>
                    <?= __('system-constants') ?>
                  </p>
                </a>
              </li>
              <!-- agendas -->
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fa-solid fa-list-check"></i>
                  <p>
                    <?= __('maintain-agendas') ?>
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="/admin/agendas/view" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= __('list-agendas') ?></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/admin/agendas/create" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= __('create-agenda') ?></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/admin/agendas/create2" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= __('create-agenda') ?> 2</p>
                    </a>
                  </li>
                </ul>
              </li>
              <!-- users -->
              <li class="nav-item">
                <a href="/admin/users" class="nav-link">
                  <i class="nav-icon fa-solid fa-users"></i>
                  <p>
                    <?= __('users') ?>
                  </p>
                </a>
              </li>
              <!-- presenters -->
              <li class="nav-item">
                <a href="/admin/presenters" class="nav-link">
                  <i class="nav-icon fa-solid fa-users"></i>
                  <p>
                    <?= __('presenters') ?>
                  </p>
                </a>
              </li>
              <!-- translations -->
              <li class="nav-item">
                <a href="/admin/translations" class="nav-link">
                  <i class="nav-icon fa-solid fa-pen-to-square"></i>
                  <p>
                    <?= __('translations') ?>
                  </p>
                </a>
              </li>
              <!-- uploadFiles -->
              <li class="nav-item">
                <a href="/admin/upload-files" class="nav-link">
                  <i class="nav-icon fa-solid fa-pen-to-square"></i>
                  <p>
                    <?= __('upload-files') ?>
                  </p>
                </a>
              </li>
              <!-- stakeholders -->
              <li class="nav-item">
                <a href="/admin/stakeholders" class="nav-link">
                  <i class="nav-icon fa-solid fa-pen-to-square"></i>
                  <p>
                    <?= __('stakeholders') ?>
                  </p>
                </a>
              </li>
              <!-- proxyNames -->
              <li class="nav-item">
                <a href="/admin/proxy-names" class="nav-link">
                  <i class="nav-icon fa-solid fa-pen-to-square"></i>
                  <p>
                    <?= __('proxy-names') ?>
                  </p>
                </a>
              </li>
              <!-- proxyNames -->
              <li class="nav-item">
                <a href="/admin/coupons" class="nav-link">
                  <i class="nav-icon fa-solid fa-pen-to-square"></i>
                  <p>
                    <?= __('coupons') ?>
                  </p>
                </a>
              </li>
              <!-- proxyNames -->
              <li class="nav-item">
                <a href="/admin/import-shareholders" class="nav-link">
                  <i class="nav-icon fa-solid fa-pen-to-square"></i>
                  <p>
                    <?= __('import-shareholders') ?>
                  </p>
                </a>
              </li>
              <!-- egmActivation -->
              <li class="nav-item">
                <a href="/admin/egm-activation" class="nav-link">
                  <i class="nav-icon fa-solid fa-pen-to-square"></i>
                  <p>
                    <?= __('egm-activation') ?>
                  </p>
                </a>
              </li>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>