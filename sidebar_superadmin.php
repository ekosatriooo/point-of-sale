 <!-- Sidebar Menu -->
 <nav class="mt-2">
     <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         <li class="nav-item">
             <a href="../home_superadmin" class="nav-link <?php if ($halaman == 'home_superadmin') { echo 'active';                # code...
             }?>">
                 <i class="nav-icon fas fa-home"></i>
                 <p>
                     Beranda
                 </p>
             </a>
         </li>
         <li class="nav-item">
             <a href="../data_user_superadmin" class=" nav-link <?php if ($halaman == 'data_user_superadmin') { echo 'active';
             }?>">
                 <i class="nav-icon fas fa-users"></i>
                 <p>
                     Data Users
                 </p>
             </a>
         </li>
         <li class="nav-item">
             <a href="../supplier_superadmin" class=" nav-link <?php if ($halaman == 'data_supplier_superadmin') { echo 'active';
             }?>">
                 <i class="nav-icon fas fa-shipping-fast"></i>
                 <p>
                     Data Supplier
                 </p>
             </a>
         </li>
         <li class="nav-item">
             <a href="../data_barang_superadmin" class=" nav-link <?php if ($halaman == 'data_barang_superadmin') { echo 'active';
             }?>">
                 <i class="nav-icon fas fa-dolly"></i>
                 <p>
                     Data Barang
                 </p>
             </a>
         </li>
         <li class="nav-item">
             <a href="../nota_beli_superadmin" class=" nav-link <?php if ($halaman == 'nota_beli_superadmin') { echo 'active';
             }?>">
                 <i class="nav-icon fas fa-file-invoice-dollar"></i>
                 <p>
                     Data Nota Beli
                 </p>
             </a>
         </li>
         <li class="nav-item">
             <a href="../nota_jual_superadmin" class=" nav-link <?php if ($halaman == 'nota_jual_superadmin') { echo 'active';
             }?>">
                 <i class="nav-icon fas fa-file-invoice"></i>
                 <p>
                     Data Nota Jual
                 </p>
             </a>
         </li>
         <li class="nav-item">
             <a href="../laporan_pembelian_superadmin" class=" nav-link <?php if ($halaman == 'laporan_pembelian_superadmin') { echo 'active';
             }?>">
                 <i class="nav-icon fas fa-chart-bar"></i>
                 <p>
                     Laporan Pembelian
                 </p>
             </a>
         </li>
         <li class="nav-item">
             <a href="../laporan_penjualan_superadmin" class=" nav-link <?php if ($halaman == 'laporan_penjualan_superadmin') { echo 'active';
             }?>">
                 <i class="nav-icon fas fa-chart-line"></i>
                 <p>
                     Laporan Penjualan
                 </p>
             </a>
         </li>
         <li class="nav-item">
             <a href="../laporan_labarugi_superadmin" class=" nav-link <?php if ($halaman == 'laporan_labarugi_superadmin') { echo 'active';
             }?>">
                 <i class="nav-icon fas fa-balance-scale"></i>
                 <p>
                     Laporan Laba Rugi
                 </p>
             </a>
         </li>
         <li class="nav-item">
             <a href="../ganti_pass_superadmin" class=" nav-link <?php if ($halaman == 'ganti_pw') { echo 'active';
             }?>">
                 <i class="nav-icon fas fa-lock"></i>
                 <p>
                     Ganti Password
                 </p>
             </a>
         </li>
         <li class="nav-item">
             <a href="../logout.php" class=" nav-link">
                 <i class="nav-icon fas fa-sign-out-alt"></i>
                 <p>
                     Keluar
                 </p>
             </a>
         </li>
 </nav>