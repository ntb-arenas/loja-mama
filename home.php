<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
include_once  './login/connect_DB.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ma-Ma </title>
  <!-- stylesheet ---------------------------->
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.css" rel="stylesheet" />
  <!-- page icon --------------------------------->
  <link rel="shortcut icon" href="gallery/logo.png">
  <!-- fonts ------------------------------------------>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  </style>
</head>

<body>
  <main>
    <?php include_once '/components/header.php'; ?>
    <?php include_once '/components/navbar.php'; ?>

    <!-- Page cover -->
    <img class="img-fluid mx-auto d-none d-md-block" src="./gallery/maincover.jpg" alt="">
    <img class="img-fluid mx-auto d-none d-sm-block d-md-none" src="./gallery/maincovertabletsize.jpg" alt="">
    <img class="img-fluid mx-auto d-sm-none" src="./gallery/maincovermobilesize.jpg" alt="">
    <!-- Page cover -->

    <div class="container-fluid p-0 border-bottom">
      <h3 class="text-center m-3 cover-message-fs" style="color: rgb(93, 93, 93);">Com a Ma-Ma, a vida da mãe e do seu bebé nunca foi tão fácil. Descubra os nossos produtos!</h3>
    </div>

    <!-- Product Page -->

    <!-- Desktop UI -->
    <div class="container px-lg-5 d-none d-sm-block">
      <div class="row mx-lg n5">
        <?php
        $result = mysqli_query($_conn, "SELECT `TITLE`,`IMAGE_URL`,`LINK` FROM category WHERE `VISIBLE` = 1 ORDER BY `SEQUENCE` ASC;");
        while ($row = mysqli_fetch_array($result)) { ?>
          <div class="col-6 col-sm-6 col-md-4 py-3 px-lg-3">
            <a href="/product/<?php echo $row["LINK"]; ?>">
              <div class="py-3 border h-100 hover-shadow">
                <img class="img-fluid" src="/gallery/<?php echo $row["IMAGE_URL"]; ?>" alt="">
                <h4 class="text-center card-message-fs"><?php echo $row["TITLE"]; ?></h4>
              </div>
            </a>
          </div>
        <?php
        } ?>
      </div>
    </div>
    <!-- Desktop UI -->

    <!-- Mobile UI -->
    <div class="container px-lg-5 d-block d-sm-none">
      <div class="row mx-lg-n5">
        <?php
        $result = mysqli_query($_conn, "SELECT `TITLE`,`IMAGE_URL`,`LINK` FROM category WHERE `VISIBLE` = 1 ORDER BY `SEQUENCE` ASC;");
        while ($row = mysqli_fetch_array($result)) { ?>
          <div class="col-6 col-sm-6 col-md-4 py-3 px-lg-3">
            <a href="/product/<?php echo $row["LINK"]; ?>" class="text-decoration-none" style="font-size: calc(0.5rem + .3vw); color: rgb(40, 40, 40);" role="button">
              <div class="border h-100">
                <img class="img-fluid" src="/gallery/<?php echo $row["IMAGE_URL"]; ?>" alt="">
                <div class="container-fluid p-0 h-100">
                  <h4 class="text-center card-message-fs"><?php echo $row["TITLE"]; ?></h4>
                </div>
              </div>
            </a>
          </div>
        <?php
        } ?>
      </div>
    </div>
    <!-- Mobile UI -->

    <!-- Carousel wrapper -->
    <div id="carouselId" class="carousel slide text-center carousel-dark mt-5 p-3" data-mdb-ride="carousel">
      <div class="carousel-inner" style="height: 20rem;">
        <?php
        $result = mysqli_query($_conn, "SELECT users.fNAME, users.lNAME, reviews.CODE, reviews.DESCRIPTION, reviews.IMAGE_URL FROM reviews JOIN users ON reviews.USER_ID = users.ID ORDER BY `reviews`.`CODE` ASC");
        while ($row = mysqli_fetch_array($result)) {
          echo ($row['CODE'] == '1') ? '
              <div class="carousel-item active">' : '<div class="carousel-item">';
          echo '
                <img class="rounded-circle shadow-1-strong mb-4" id="review-img" src="' . $row['IMAGE_URL'] . '" alt="avatar" style="width: 150px; height: 150px"/>
                <div class="row d-flex justify-content-center">
                  <div class="col-lg-8">
                    <h5 class="mb-3">' . $row['fNAME'] . " " . $row['lNAME'] . '</h5>
                    <p class="text-muted"><i class="fas fa-quote-left pe-2"></i>' . $row['DESCRIPTION'] . '</p>
                  </div>
                </div>
              </div>';
        } ?>
        <button class="carousel-control-prev" type="button" data-mdb-target="#carouselId" data-mdb-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-mdb-target="#carouselId" data-mdb-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
    <!-- Carousel wrapper -->
    <?php include_once './components/footer.php'; ?>
  </main>
</body>
<!-- <script src="./bootstrap/js/bootstrap.bundle.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>