<!--Navbar starts here-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="d-lg-none" style="width: 100%;">
        <div class="row align-items-center">
            <div class="col-5 col-sm-6 col-md-3">
                <a href="/home">
                    <img class="img-fluid" src="/gallery/logo.png" alt="Ma-ma logo">
                </a>
            </div>
            <form class="col-md-6 d-none d-md-block">
                <div class="row justify-content-center pt-2 px-2">
                    <div class="col-12 col-sm-9 col-md-7">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                    </div>
                    <div class="col-sm-3 col-md-5 d-none d-sm-block text-center">
                        <button class="btn p-sm-6" id="btn-customized" type="submit">Search <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg></button>
                    </div>
                </div>
            </form>
            <div class="col-5 col-sm-3 col-md-2  ">
                <?php
                if ($_SESSION['ADMIN'] == 2) { ?>
                    <!-- If user an admin -->
                    <div class="d-flex justify-content-evenly col-12">
                        <a href="#" id="icon-hover"><i class="far fa-heart fa-2x"></i></a>
                        <a href="/admin/dashboard" id="icon-hover"><i class="far fa-user fa-2x"></i></a>
                        <a href="checkout/cart" id="icon-hover">
                            <i class="fab fa-opencart fa-2x"></i>
                            <span class="badge rounded-pill badge-notification bg-warning" style="position: static;">
                                <?php
                                if (isset($_SESSION['cart'])) {
                                    $count  = count($_SESSION['cart']);
                                    echo $count;
                                } else {
                                    echo "0";
                                }
                                ?>
                            </span>
                        </a>
                    </div>
                <?php } else if ($_SESSION['ADMIN'] == 1) { ?>
                    <!-- If user a customer -->
                    <div class="d-flex justify-content-evenly col-12">
                        <a href="#" id="icon-hover">
                            <i class="far fa-heart fa-2x"></i>
                        </a>
                        <a href="/account/profile-account.php" id="icon-hover">
                            <i class="far fa-user fa-2x"></i>
                            <span class="badge rounded-pill badge-notification bg-warning" style="position: static;">0</span>
                        </a>
                        <a href="checkout/cart" id="icon-hover">
                            <i class="fab fa-opencart fa-2x"></i>
                            <span class="badge rounded-pill badge-notification bg-warning" style="position: static;">
                                <?php
                                if (isset($_SESSION['cart'])) {
                                    $count  = count($_SESSION['cart']);
                                    echo $count;
                                } else {
                                    echo "0";
                                }
                                ?>
                            </span>
                        </a>
                    </div>
                <?php } else { ?>
                    <!-- If no user is logged in -->
                    <div class="d-flex justify-content-evenly col-12">
                        <a href="#" id="icon-hover">
                            <i class="far fa-heart fa-2x"></i>
                        </a>
                        <a href="/login/login" id="icon-hover">
                            <i class="far fa-user fa-2x"></i>
                        </a>
                        <a href="checkout/cart" id="icon-hover">
                            <i class="fab fa-opencart fa-2x"></i>
                            <span class="badge rounded-pill badge-notification bg-warning" style="position: static;">
                                <?php
                                if (isset($_SESSION['cart'])) {
                                    $count  = count($_SESSION['cart']);
                                    echo $count;
                                } else {
                                    echo "0";
                                }
                                ?>
                            </span>
                        </a>
                    </div>
                <?php } ?>
            </div>

            <div class="col-2 col-sm-3 col-md-1   text-center">
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars theme-color"></i>
                </button>
            </div>

        </div>
    </div>


    <div class="collapse navbar-collapse px-2" id="navbarTogglerDemo02">
        <ul class="navbar-nav justify-content-around col-12">

            <?php
            $resultTablecategory = mysqli_query($_conn, "SELECT * FROM CATEGORY WHERE VISIBLE = 1 ORDER BY SEQUENCE ASC");
            $resultTablecategoryDropdown = mysqli_query($_conn, "SELECT * FROM CATEGORY WHERE VISIBLE = 2 ORDER BY SEQUENCE ASC");

            //MENU OPTION
            if (mysqli_num_rows($resultTablecategoryDropdown) > 0) {
                $ctd = 0;
                while ($rowTablecategoryDropdown = mysqli_fetch_assoc($resultTablecategoryDropdown)) {
                    $ctd = $ctd + 1;
            ?>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link fs-custom-navbar dropdown-toggle" id="dropdownMenuLink" data-mdb-boundary="scrollParent" data-mdb-toggle="dropdown" aria-expanded="false">
                            <?php echo $rowTablecategoryDropdown['TITLE'] ?>
                        </a>
                        <?php
                        if ($rowTablecategoryDropdown['CODE'] == 'AAM') { ?>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="/product/<?php echo $rowTablecategoryDropdown['LINK'] ?>">GRANDE</a></li>
                                <li><a class="dropdown-item" href="/product/almofadas-de-amamentacao-pequeno">PEQUENO</a></li>
                            </ul>
                        <?php
                        }
                        ?>
                    </li>
            <?php
                }
            }
            //MENU OPTION

            mysqli_free_result($resultTablecategoryDropdown);
            ?>

            <?php
            if (mysqli_num_rows($resultTablecategory) > 0) {
                $ctd = 0;
                while ($rowTablecategory = mysqli_fetch_assoc($resultTablecategory)) {
                    $ctd = $ctd + 1;
            ?>
                    <li class="nav-item"><a href="/product/<?php echo $rowTablecategory['LINK'] ?>" class="nav-link fs-custom-navbar"> <?php echo $rowTablecategory['TITLE'] ?></a></li>
            <?php
                }
            }
            mysqli_free_result($resultTablecategory);
            ?>
        </ul>
    </div>
    <form class="d-md-none" style="width: 100%;">
        <div class="row justify-content-center pt-2 px-2">
            <div class="col-12 col-sm-9 col-md-10">
                <input class="form-control" type="search" placeholder="Search" aria-label="Search">
            </div>
            <div class="col-sm-3 col-md-2 d-none d-sm-block text-center">
                <button class="btn p-sm-6" id="btn-customized" type="submit">Search <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg></button>
            </div>
        </div>
    </form>
</nav>
<!--Navbar ends here-->