<!--Header starts here-->
<div class="container-fluid p-0 d-none d-lg-block">
    <div class="row">
        <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <a href="/home">
                <img class="img-fluid" src="/gallery/logo.png" alt="Ma-ma logo">
            </a>
        </div>
        <form class="col-sm-6 col-md-7 col-lg-6 col-xl-7 mt-3 d-none d-sm-block">
            <div class="row justify-content-center">
                <div class="col-sm-9">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                </div>
                <div class="col-sm-3">
                    <button class="btn p-sm-6" id="btn-customized" type="submit">Search
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </form>
        <div class="col-6 col-sm-3 col-md-2 col-lg-3 col-xl-2 mt-3">
            <?php
            if ($_SESSION['ADMIN'] == 2) { ?>
                <!-- If user an admin -->
                <div class="d-flex justify-content-evenly col-12">
                    <a href="#" id="icon-hover"><i class="far fa-heart fa-2x"></i></a>
                    <a href="/admin/dashboard" id="icon-hover"><i class="far fa-user fa-2x"></i></a>
                    <a href="/checkout/cart" id="icon-hover">
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
                    <a href="/checkout/cart" id="icon-hover">
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
                    <a href="/checkout/cart" id="icon-hover">
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
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!--Header starts here-->