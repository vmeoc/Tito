<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Time Traffic overview by Vince</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/stylish-portfolio.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <!-- css for tables -->
        link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </head>

    <body>

        <!-- Navigation -->
        <a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="fa fa-bars"></i></a>
        <nav id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times"></i></a>
                <li class="sidebar-brand">
                    <a href="#top" onclick=$("#menu-close").click();>Start Bootstrap</a>
                </li>
                <li>
                    <a href="#top" onclick=$("#menu-close").click();>Home</a>
                </li>
                <li>
                    <a href="#about" onclick=$("#menu-close").click();>About</a>
                </li>
                <li>
                    <a href="#services" onclick=$("#menu-close").click();>Services</a>
                </li>
                <li>
                    <a href="#portfolio" onclick=$("#menu-close").click();>Portfolio</a>
                </li>
                <li>
                    <a href="#contact" onclick=$("#menu-close").click();>Contact</a>
                </li>
            </ul>
        </nav>

        <!-- Header -->
        <header id="top" class="header">
            <div class="text-vertical-center">
                <h1>Tito</h1>
                <h3>Time Traffic Overview</h3>
                <h5>by Vince :)</h5>
                <br>
                <a href="#about" class="btn btn-dark btn-lg">Find Out More</a>
            </div>
        </header>

        <!-- About -->
        <section id="about" class="about">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>Commuting every day?</h2>
                        <p class="lead">Let's take a moment to look at your commuting data</p>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </section>

        <!-- Services -->
        <!-- The circle icons use Font Awesome's stacked icon classes. For more information, visit http://fontawesome.io/examples/ -->
        <section id="services" class="services bg-primary">
            <form class="form-horizontal" role="form" action="index.php" method="post">
                <div class="container">
                    <div class="form-group">
                        <div class="row text-center">
                            <div class="col-lg-10 col-lg-offset-1">
                                <hr class="small">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="service-item">
                                            <img src="img/home-icon.png" width="128" height="128">
                                            <h4>
                                                <strong>Home address</strong>
                                            </h4>
                                            <input type="text" class="form-control" id="home" name="home" placeholder="Home Address" value="">
                                            <script type="text/javascript" src="js/BuildTimepicker.js"></script>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="service-item">
                                            <img src="img/building-icon.png" width="128" height="128">
                                            <h4>
                                                <strong>Work address</strong>
                                            </h4>
                                            <input type="text" class="form-control" id="work" name="work" placeholder="Work Address" value="">
                                            <script type="text/javascript" src="js/BuildTimepicker.js"></script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <div class="row">    
                    <div class="span12">
                        <input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
                    </div>
                </div>
                <!-- /.container -->
            </form>
        </section>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            include "form_result.php";
        }
        ?>
        <!-- Callout -->
        <aside class="callout">
            <div class="text-vertical-center">
                <h1>Vertically Centered Text</h1>
            </div>
        </aside>

        <!-- Portfolio -->
        <section id="portfolio" class="portfolio">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-lg-offset-1 text-center">
                        <h2>Our Work</h2>
                        <hr class="small">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="portfolio-item">
                                    <a href="#">
                                        <img class="img-portfolio img-responsive" src="img/portfolio-1.jpg">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="portfolio-item">
                                    <a href="#">
                                        <img class="img-portfolio img-responsive" src="img/portfolio-2.jpg">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="portfolio-item">
                                    <a href="#">
                                        <img class="img-portfolio img-responsive" src="img/portfolio-3.jpg">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="portfolio-item">
                                    <a href="#">
                                        <img class="img-portfolio img-responsive" src="img/portfolio-4.jpg">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.row (nested) -->
                        <a href="#" class="btn btn-dark">View More Items</a>
                    </div>
                    <!-- /.col-lg-10 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </section>

        <!-- Call to Action -->
        <aside class="call-to-action bg-primary">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h3>The buttons below are impossible to resist.</h3>
                        <a href="#" class="btn btn-lg btn-light">Click Me!</a>
                        <a href="#" class="btn btn-lg btn-dark">Look at Me!</a>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Map -->
        <section id="contact" class="map">
            <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;aq=0&amp;oq=twitter&amp;sll=28.659344,-81.187888&amp;sspn=0.128789,0.264187&amp;ie=UTF8&amp;hq=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;t=m&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe>
            <br />
            <small>
                <a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;aq=0&amp;oq=twitter&amp;sll=28.659344,-81.187888&amp;sspn=0.128789,0.264187&amp;ie=UTF8&amp;hq=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;t=m&amp;z=15&amp;iwloc=A"></a>
            </small>
            </iframe>
        </section>

        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-lg-offset-1 text-center">
                        <h4><strong>Start Bootstrap</strong>
                        </h4>
                        <p>3481 Melrose Place
                            <br>Beverly Hills, CA 90210</p>
                        <ul class="list-unstyled">
                            <li><i class="fa fa-phone fa-fw"></i> (123) 456-7890</li>
                            <li><i class="fa fa-envelope-o fa-fw"></i> <a href="mailto:name@example.com">name@example.com</a>
                            </li>
                        </ul>
                        <br>
                        <ul class="list-inline">
                            <li>
                                <a href="#"><i class="fa fa-facebook fa-fw fa-3x"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-twitter fa-fw fa-3x"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-dribbble fa-fw fa-3x"></i></a>
                            </li>
                        </ul>
                        <hr class="small">
                        <p class="text-muted">Copyright &copy; Your Website 2014</p>
                    </div>
                </div>
            </div>
            <a id="to-top" href="#top" class="btn btn-dark btn-lg"><i class="fa fa-chevron-up fa-fw fa-1x"></i></a>
        </footer>

        <!-- jQuery -->
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script>
                        // Closes the sidebar menu
                        $("#menu-close").click(function (e) {
                            e.preventDefault();
                            $("#sidebar-wrapper").toggleClass("active");
                        });
                        // Opens the sidebar menu
                        $("#menu-toggle").click(function (e) {
                            e.preventDefault();
                            $("#sidebar-wrapper").toggleClass("active");
                        });
                        // Scrolls to the selected menu item on the page
                        $(function () {
                            $('a[href*=#]:not([href=#],[data-toggle],[data-target],[data-slide])').click(function () {
                                if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {
                                    var target = $(this.hash);
                                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                                    if (target.length) {
                                        $('html,body').animate({
                                            scrollTop: target.offset().top
                                        }, 1000);
                                        return false;
                                    }
                                }
                            });
                        });
                        //#to-top button appears after scrolling
                        var fixed = false;
                        $(document).scroll(function () {
                            if ($(this).scrollTop() > 250) {
                                if (!fixed) {
                                    fixed = true;
                                    // $('#to-top').css({position:'fixed', display:'block'});
                                    $('#to-top').show("slow", function () {
                                        $('#to-top').css({
                                            position: 'fixed',
                                            display: 'block'
                                        });
                                    });
                                }
                            } else {
                                if (fixed) {
                                    fixed = false;
                                    $('#to-top').hide("slow", function () {
                                        $('#to-top').css({
                                            display: 'none'
                                        });
                                    });
                                }
                            }
                        });
                        // Disable Google Maps scrolling
                        // See http://stackoverflow.com/a/25904582/1607849
                        // Disable scroll zooming and bind back the click event
                        var onMapMouseleaveHandler = function (event) {
                            var that = $(this);
                            that.on('click', onMapClickHandler);
                            that.off('mouseleave', onMapMouseleaveHandler);
                            that.find('iframe').css("pointer-events", "none");
                        }
                        var onMapClickHandler = function (event) {
                            var that = $(this);
                            // Disable the click handler until the user leaves the map area
                            that.off('click', onMapClickHandler);
                            // Enable scrolling zoom
                            that.find('iframe').css("pointer-events", "auto");
                            // Handle the mouse leave event
                            that.on('mouseleave', onMapMouseleaveHandler);
                        }
                        // Enable map zooming with mouse scroll when the user clicks the map
                        $('.map').on('click', onMapClickHandler);
        </script>

        <!-- autocompletion des champs addresse avec Google -->
        <script>
            // This example displays an address form, using the autocomplete feature
            // of the Google Places API to help users fill in the information.

            // This example requires the Places library. Include the libraries=places
            // parameter when you first load the API. For example:
            //<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5ZDRG9r8hBWrtlGsEuJKU2KBg_cCV_Qk&libraries=places">

            var placeSearch, autocomplete;


            function initAutocomplete() {
                // Create the autocomplete object, restricting the search to geographical
                // location types.
                autocomplete = new google.maps.places.Autocomplete(
                        /** @type {!HTMLInputElement} */(document.getElementById('home')),
                        {types: ['geocode']});
                autocomplete = new google.maps.places.Autocomplete(
                        /** @type {!HTMLInputElement} */(document.getElementById('work')),
                        {types: ['geocode']});


            }

            // Bias the autocomplete object to the user's geographical location,
            // as supplied by the browser's 'navigator.geolocation' object.
            function geolocate() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        var geolocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        var circle = new google.maps.Circle({
                            center: geolocation,
                            radius: position.coords.accuracy
                        });
                        autocomplete.setBounds(circle.getBounds());
                    });
                }
            }
        </script>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5ZDRG9r8hBWrtlGsEuJKU2KBg_cCV_Qk&libraries=places&callback=initAutocomplete"
        async defer></script>

    </body>

</html>
