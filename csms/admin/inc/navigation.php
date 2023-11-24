<style>
  [class*="sidebar-dark-"] .nav-treeview > .nav-item > .nav-link.active, [class*="sidebar-dark-"] .nav-treeview > .nav-item > .nav-link.active:hover {
      color: #000000 !important;
  }
</style>
<!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary navbar-dark elevation-4 sidebar-no-expand">
        <!-- Brand Logo -->
        <a href="<?php echo base_url ?>admin" class="brand-link bg-primary text-sm">
        <img src="<?php echo validate_image($_settings->info('logo'))?>" alt="Store Logo" class="brand-image img-circle elevation-3" style="opacity: .8;width: 1.5rem;height: 1.5rem;max-height: unset">
        <span class="brand-text font-weight-light"><?php echo $_settings->info('short_name') ?></span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar os-host os-theme-dark os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
          <div class="os-resize-observer-host observed">
            <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
          </div>
          <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer"></div>
          </div>
          <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
          <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
              <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                <!-- Sidebar user panel (optional) -->
                <div class="clearfix"></div>
                <!-- Sidebar Menu -->
                <nav class="mt-1">
                   <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item dropdown">
                      <a href="./" class="nav-link nav-home">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                          Dashboard
                        </p>
                      </a>
                    </li> 
                    <li class="nav-item dropdown">
                      <a href="./?page=models" class="nav-link nav-models">
                        <i class="nav-icon fas fa-car"></i>
                        <p>
                          Car Models
                        </p>
                      </a>
                    </li> 
                    <li class="nav-item">
                      <a href="./?page=inventory" class="nav-link tree-item nav-inventory">
                        <i class="fas fa-tags nav-icon"></i>
                          <p>Car Inventory</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./?page=inventory/transactions" class="nav-link tree-item nav-inventory_transactions">
                        <i class="fa fa-file-invoice nav-icon"></i>
                          <p>Transactions</p>
                      </a>
                    </li>
                    <?php if($_settings->userdata('levelID') == 2): ?>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                          Master List
                          <i class="right fas fa-angle-left"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                          <a href="./?page=manufacturers" class="nav-link tree-item nav-manufacturers">
                            <i class="far fa-copyright nav-icon"></i>
                            <p>Manufacturers</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="./?page=carType" class="nav-link tree-item nav-carType">
                            <i class="fa fa-list nav-icon"></i>
                            <p>Car Types</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="./?page=reports" class="nav-link nav-reports">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                          Monthly Sales Report 
                        </p>
                      </a>
                    </li> 
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-user_list">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                          User List
                        </p>
                      </a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=customer/list" class="nav-link nav-customer_list">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                          Customer List
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="http://localhost/CARnival/" class="nav-link nav-carnival">
                        <i class="nav-icon fas fas fa-tachometer-alt"></i>
                        <p>
                          CARnival Site
                        </p>
                      </a>
                    </li>
                  </ul>
                </nav>
                <!-- /.sidebar-menu -->
              </div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar-corner"></div>
        </div>
        <!-- /.sidebar -->
      </aside>
      <script>
    $(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
      page = page.replace(/\//g,'_');
      console.log(page, $('.nav-link.nav-'+page)[0])
      if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
        if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).addClass('active')
          $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
        }
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

      }
      $('.nav-link.active').addClass('bg-gradient-primary')
    })
  </script>