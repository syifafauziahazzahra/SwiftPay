<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Site Metas -->
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>POSISI</title>


    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('temp/css/bootstrap.css') }}">

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">

    <!-- font awesome style -->
    <link href="{{ asset('temp/css/font-awesome.min.css') }} " rel="stylesheet">
    <!-- nice select -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha256-mLBIhmBvigTFWPSCtvdu6a76T+3Xyt+K571hupeFLg4=" crossorigin="anonymous">
    <!-- slidck slider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha256-UK1EiopXIL+KVhfbFa8xrmAWPeBjMVdvYMYkTAEv/HI=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css.map" integrity="undefined" crossorigin="anonymous">


    <!-- Custom styles for this template -->
    <link href="{{ asset('temp/css/style.css') }}" rel="stylesheet">
    <!-- responsive style -->
    <link href="{{ asset('temp/css/responsive.css') }}" rel="stylesheet">

</head>

<body>

    <div class="hero_area">
        <!-- header section strats -->
        <header class="header_section">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container">
                    <a class="navbar-brand" href="index.html">
                        <span>
                            CipaCup's
                        </span>
                    </a>
                    <div class="" id="">
                        @if (Route::has('login'))
                        <div class="User_option">
                            @auth
                            <a href="{{ url('/dashboard') }}">
                                <i class="#" aria-hidden="true"></i>
                                <span>Home</span>
                            </a>
                            @else
                            <a href="{{ route('login') }}">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span>Login</span>
                            </a>
                            <!-- @if (Route::has('register'))
                            <a href="{{ route('register') }}">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span>Register</span>
                            </a> -->
                            @endif
                            @endauth
                        </div>
                        @endif
                        <div class="custom_menu-btn">
                            <button onclick="openNav()">
                                <img src="{{ asset('temp/images/menu.png') }}') }}" alt="">
                            </button>
                        </div>
                        <div id="myNav" class="overlay">

                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <!-- end header section -->

        <!-- slider section -->
        <section class="slider_section ">
            <div class="container ">
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <div class="detail-box">
                            <h1>
                                Cipacup's Cafe
                            </h1>
                            <p>
                                menawarkan kombinasi unik minuman (cups) dengan berbagai variasi warna dan rasa
                            </p>
                        </div>
                        <div class="find_container ">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <form>
                                            <div class="form-row ">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="slider_container">
                <!-- <div class="item">
                    <div class="img-box">
                        <img src="{{ asset('temp/images/wafle.jpg.jpg') }}" alt="" height="350">
                    </div>
                </div> -->
                <div class="item">
                    <div class="img-box">
                        <img src="{{ asset('temp/images/manggo.jpg') }}" alt="" height="350">
                    </div>
                </div>
                <div class="item">
                    <div class="img-box">
                        <img src="{{ asset('temp/images/triple berry.jpg') }}" alt="" height="350">
                    </div>
                </div>
                <div class="item">
                    <div class="img-box">
                        <img src="{{ asset('temp/images/cokelat.jpg') }}" alt="" height="350">
                    </div>
                </div>
                <!-- <div class="item">
                    <div class="img-box">
                        <img src="{{ asset('temp/images/kentang.jpg.jpg') }}" alt="" height="350">
                    </div>
                </div> -->
                <div class="item">
                    <div class="img-box">
                        <img src="{{ asset('temp/images/strawbery.jpg') }}" alt="" height="350">
                    </div>
                </div>
                <!-- <div class="item">
                    <div class="img-box">
                        <img src="{{ asset('temp/images/burger.jpg') }}" alt="" height="350">
                    </div>
                </div> -->
                <div class="item">
                    <div class="img-box">
                        <img src="{{ asset('temp/images/matcha.jpg') }}" alt="" height="350">
                    </div>
                </div>
            </div>
        </section>
        <!-- end slider section -->
    </div>

    <!-- about section -->

    <section class="about_section layout_padding">
        <div class="container">
            <div class="col-md-11 col-lg-10 mx-auto">
                <div class="heading_container heading_center">
                    <h2>
                        About Us
                    </h2>
                </div>
                <div class="box">
                    <div class="col-md-7 mx-auto">
                        <div class="img-box">
                            <img src="{{ asset('temp/images/cup.png') }}" class="box-img" alt="">
                        </div>
                    </div>
                    <div class="detail-box">
                        <p>
                            CipaCup's merupakan tempat nongkrong yang menyajikan minuman (cups) yang beragam. Di sini, pengunjung dapat menemukan berbagai minuman segar yang disajikan dalam cup. Pengunjung dapat menikmati strawbery smoothies dan milkshakes dengan berbagai pilihan rasa yang disesuaikan dengan selera masing-masing.

                            Dengan suasana yang nyaman dan menyenangkan, CipaCup's menjadi tempat yang cocok untuk berkumpul bersama teman atau keluarga sambil menikmati minuman yang menyegarkan. Konsep uniknya menjadikan CipaCup's sebagai tempat nongkrong yang menarik bagi pecinta minuman segar.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->

    <div class="footer_container">



        <!-- footer section -->
        <footer class="footer_section">
            <div class="container">
                <p>
                    &copy; <span id="displayYear"></span> All Rights Reserved By
                    <a href="https://html.design/"></a><br>
                    Distributed By: <a href="https://themewagon.com/">Syifa Fauziah Azzahra</a>
                </p>
            </div>
        </footer>
        <!-- footer section -->

    </div>
    <!-- jQery -->
    <script src="{{ asset('temp/js/jquery-3.4.1.min.js') }}"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('temp/js/bootstrap.js') }}"></script>
    <!-- slick  slider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>
    <!-- nice select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo=" crossorigin="anonymous"></script>
    <!-- custom js -->
    <script src="{{ asset('temp/js/custom.js') }}"></script>


</body>

</html>