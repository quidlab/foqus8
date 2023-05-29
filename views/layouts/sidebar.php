<?php

$adminLinks = [
  [
    'name' => 'dashboard',
    'path' => '/admin/dashboard',
    'icon' => '<i class="nav-icon fas fa-table-columns"></i>',
    'roles' => [1, 7]
  ],
  [
    'name' => 'admin-tools',
    'path' => '/admin/admin-tools',
    'icon' => '<i class="nav-icon fa-solid fa-user-gear"></i>',
    'roles' => [1, 7]
  ],
  [
    'name' => 'manage-company',
    'path' => '/admin/manage-company',
    'icon' => '<i class="nav-icon fa-solid fa-pen-to-square"></i>',
    'roles' => [1, 7]
  ],
  [
    'name' => 'system-constants',
    'path' => '/admin/system-constants',
    'icon' => '<i class="nav-icon fa-solid fa-pen-to-square"></i>',
    'roles' => [7]
  ],
  [
    'name' => 'users',
    'path' => '/admin/users',
    'icon' => '<i class="nav-icon fa-solid fa-users"></i>',
    'roles' => [1, 7]
  ],
  [
    'name' => 'maintain-agendas',
    'icon' => '<i class="nav-icon fa-solid fa-users"></i>',
    'roles' => [1, 7],
    'sublinks' => [
      [
        'name' => 'list-agendas',
        'path' => '/admin/agendas/view',
        'icon' => '<i class="far fa-circle nav-icon"></i>'
      ],
      [
        'name' => 'create-agenda',
        'path' => '/admin/agendas/create',
        'icon' => '<i class="far fa-circle nav-icon"></i>'
      ],
      [
        'name' => 'create-agenda 2',
        'path' => '/admin/agendas/create2',
        'icon' => '<i class="far fa-circle nav-icon"></i>'
      ],
    ]
  ],
  [
    'name' => 'presenters',
    'path' => '/admin/presenters',
    'icon' => '<i class="nav-icon fa-solid fa-users"></i>',
    'roles' => [1, 7]
  ],
  [
    'name' => 'translations',
    'path' => '/admin/translations',
    'icon' => '<i class="nav-icon fa-solid fa-pen-to-square"></i>',
    'roles' => [1, 7]
  ],
  [
    'name' => 'upload-files',
    'path' => '/admin/upload-files',
    'icon' => '<i class="nav-icon fa-solid fa-pen-to-square"></i>',
    'roles' => [1, 7]
  ],
  [
    'name' => 'stakeholders',
    'path' => '/admin/stakeholders',
    'icon' => '<i class="nav-icon fa-solid fa-pen-to-square"></i>',
    'roles' => [1, 7]
  ],
  [
    'name' => 'proxy-names',
    'path' => '/admin/proxy-names',
    'icon' => '<i class="nav-icon fa-solid fa-pen-to-square"></i>',
    'roles' => [1, 7]
  ],
  [
    'name' => 'coupons',
    'path' => '/admin/coupons',
    'icon' => '<i class="nav-icon fa-solid fa-pen-to-square"></i>',
    'roles' => [1, 7]
  ],
  [
    'name' => 'import-shareholders',
    'path' => '/admin/import-shareholders',
    'icon' => '<i class="nav-icon fa-solid fa-pen-to-square"></i>',
    'roles' => [1, 7]
  ],
  [
    'name' => 'egm-activation',
    'path' => '/admin/egm-activation',
    'icon' => '<i class="nav-icon fa-solid fa-pen-to-square"></i>',
    'roles' => [1, 7]
  ],
  [
    'name' => 'join-online-joiners',
    'path' => '/admin/join-online-joiners',
    'icon' => '<i class="nav-icon fa-solid fa-pen-to-square"></i>',
    'roles' => [1, 7]
  ],
  [
    'name' => 'reports',
    'path' => '/admin/reports',
    'icon' => '<i class="nav-icon fa-solid fa-pen-to-square"></i>',
    'roles' => [1, 7]
  ],
];

function can($link): bool
{
  $role = auth()->user?->{'role-id'};
  if (isset($link['roles']) && in_array($role, $link['roles'])) {
    return true;
  }
  return false;
}


?>
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
        <a href="/admin/profile" class="d-block"><? echo $_SESSION['uname']; ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


        <?php
        foreach ($adminLinks as $key => $link) {

          if (!can($link)) {
            continue;
          }

          if (isset($link['sublinks'])) {
            $subs = '<ul class="nav nav-treeview">';
            foreach ($link['sublinks'] as $key => $sublink) {
              $subs .= '<li class="nav-item">
                <a href="' . $sublink['path'] . '" class="nav-link">
                ' . $sublink['icon'] . '
                  <p>' . __($sublink['name']) . '</p>
                </a>
              </li>';
            }
            $subs .= '</ul>';
            echo '
              <li class="nav-item">
              <a href="#" class="nav-link">
              ' . $link['icon'] . '
                <p>
                  ' . __($link['name']) . '
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              ' . $subs . '
            </li>
              ';
          } else {
            echo '
                    <li class="nav-item">
                    <a href="' . $link['path'] . '" class="nav-link">
                    ' . $link['icon'] . '
                      <p>
                        ' . __($link['name']) . '
                      </p>
                    </a>
                  </li>
                    ';
          }
        }

        ?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>