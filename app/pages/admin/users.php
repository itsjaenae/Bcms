<?php
if (!isset($file_access)) die("Direct File Access Denied");
$source = 'users';
$me = "?page=$source";
if (isset($_GET['status'], $_GET['id'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    if ($status == 0) {
        $status = 0;
    } else {
        $status = 1;
    }
    $query = ("UPDATE users SET status = '$status' WHERE id = '$id'");
    $queryn = dbConnect($query);
    echo "<script>alert('Action completed!');window.location.href='users$me';</script>";
}
?>
   
<div class="content">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-success">
                        <div class="card-header"  style= "background-color:#17a2b8 ">
                            <h3 class="card-title">
                                Registered Users</h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">

                                <table style="width: 100%;" id="example1" style="align-items: stretch;"
                                    class="table table-hover table-bordered">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                          	$query = "select * from users order by id DESC ";
                                              $rows = dbConnect($query);
                                              $sn = 0;
                                              ?>

                                              <?php if(!empty($rows)):?>
                                                  <?php foreach($rows as $row):  ?>
                                                    <tr>
                                                    <td><?php echo ++$sn; ?></td>
                                            <td><?php echo ($row['username']); ?></td>
                                            <td><?php echo ($row['email']); ?></td>
                                            <td><?php echo ($row['phone']); ?></td>
                                            <td>
					                    <img src="<?=get_image($row['image'])?>" style="width: 100px;height: 100px;object-fit: cover;">
                                               </td>
                                            <td>
                                                <?php
                                                    if ($row['status'] == 0) {
                                                    ?>
                                                <a href="<?= ROOT ?>/admin/users?page=users&status=1&id=<?php echo $row['id']; ?>">
                                                    <button
                                                        onclick="return confirm('You are about allowing this user be able to login his/her account.')"
                                                        type="submit" class="btn btn-success">
                                                        Enable Account
                                                    </button></a>
                                                <?php } else { ?>
                                                <a href="<?= ROOT ?>/admin/users?page=users&status=0&id=<?php echo $row['id']; ?>">
                                                    <button
                                                        onclick="return confirm('You are about denying this user access to  his/her account.')"
                                                        type="submit" class="btn btn-danger">
                                                        Disable Account
                                                    </button></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                                    <?php endforeach;?>
		                                   <?php endif;?> 
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
</div>
</div>
</section>
</div>




                          


