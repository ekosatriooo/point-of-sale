 <!-- Sidebar Menu -->
 <nav class="mt-2">
     <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         <li class="nav-item">
             <a href="../home_kasir" class="nav-link <?php if ($halaman == 'home_kasir') { echo 'active';                # code...
             }?>">
                 <i class="nav-icon fas fa-home"></i>
                 <p>
                     Beranda
                 </p>
             </a>
         </li>
         <li class="nav-item">
             <a href="../nota_beli_kasir" class=" nav-link <?php if ($halaman == 'nota_beli_kasir') { echo 'active';
             }?>">
                 <i class="nav-icon fas fa-file-invoice-dollar"></i>
                 <p>
                     Data Nota Beli
                 </p>
             </a>
         </li>
         <li class="nav-item">
             <a href="../nota_jual_kasir" class=" nav-link <?php if ($halaman == 'nota_jual_kasir') { echo 'active';
             }?>">
                 <i class="nav-icon fas fa-file-invoice"></i>
                 <p>
                     Data Nota Jual
                 </p>
             </a>
         </li>
         <li class="nav-item">
             <a href="../ganti_pass_kasir" class=" nav-link <?php if ($halaman == 'ganti_pw') { echo 'active';
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