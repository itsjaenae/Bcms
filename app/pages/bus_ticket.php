<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title>Bus Ticket- <?= APP_NAME ?></title>
  <style>
    .bus_text {
      color: #fff !important;
      font-size: 1.3rem;
      margin-top: -35px;
      font-weight: bold;
      padding: 2px;
      background: rgba(0, 0, 0, 0.1);
      width: 350px;
      text-align: center;
    }
  </style>
</head>
<?php include  '../app/includes/header.php' ?>

<body>

  <style>
    .bus_text {
      color: #fff !important;
      font-size: 1.3rem;
      margin-top: -35px;
      font-weight: bold;
      padding: 2px;
      background: rgba(0, 0, 0, 0.1);
      width: 350px;
      text-align: center;
    }

    #tm-section-1 {
      background-image: url("./assets/img/bus1.jpeg");
      height: 515px;
    }

    .container {
      position: relative;
    }

    .tm-form-element {
      width: 450px;
    }

    .parent {
      width: 500px;
      height: auto;
      overflow: hidden;
      position: relative;
      margin: 0 auto;
      left: 0;
      margin-left: 0;

    }


    .parent {
      position: relative;
      z-index: 1;
      background: #fff;
      display: block;
    }

    .icon {
      float: right;

      top: 10px;
      left: 15px;
      position: absolute;
      color: #361999;
      /* position: absolute;
	top: 10px;
	left: 15px; */
    }

    .img-right {
      margin-left: 0;
      margin-right: 70%;

    }

    .label_text {
      padding-left: 45px;
      font-weight: 500;
      color: #000;
    }

    select {
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      padding: 25px;
      text-indent: 38px;
      font-weight: 500;
      color: #000 !important;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
      color: #361999 !important;
      opacity: 0;
      display: block;
      background-repeat: no-repeat;
      width: 25px;
      height: 25px;
      border-width: thin
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
      position: absolute;
      left: 3%;
    }

    input::-webkit-datetime-edit-fields-wrapper {
      position: relative;

    }

    input::-webkit-datetime-edit {
      position: relative;

    }

    input[type="date"]:before {
      content: attr(placeholder) !important;
      margin-right: 0.5em;
    }

    input[type="date"]:focus:before,
    input[type="date"]:valid:before {
      content: "";
    }

    @media (max-width: 767px) {
      .parent {
        margin: 0;
      }

    }
  </style>




  <div class="tm-section tm-bg-img" id="tm-section-1">
    <div class="container">

      <div class="parent ">
        <div class="row">
          <form action="<?= ROOT ?>/booking_action" method="post">
            <div class="card-body p-4 p-md-5">
              <div class="rows">
                <div class="form-group tm-form-element tm-form-element-100">
                  <i class="fa fa-map-marker fa-2x tm-form-element-icon"></i>
                  <select class="form-control tm-select" name="departure" required id="departureRoute" onchange="getDestinationRoutes()">
                    <option value="Default" disabled selected>Departure Name</option>
                    <?php
                    $query = "SELECT id, departure FROM bus_route WHERE status= 1";
                    $rows = dbConnect($query);
                    if (!empty($rows)) :
                      foreach ($rows as $row) :
                    ?>
                        <option <?= old_select('departure', $row['id']) ?> value="<?= $row['departure'] ?>"><?= $row['departure'] ?></option>
                    <?php
                      endforeach;
                    endif;
                    ?>
                  </select>
                </div>

                <div class=" form-group tm-form-element tm-form-element-100">
                  <i class="fa fa-map-marker fa-2x tm-form-element-icon icon"></i>
                  <select class="form-control tm-select" name="destination" required id="destinationRoute">
                    <option class="label_text" value="Default" disabled selected>Route</option>
                    <!-- Options will be dynamically loaded here through AJAX -->
                  </select>
                </div>

              </div>
              <div class="rows">
                <div class="form-group tm-form-element tm-form-element-100">
                  <i class="fa fa-reply-all fa-2x tm-form-element-icon icon"></i>
                  <select name="j_type" class="form-control tm-select " required id="item_id">
                    <option value="Default" disabled selected>Journey Type</option>
                    <option value='1|single'>Single</option>
                    <option value='2|return'>Return</option>
                  </select>
                </div>
                <input type="hidden" name="type" id="hide_type">

                <div class="form-group tm-form-element tm-form-element-50">
                  <i class="fa fa-calendar fa-2x tm-form-element-icon icon"></i>
                  <input name="date_of_depart" type="date" onchange="check(this.value)" class="form-control label_text" id="date" required placeholder="Depart Date">
                </div>
                <div class="form-group tm-form-element tm-form-element-50">
                  <i class="fa fa-calendar fa-2x tm-form-element-icon icon"></i>
                  <input name="date_of_return" type="date" onchange="check(this.value)" class="form-control label_text" id="date" placeholder="Return Date (optional)">
                </div>




                <div class="form-group tm-form-element tm-form-element-2">
                  <?php if (isset($_SESSION['USER'])) { ?>
                    <button type="submit" class="btn btn-primary tm-btn-search" name="submit">
                      Proceed
                    </button>
                  <?php } else { ?>
                    <a class="btn btn-primary tm-btn-search" href="<?= ROOT ?>/sign_in">
                      Proceed </a>
                  <?php } ?>

                </div>
              </div>
            </div>
          </form>


        </div>
      </div>
    </div>

  </div>





  <div class=" tm-position-relative" style="margin-top: 3rem; margin-bottom: 4rem">
    <div class="container" style="margin-top: 3rem;">
      <a href="bus_ticket">
        <h2 class="center tm-text tm_head">Top Bus Destinations</h2>
      </a>
      <?php
      $query = "select * from bus_route limit 8";
      $rows = dbConnect($query);   ?>

      <div class="row ">
        <?php if (!empty($rows)) : ?>
          <?php foreach ($rows as $row) :  ?>
            <div class="col-xs-12 col-sm-6 tm-article">
              <div class="box_box" style="margin-bottom:  -1rem;">
                <p style="font-weight: 700;font-size: 0.9rem; color: #333">
                  Train from <?= $row['departure'] ?>
                  to
                  <?= $row['destination'] ?>
                </P>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

    </div>
  </div>


  <div class=" tm-bg-gray image_wrapper" style="padding: 20px;">
    <div class="containers">
      <h2 class="center tm-text tm_head" style="font-size: 0.9rem;">WE ACCEPT</h2>
      <div class="row">
        <div class="image_container">
          <div class="image_item">
            <img class="img_item" src="./assets/img/alipay.png" alt="">
            <img class="img_item" src="./assets/img/visa.png" alt="">
            <img class="img_item" src="./assets/img/unionpay.png" alt="">
            <img class="img_item" src="./assets/img/shopee.png" alt="">
            <img class="img_item" src="./assets/img/setel.png" alt="">
            <img class="img_item" src="./assets/img/rhb.png" alt="">
            <img class="img_item" src="./assets/img/paypal.png" alt="">
            <img class="img_item" src="./assets/img/mcard.png" alt="">
            <img class="img_item" src="./assets/img/maybank2u.png" alt="">
            <img class="img_item" src="./assets/img/grap-pay.png" alt="">
            <img class="img_item" src="./assets/img/boost.png" alt="">
          </div>

        </div>
      </div>
    </div>
  </div>

  <?php include  '../app/includes/footer.php' ?>
  <script>
    function check(val) {
      val = new Date(val);
      var age = (Date.now() - val) / 31557600000;
      var formDate = document.getElementById('date');
      if (age > 0) {
        alert("Past/Current Date not allowed");
        formDate.value = "";
        return false;
      }
    }
  </script>


  <script>
    function getDestinationRoutes() {
      var departureRoute = $('#departureRoute').val();
      $.ajax({
        type: 'POST',
        url: '<?= ROOT ?>/route',
        data: {
          departureRoute: departureRoute
        },
        success: function(data) {
          $('#destinationRoute').html(data);
        }
      });
    }
  </script>





</body>

</html>