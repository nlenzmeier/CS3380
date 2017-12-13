<?php
require_once "secure/database.php";

function alert($msg) {
    echo "<script>alert('" . $msg . "');</script>";
}

/* Initialize database connection */
$mysqli = new mysqli(HOST, USERNAME, PASSWORD, DBNAME) or die($mysqli->connect_error);

/* If already logged in, redirect */
session_start();
if (isset($_SESSION['user'])) {
    header("Location: shop.php");
}

function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}


$user_ip = getUserIP();
//console.dir($user_ip);
//echo "<script>alert('" . $user_ip . "');</script>"; // Output IP address [Ex: 177.87.193.134]


/* If user attempts to register or login */
if (isset($_POST['submit'])) {
    if ($_POST['action'] == "register" || $_POST['action'] == "login") {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $passhash = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);

        /* Check if employee exists with that username */
        $sql = "SELECT * FROM employee WHERE username = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $usernameTaken = $result->num_rows;
    }

    if ($_POST['action'] == "register") {
        if ($usernameTaken) {
            alert("Username has already been taken.");
        } else {
            $fname = htmlspecialchars($_POST['firstname']);
            $lname = htmlspecialchars($_POST['lastname']);
            $position = htmlspecialchars($_POST['position']);

            $sql = "INSERT INTO employee VALUES (?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("sssss", $username, $passhash, $fname, $lname, $position);
            if ($stmt->execute()) {
                alert("User has successfully been registered.");
                
                $sql = "INSERT INTO website_Login VALUES(?, now(), ?, 'register')";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("ss", $user_ip, $username);
                $stmt->execute();
                
            } else {
                alert("Error registering user.");
            }
        }
    } elseif ($_POST['action'] == "login") {
        if (!$username || !password_verify($password, $row['password'])) {
            alert("Invalid login credentials.");
        } else {  
            $_SESSION['user'] = $row;
            $redirects = array("admin.php", "engineer.php", "conductor.php");
            
            $sql = "INSERT INTO website_Login VALUES(?, now(), ?, 'employee login')";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", $user_ip, $username);
            $stmt->execute();
            
            header("Location: " . $redirects[$row['position']]);
        }
    } elseif ($_POST['action'] == "clogin") {
        /* Check if customer exists with that username */
        $username = htmlspecialchars($_POST['username']);
        //$sql = "SELECT * FROM customer WHERE username = ?";
        $sql = "SELECT * FROM customers WHERE company_id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$result->num_rows) {
            alert("Invalid login credentials.");
        } else {
            $_SESSION['user'] = $row;
            header("Location: shop.php");
            
            $sql = "INSERT INTO website_Login VALUES(?, now(), ?, 'customer login')";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", $user_ip, $username);
            $stmt->execute();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Off the Rails</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
    <script>
        //function getContent() {
        $(function() {
           
            // message to let user know its loading
            //$("#titleBox").html("Loading...");
            
            // jQuery AJAX GET
            $.get("loadIndexTitle.php", function(data) {
               
                console.dir(data);
                $("#titleBox").html(data);
                
            });
        });
    </script>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/stylish-portfolio.css" rel="stylesheet">

    <link href="index.css">

    <link href="signin.css">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<style>
    h1 { color: white; }
</style>
</head>
<body>
    <a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="fa fa-bars"></i></a>
    <nav id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times"></i></a>
            <li class="sidebar-brand">
                <a href="#top" onclick=$("#menu-close").click();>Welcome!</a>
            </li>
            <li>
                <a href="#top" onclick=$("#menu-close").click();>Home</a>
            </li>
            <li>
                <a href="#about" onclick=$("#menu-close").click();>Login</a>
            </li>
            <li>
                <a href="shop.php" onclick=$("#menu-close").click();>Shop</a>
            </li>
            <li>
                <a href="#contact" onclick=$("#menu-close").click();>Contact</a>
            </li>
        </ul>
    </nav>

    <!-- Header -->
    <header id="top" class="header">
        <div class="text-vertical-center">
            <h1 id="titleBox" onload="getContent()"></h1>

            <br>
            <a href="#about" class="btn btn-dark btn-lg">Find Out More</a>
        </div>
    </header>

    <!-- About -->
    <section id="about" class="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Click one of the Login buttons below to begin.</h2>
                    <p class="lead"> <a target="_blank" href="http://join.deathtothestockphoto.com/"></a></p>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>

    <!-- Services -->
    <!-- The circle icons use Font Awesome's stacked icon classes. For more information, visit http://fontawesome.io/examples/ -->
    <section id="services" class="services bg-primary">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-10 col-lg-offset-1">
                    <h2>Login Now</h2>
                    <hr class="small">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="service-item">
                                <span class="fa-stack fa-4x">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-cloud fa-stack-1x text-primary"></i>
                                </span>
                                <h4>
                                    <strong>Customer Login</strong>
                                </h4>
                                <p>Browse our selections in the shop!</p>
                                <a href="" class="btn btn-light" data-toggle="modal" data-target="#customerLoginModal">Shop Now</a>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="service-item">
                                <span class="fa-stack fa-4x">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-compass fa-stack-1x text-primary"></i>
                                </span>
                                <h4>
                                    <strong>Login</strong>
                                </h4>
                                <p>If existing user.</p>
                                <a href="#" class="btn btn-light" data-toggle="modal" data-target="#mySecondModalHorizontal">Login</a>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="service-item">
                                <span class="fa-stack fa-4x">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-flask fa-stack-1x text-primary"></i>
                                </span>
                                <h4>
                                    <strong>Register</strong>
                                </h4>
                                <p>Sign up here!</p>
                                <a href="" class="btn btn-light" data-toggle="modal" data-target="#myModalHorizontal">Register</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.col-lg-10 -->
        </div>
        <!-- /.row -->
        <!--        </div>-->
        <!-- /.container -->
    </section>

    <!-- Modal -->
    <div class="modal fade" id="myModalHorizontal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close"
                data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">
                Register
            </h4>
        </div>

        <!-- Modal Body -->
        <form id="thisIsID" method="post" class="form-horizontal" role="form">
            <div class="modal-body">
                <input type="hidden" name="action" value="register" />
                <div class="form-group copt hide">
                    <label class="col-sm-2 control-label"
                    for="username">Username</label>
                    <div class="col-sm-10">
                        <input type="number" name="username" min="1" max="999999" class="form-control"
                        id="username" placeholder="Username"/>
                    </div>
                </div>
                <div class="form-group opt">
                    <label class="col-sm-2 control-label"
                    for="username">Username</label>
                    <div class="col-sm-10">
                        <input type="text" name="username" class="form-control"
                        id="username" placeholder="Username"/>
                    </div>
                </div>
                <div class="form-group opt">
                    <label class="col-sm-2 control-label"
                    for="inputPassword3" >Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control"
                        id="password" placeholder="Password"/>
                    </div>
                </div>

                <div class="form-group opt">
                    <label class="col-sm-2 control-label"
                    for="firstname">First Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="firstname" class="form-control"
                        id="firstname" placeholder="First Name"/>
                    </div>
                </div>
                <div class="form-group opt">
                    <label class="col-sm-2 control-label"
                    for="lastname">Last Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="lastname" class="form-control"
                        id="lastname" placeholder="Last Name"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"
                    for="position">Position</label>
                    <div class="col-sm-10">
                        <select id="registerPosition" class="form-control" name="position">
                            <option value="0">Administrator</option>
                            <option value="1">Engineer</option>
                            <option value="2">Conductor</option>
                            <option value="3">Customer</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <input type="submit" name="submit" class="btn btn-primary" />
            </div>
        </form>
    </div>
</div>
</div>



<!--FOR LOGIN!!!    -->
<div class="modal fade" id="mySecondModalHorizontal" tabindex="-1" role="dialog"
aria-labelledby="mySecondModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <button type="button" class="close"
            data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
            Login
        </h4>
    </div>

    <!-- Modal Body -->
    <form id="thisIsID" method="post" class="form-horizontal" role="form">
        <div class="modal-body">
            <input type="hidden" name="action" value="login" />
            <div class="form-group">
                <label  class="col-sm-2 control-label"
                for="username">Username</label>
                <div class="col-sm-10">
                    <input type="text" name="username" class="form-control"
                    id="username" placeholder="Username"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"
                for="inputPassword3" >Password</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control"
                    id="inputPassword3" placeholder="Password"/>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <input type="submit" name="submit" class="btn btn-primary" />
        </div>
    </form>
</div>
</div>
</div>

<div class="modal fade" id="customerLoginModal" tabindex="-1" role="dialog"
aria-labelledby="mySecondModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <button type="button" class="close"
            data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
            Customer Login
        </h4>
    </div>

    <!-- Modal Body -->
    <form id="thisIsID" method="post" class="form-horizontal" role="form">
        <div class="modal-body">
            <input type="hidden" name="action" value="clogin" />
            <div class="form-group">
                <label  class="col-sm-2 control-label"
                for="username">Username</label>
                <div class="col-sm-10">
                    <input type="number" name="username" min="1" max="999999" class="form-control"
                        id="username" placeholder="Username"/>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <input type="submit" name="submit" class="btn btn-primary" />
        </div>
    </form>
</div>
</div>
</div>



<!-- Callout -->

<!-- Portfolio -->

<!-- Call to Action -->

<!-- Map -->
<section id="contact" class="map">
    <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;aq=0&amp;oq=twitter&amp;sll=28.659344,-81.187888&amp;sspn=0.128789,0.264187&amp;ie=UTF8&amp;hq=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;t=m&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe>
    <br />
    <small>
        <a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;aq=0&amp;oq=twitter&amp;sll=28.659344,-81.187888&amp;sspn=0.128789,0.264187&amp;ie=UTF8&amp;hq=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;t=m&amp;z=15&amp;iwloc=A"></a>
    </small>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <h4><strong>Thanks for visiting!</strong>
                </h4>
                <p>101 Swallow Hall
                    <br>Columbia, MO 65201</p>
                    <ul class="list-unstyled">
                        <li><i class="fa fa-phone fa-fw"></i> (777) 777-7777</li>
                        <li><i class="fa fa-envelope-o fa-fw"></i> <a href="mailto:name@example.com">Group7@example.com</a>
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
                    <p class="text-muted">Copyright &copy; Group 7 2017</p>
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
$("#registerPosition").change(function() {
    if ($("#registerPosition option:selected").text() == "Customer") {
        $('.opt').addClass('hide');
        $('.copt').removeClass('hide');
    } else {
        $('.opt').removeClass('hide');
        $('.copt').removeClass('hide');
    }
});
// Closes the sidebar menu
$("#menu-close").click(function(e) {
    e.preventDefault();
    $("#sidebar-wrapper").toggleClass("active");
});
// Opens the sidebar menu
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#sidebar-wrapper").toggleClass("active");
});
// Scrolls to the selected menu item on the page
$(function() {
    $('a[href*=#]:not([href=#],[data-toggle],[data-target],[data-slide])').click(function() {
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
$(document).scroll(function() {
    if ($(this).scrollTop() > 250) {
        if (!fixed) {
            fixed = true;
// $('#to-top').css({position:'fixed', display:'block'});
$('#to-top').show("slow", function() {
    $('#to-top').css({
        position: 'fixed',
        display: 'block'
    });
});
}
} else {
    if (fixed) {
        fixed = false;
        $('#to-top').hide("slow", function() {
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
var onMapMouseleaveHandler = function(event) {
    var that = $(this);
    that.on('click', onMapClickHandler);
    that.off('mouseleave', onMapMouseleaveHandler);
    that.find('iframe').css("pointer-events", "none");
}
var onMapClickHandler = function(event) {
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

</body>
</html>