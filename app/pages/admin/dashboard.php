<?php
if (!isset($file_access)) die("Direct File Access Denied");
?>
<div class="content">
    <h5 class="mt-4 mb-2">Hi, <?php echo $fullname ?></h5>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-danger">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>

                <div class="info-box-content">
                <?php 
           //   $stmt = $pdo->query('SELECT * FROM users');
            //  $rows = $stmt->fetchAll();
           //   $num_rows = count($rows);
           //   echo $num_rows ;
           $query = "select count(id) as num from users ";
           $res = query_row($query);
              ?> 
                    <span class="info-box-text">users</span>
                    <span class="info-box-number">
                    <?=$res['num'] ?? 0?>
                </span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <?php //readonly  
                    ?>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
       
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-secondary">
                <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>

                <div class="info-box-content">
                <?php
                $query = "select count(id) as num from schedule ";
                $res = query_row($query);
                      ?>
                    <span class="info-box-text">Schedules</span>
                    <span class="info-box-number">
                    <?=$res['num'] ?? 0?>
                        </span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <?php //readonly  
                    ?>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fa fa-dollar-sign"></i></span>

                <div class="info-box-content">
                <?php
               $query = "SELECT SUM(total_amount) AS price FROM bus_booking";
                $res = query_row($query);
                $roundedPrice = ceil($res['price'] ?? 0);
                      ?>
                    <span class="info-box-text">Payments</span>
                    <span class="info-box-number">$<?= $roundedPrice ?></span>
                      
                         </span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>

                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <!-- /.col-md-6 -->
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-primary">
                <span class="info-box-icon"><i class="fa fa-route"></i></span>

                <div class="info-box-content">
                <?php 
           $query = "select count(id) as num from bus_route ";
           $res = query_row($query);
              ?>
                  
                    <span class="info-box-text">Bus Routes</span>
                    <span class="info-box-number"> 
                         <?=$res['num'] ?? 0?>
                        </span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 50%"></div>
                    </div>

                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
   

   
        
    </div>
    <!-- /.row -->


</div>
<!-- /.container-fluid -->
</div>
<!-- /.content -->
<!-- /.col -->
</div>
<!-- /.row -->

</div>