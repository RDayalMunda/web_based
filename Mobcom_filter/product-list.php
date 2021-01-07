<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MobCOM</title>

    <!-- Bootstrap 4 CSS -->

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/customCSS.css">

    <!-- Font Awesome CDN -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body class="bg-light">
    <form name="products_search" id="products_search" method="GET">
    </form>
    <form name="products_filter" id="products_filter" method="GET">
    <input type="text" id="filter_search" name="filter_search" form="products_filter" placeholder="search text">
    </form>
    <?php
        $page_number = 1;
        $conn = mysqli_connect('localhost', 'root', '', 'mobcom');
        $myquery = "SELECT * FROM `products_master`";

        function display_card($row){
            //<!-- Product Card Start -->
            $rating = 5*$row['rating_points'] / $row['rate_out_of'];
            $rating = round($rating, 1);
            $brand = $row['brand_name'];
            $brand = str_replace(' ', '_', $brand);
            $model = $row['model_name'];
            $model = str_replace(' ', '_', $model);
            $ram = $row['ram'] /1024;
            $rom =$row['rom'] /1024;
            $expandable = $row['expandable_up_to'] /1024;
            $screen = $row['screen_size'];
            $display = $row['display'];
            $front_cam = $row['front_camera'];
                if($front_cam == ''){
                    $front_cam = 'x MP + x MP + x MP';
                }else{
                    $front_cam = str_replace(' ', ' MP + ', $front_cam);
                    $front_cam = $front_cam . " MP";
                }
            $back_cam = $row['back_camera'];
                if ($back_cam == ''){
                    $back_cam = 'x MP + x MP + x MP';
                }else{
                    $back_cam = str_replace(' ', ' MP + ', $back_cam);
                    $back_cam = $back_cam . " MP";
                }
            if ($screen == ''){
                $screen = "xx.x";
            }else{
                $screen = $screen * 0.03937;
                $screen = round($screen, 1);
            }
            $battery = $row['battery'];
            $processor = $row['processor'];
            if ($processor == ''){
                $processor = "no named Processor";
            }else{
                $processor = $processor . " processor";
            }
            
                echo "<div class='card card-product-list mx-2 my-3 p-3'>";
                    echo "<div class='row no-gutters'>";
                        echo "<div class='col-md-3 mb-2'>";
                            echo "<a href='#'>";
                                echo "<img class='product-img' src='images/$brand/$model/front.jpg' height=250px alt='image $brand $model was not found'>";
                            echo "</a>";
                        echo "</div>";

                        echo "<div class='col-md-6'>";
                            echo "<div class='info-main'>";
                                echo "<a class='card-link' href='#'>";
                                    echo "<h5 class='font-weight-bold'>$row[brand_name] $row[model_name]</h5>";
                                echo "</a>";
                                echo "<div class='mb-3'>";
                                //starring
                                $i=0;
                                for ($i=1; $i<=5; $i++){
                                    if($rating >= $i){
                                        echo "<span class='fa fa-star checked'></span>";
                                    }elseif($rating + 0.5 >= $i){
                                        echo "<span class='fa fa-star-half-o checked'></span>";
                                    }else{
                                        echo "<span class='fa fa-star-o checked'></span>";
                                    }
                                    
                                }
                                    echo "<span class='badge badge-";
                                    if ($rating >= 4){
                                        echo "success";
                                    }elseif ($rating >= 3){
                                        echo "warning";
                                    }else{
                                        echo "danger";
                                    }
                                    echo " p-2'>$rating</span>";
                                    echo "<span class='text-muted'>Ratings</span>";
                                echo "</div>";

                                echo "<div>";
                                    echo "<ul class='px-2 mx-3'>";
                                        echo "<li>$ram GB RAM | $rom GB ROM";
                                        if ($expandable > 0){
                                            echo" | Expandable Upto $expandable GB";
                                        }
                                        echo "</li>";
                                        echo "<li>$screen inch";
                                        if ($display != ''){
                                            echo " $display";
                                        }else{
                                            echo " xxx display type";
                                        }
                                        echo "</li>";
                                        echo "<li>$back_cam | $front_cam Front Camera</li>";
                                        echo "<li>$battery mAh Battery</li>";
                                        echo "<li>$processor</li>";
                                    echo "</ul>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";

                        echo "<div class='col-sm-3'>";
                            echo "<div class='info-price pl-4 mr-4'>";
                                echo "<h3 class='font-weight-bold'>₹ $row[price]</h3>";
                                echo "<span class='badge badge-pill badge-danger verify-pill p-2'>";
                                    echo "MobCOM Verified";
                                    echo "<i class='fa fa-check-circle' aria-hidden='true'></i>";                                
                                echo "</span>";
                                echo "<p class='text-muted my-2'>No Cost EMI</p>";
                                echo "<p class='text-muted my-2'>Upto <b>₹ 4999</b> Off on Exchange</p>";
                                echo "<button type='button' class='btn btn-outline-secondary btn-block mt-4'>";
                                    echo "View More";
                                    echo "<i class='fa fa-angle-right' aria-hidden='true'></i>";
                                echo "</button>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";

            //<!-- Product Card End -->
        }



    ?>
    <!-- Navbar Start -->

    <div class="container-fluid sticky-top p-0">

        <nav class="navbar navbar-expand-lg navbar-dark" id="navbar">
            <a class="navbar-brand" href="#">
                <i class="fa fa-mobile" aria-hidden="true"></i>
                <span id="brand-name">MobCOM®</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
                aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="#">Best Sellers</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="#">Top Deals</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="#">New Releases</a>
                    </li>
                </ul>

                <form class="form-inline my-2 my-lg-0">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" form="products_search" name="search" id="search">
                        <div class="input-group-append">
                            <button name="search_button" class="btn btn-light" type="submit" id="search_button" form="products_search">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="navbar-nav">

                    <div class="dropdown ml-2">
                        <button class="btn btn-dark btn-block dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                            My Account
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">
                                <i class="fa fa-user mr-2" aria-hidden="true"></i>
                                My Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fa fa-shopping-cart mr-1" aria-hidden="true"></i>
                                My Orders
                            </a>
                            <div class="dropdown-divider"></div>
                            <div class="ml-2 mr-2">
                                <button class="btn btn-primary btn-block" type="button" data-toggle="modal"
                                    data-target="#exampleModalCenter">
                                    Login
                                </button>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-success ml-2" type="button">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        Cart <span class="badge badge-light">0</span>
                    </button>

                </div>

            </div>

        </nav>

    </div>

    <!-- Navbar End -->

    <!-- Breadcrumb Start -->

    <div class="container-fluid mt-3">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Newly Added</li>
            </ol>
        </nav>

    </div>

    <!-- Breadcrumb End -->

    <!-- Main Content Start -->

    <div class="container-fluid">

        <div class="row">

            <!-- Filter Start -->
            <!-- Filter Start -->
            <!-- Filter Start -->
            <!-- Filter Start -->

            <div class="col-md-2 mb-3">

                <div class="card-fluid card-filter" style="width: auto; height: auto;">

                    <div class="card-body p-2 m-1">

                        <h5 class="card-title text-center font-weight-bold mb-3">
                            <i class="fa fa-filter" aria-hidden="true"></i>
                            Filters
                        </h5>

                        <hr class="my-3">

                        <!-- Filter Form Start -->

                        <form method="GET">

                            <!-- Filter Price Start -->

                            <h6 class="title">
                                <a href="#" class="dropdown-toggle card-link text-dark font-weight-bold"
                                    data-toggle="collapse" data-target="#collapse_1">
                                    Price Range
                                </a>
                            </h6>

                            <div class="filter-content collapse" id="collapse_1">

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="price" value="">
                                    <div class="custom-control-label">₹ 5000 & below</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="price" value="">
                                    <div class="custom-control-label">₹ 5000 to ₹ 9999</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="price" value="">
                                    <div class="custom-control-label">₹ 10000 to ₹ 14999</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="price" value="">
                                    <div class="custom-control-label">₹ 15000 to ₹ 29999</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="price" value="">
                                    <div class="custom-control-label">₹ 30000 & above </div>
                                </label>

                            </div>

                            <!-- Filter Price End -->

                            <hr class="my-2">

                            <!-- Filter Brand Start -->

                            <h6 class="title">
                                <a href="#" class="dropdown-toggle card-link text-dark font-weight-bold"
                                    data-toggle="collapse" data-target="#collapse_2">
                                    Brand
                                </a>
                            </h6>
                            <div class="filter-content collapse" id="collapse_2">

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="brand" value="Apple">
                                    <div class="custom-control-label">Apple
                                        <b class="badge badge-pill badge-light float-right">120</b> </div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="brand" value="Asus">
                                    <div class="custom-control-label">Asus
                                        <b class="badge badge-pill badge-light float-right">100</b> </div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="brand" value="Nokia">
                                    <div class="custom-control-label">Nokia
                                        <b class="badge badge-pill badge-light float-right">140</b> </div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="brand" value="Oneplus">
                                    <div class="custom-control-label">One Plus
                                        <b class="badge badge-pill badge-light float-right">120</b> </div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="brand" value="Oppo">
                                    <div class="custom-control-label">Oppo
                                        <b class="badge badge-pill badge-light float-right">120</b> </div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="brand" value="Mi">
                                    <div class="custom-control-label">Mi
                                        <b class="badge badge-pill badge-light float-right">120</b> </div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="brand" value="Realme">
                                    <div class="custom-control-label">Realme
                                        <b class="badge badge-pill badge-light float-right">120</b> </div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="brand" value="Honor">
                                    <div class="custom-control-label">Honor
                                        <b class="badge badge-pill badge-light float-right">120</b> </div>
                                </label>

                            </div>

                            <!-- Filter Brand End -->

                            <hr class="my-2">

                            <!-- Filter RAM Start -->

                            <h6 class="title">
                                <a href="#" class="dropdown-toggle card-link text-dark font-weight-bold"
                                    data-toggle="collapse" data-target="#collapse_3">
                                    RAM
                                </a>
                            </h6>

                            <div class="filter-content collapse" id="collapse_3">

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="ram" value="6">
                                    <div class="custom-control-label">6 GB & Above</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="ram" value="4">
                                    <div class="custom-control-label">4 GB</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="ram" value="3">
                                    <div class="custom-control-label">3 GB</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="ram" value="2">
                                    <div class="custom-control-label">2 GB</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="ram" value="1">
                                    <div class="custom-control-label">1 GB</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="ram" value="512">
                                    <div class="custom-control-label">Less than 1 GB</div>
                                </label>


                            </div>

                            <!-- Filter RAM End -->

                            <hr class="my-2">

                            <!-- Filter Storage Start -->

                            <h6 class="title">
                                <a href="#" class="dropdown-toggle card-link text-dark font-weight-bold"
                                    data-toggle="collapse" data-target="#collapse_4">
                                    Internal Storage
                                </a>
                            </h6>

                            <div class="filter-content collapse" id="collapse_4">

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="storage" value="256">
                                    <div class="custom-control-label">256 GB & Above</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="storage" value="">
                                    <div class="custom-control-label">128-256 GB</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="storage" value="">
                                    <div class="custom-control-label">64-128GB</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="storage" value="">
                                    <div class="custom-control-label">32-64 GB</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="storage" value="">
                                    <div class="custom-control-label">16-32 GB</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="storage" value="">
                                    <div class="custom-control-label">8-16 GB</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="storage" value="">
                                    <div class="custom-control-label">4-8 GB</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="storage" value="">
                                    <div class="custom-control-label">2-4 GB</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="storage" value="">
                                    <div class="custom-control-label">Less than 2 GB</div>
                                </label>

                            </div>

                            <!-- Filter Storage End -->

                            <hr class="my-2">

                            <!-- Battery Capacity Start -->

                            <h6 class="title">
                                <a href="#" class="dropdown-toggle card-link text-dark font-weight-bold"
                                    data-toggle="collapse" data-target="#collapse_5">
                                    Battery Capacity
                                </a>
                            </h6>

                            <div class="filter-content collapse" id="collapse_5">

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="battery" value="">
                                    <div class="custom-control-label">1000-1999 mAh</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="battery" value="">
                                    <div class="custom-control-label">2000-2999mAh</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="battery" value="">
                                    <div class="custom-control-label">3000-3999mAh</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="battery" value="">
                                    <div class="custom-control-label">5000mAh & Above</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="battery" value="">
                                    <div class="custom-control-label">Less than 1000 mAh</div>
                                </label>

                            </div>

                            <!-- Battery Capacity End -->

                            <hr class="my-2">

                            <!-- Back Camera Start -->

                            <h6 class="title">
                                <a href="#" class="dropdown-toggle card-link text-dark font-weight-bold"
                                    data-toggle="collapse" data-target="#collapse_6">
                                    Back Camera
                                </a>
                            </h6>

                            <div class="filter-content collapse" id="collapse_6">

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="pcamera" value="">
                                    <div class="custom-control-label">Below 2 MP</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="pcamera" value="">
                                    <div class="custom-control-label">3-4.9 MP</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="pcamera" value="">
                                    <div class="custom-control-label">5-7.9 MP</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="pcamera" value="">
                                    <div class="custom-control-label">8-11.9 MP</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="pcamera" value="">
                                    <div class="custom-control-label">12-12.9 MP</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="pcamera" value="">
                                    <div class="custom-control-label">13-15.9 MP</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="pcamera" value="">
                                    <div class="custom-control-label">16-20.9 MP</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="pcamera" value="">
                                    <div class="custom-control-label">21 MP & Above</div>
                                </label>

                            </div>

                            <!-- Back Camera End -->

                            <hr class="my-2">

                            <!-- Front Camera Start -->

                            <h6 class="title">
                                <a href="#" class="dropdown-toggle card-link text-dark font-weight-bold"
                                    data-toggle="collapse" data-target="#collapse_7">
                                    Front Camera
                                </a>
                            </h6>

                            <div class="filter-content collapse" id="collapse_7">

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="pcamera" value="">
                                    <div class="custom-control-label">0-1.9 MP</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="pcamera" value="">
                                    <div class="custom-control-label">12-12.9 MP</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="pcamera" value="">
                                    <div class="custom-control-label">13-15.9 MP</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="pcamera" value="">
                                    <div class="custom-control-label">16-20.9 MP</div>
                                </label>

                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="pcamera" value="">
                                    <div class="custom-control-label">21 MP & Above</div>
                                </label>

                            </div>

                            <!-- Front Camera End -->

                            <hr class="my-2">

                            <div class="mb-5">
                                <button type="submit" name="filter_button" id="filter_button" class="btn btn-primary float-left">Apply</button>
                                <button type="reset" class="btn btn-secondary float-right">
                                    <i class="fa fa-refresh" aria-hidden="true"></i>
                                </button>
                            </div>

                        </form>

                        <!-- Filter Form End -->
                        <!-- Filter Form End -->
                        <!-- Filter Form End -->

                    </div>

                </div>

            </div>

            <!-- Filter End -->

            <!-- Product List Start -->

            <div class="col-md-10">

                <div class="form-inline">
                    
                    <?php
                        //PHP STARTS HERE
                        if(!isset($_GET['search_button'])){                         
                            $myquery = $myquery = "SELECT * FROM `products_master` GROUP BY `brand_name`,`model_name` ORDER BY `date_updated`";
                        }else{
                            $myquery = "SELECT * FROM `products_master` WHERE CONCAT(`brand_name`, `model_name`, `price`, `battery`) LIKE '%$_GET[search]%' GROUP BY `brand_name`,`model_name`";
                        }
                        //here gets the number of products
                        $results = $conn->query($myquery);
                        $items = mysqli_num_rows($results);
                        echo "<strong class='mr-md-auto'>$items Products found</strong>";

                        ////Here filters are applied

                        ///Here pagination is applied

                        
                    ?>
                </div>
                <?php
                    ///here producsts cards are shown
                    while ($row = mysqli_fetch_array($results)){
                        display_card($row);
                    }
                ?>
                
                <!-- Pagination -->

                <nav aria-label="Page navigation sample">
                    <ul class="pagination justify-content-center mx-2 my-2">
                        <li class="page-item disabled"><a class="page-link"
                                href="#">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link"
                                href="#">1</a>
                        </li>
                        <li class="page-item"><a class="page-link"
                                href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link"
                                href="#">3</a>
                        </li>
                        <li class="page-item"><a class="page-link"
                                href="#">4</a>
                        </li>
                        <li class="page-item"><a class="page-link"
                                href="#">5</a>
                        </li>
                        <li class="page-item"><a class="page-link"
                                href="#">Next</a>
                        </li>
                    </ul>
                </nav>

            </div>

            <!-- Product List End -->

        </div>
       
    </div>

    <!-- Main Content End -->

    <!-- Footer Start -->

    <footer class="container-fluid text-center text-muted  mt-5 p-2" id="footer">

        <div class="mt-2 mb-5">
            <hr>
            <p class="m-0">Copyright <span class="fa fa-copyright"></span> Project RAPS</p>
            <a href="#" class="m-0 card-link text-muted"><small> Privacy Policy | </small></a>
            <a href="#" class="m-0 card-link text-muted"><small> Terms & Conditions </small></a>
            <p class="m-2"><span class="fa fa-mobile"></span></p>
        </div>

    </footer>

    <!-- Footer End -->

    <!-- Boostrap 4 JS -->

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->

    <script src="js/custom.js"></script>
    <?php
        $conn->close();
        if (isset($_GET['search_button'])){
            echo "<script>document.getElementById('filter_search').value = '$_GET[search]'</script>";
        }
    ?>
</body>

</html>