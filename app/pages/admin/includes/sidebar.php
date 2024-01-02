 <!-- Main Sidebar Container -->
 <style>
     .active {
         background-color: #17a2b8 !important;
     }
 </style>
 <!-- Brand Logo -->
 <a href="<?= ROOT ?>/admin" class="brand-link">

     <span class="brand-text font-weight-light">
         <?php echo date("D d, M y"); ?></span>
 </a>

 <!-- Sidebar -->
 <div class="sidebar">
     <!-- Sidebar user panel (optional) -->
     <div class="user-panel mt-3 pb-3 mb-3 d-flex">
         <div class="image">
             <img src="<?= ROOT ?>/assets/img/wheel.png" class="img-circle elevation-2" alt="User Image" style="background: #fff" ;>
         </div>
         <div class="info">
             <a href="<?= ROOT ?>/admin" class="d-block">Admin</a>
         </div>
     </div>

     <!-- Sidebar Menu -->
     <nav class="mt-2">
         <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
             <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
             <li class="nav-item">
                 <a href="<?= ROOT ?>/admin/dashboard" class="nav-link <?php echo ($section == 'dashboard') ? 'active' : '' ?>">
                     <i class="nav-icon fas fa-tachometer-alt"></i>
                     <p>
                         Home
                     </p>
                 </a>
             </li>

             <li class="nav-item">
                 <a href="<?= ROOT ?>/admin/users?page=users" class="nav-link 
                            <?php
                            echo ($section == 'users') ? 'active' : '';
                            ?>
                            ">
                     <i class="nav-icon fas fa-users"></i>
                     <p>
                         Users
                     </p>
                 </a>
             </li>

    <li class="nav-item">
            <a href="" class="nav-link  ">
   <i class="nav-icon fas fa-calendar"></i>
      <p>  Schedules  </p>
   </a>
<!-- Submenus -->
 <ul class="nav nav-treeview">
 <li class="nav-item">
 <a href="<?= ROOT ?>/admin/schedule?page=schedule" class="nav-link 
       <?php  echo ($section == 'schedule') ? 'active' : '';  ?> ">
       <i class="nav-icon fas fa-calendar-day"></i>
               <p>
                Schedules
                     </p>
                 </a>
             </li>
 <li class="nav-item">
 <a href="<?= ROOT ?>/admin/schedule_payment?page=schedule_payment" class="nav-link 
       <?php  echo ($section == 'schedule_payment') ? 'active' : '';  ?> ">
       <i class="nav-icon fas fa-dollar-sign"></i>
               <p>
                Schedule Payment
                     </p>
                 </a>
             </li>
     </ul>
   </li>


       
             <li class="nav-item">
                 <a href="<?= ROOT ?>/admin/bus_route?page=bus_route" class="nav-link     
                             <?php
                                echo ($section == 'bus_route') ? 'active' : '';
                                ?>">
                     <i class="nav-icon fas fa-route"></i>
                     <p>
                         bus_routes
                     </p>
                 </a>
             </li>

             </li>




             <li class="nav-item">
                 <a href="<?= ROOT ?>/admin/payment?page=payment" class="nav-link  
                                <?php
                                echo ($section == 'payment') ? 'active' : '';
                                ?>">
                     <i class="nav-icon fas fa-dollar-sign"></i>
                     <p>
                         Payments
                     </p>
                 </a>
             </li>

             <li class="nav-item">
                 <a href="<?= ROOT ?>/admin/search?page=search" class="nav-link   
                               <?php
                                echo ($section == 'search') ? 'active' : '';
                                ?>">
                     <i class="nav-icon fas fa-search"></i>
                     <p>
                         Search
                     </p>
                 </a>
             </li>



             <li class="nav-item">
                 <a href="<?= ROOT ?>/admin/report?page=report" class="nav-link  
                                <?php
                                echo ($section == 'report') ? 'active' : '';
                                ?>">
                     <i class="nav-icon fas fa-file-pdf"></i>
                     <p>
                         Report
                     </p>
                 </a>

             </li>




             <li class="nav-item">
                 <a href="<?= ROOT ?>/admin/logout?page=logout" class="nav-link">
                     <i class="nav-icon fas fa-power-off"></i>
                     <p>
                         Logout
                     </p>
                 </a>
         </ul>
     </nav>
     <!-- /.sidebar-menu -->
 </div>
 <!-- /.sidebar -->