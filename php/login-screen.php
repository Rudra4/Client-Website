<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Excel Educational Services LLC</title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/styles.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Itim&display=swap"
	rel="stylesheet">
</head>
<body>

	<header>
		<nav id="header-nav" class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a href="index.html" class="pull-left visible-md visible-lg">
						<div id="logo-img" alt="Logo"></div>
					</a>
					<div class="navbar-brand">
						<a href="index.html"><h1>Excel Educational Services LLC</h1></a>
						<div id="slogan">The power to excel!</div>
					</div>
					<button id="navbarToggle" type="button"
						class="navbar-toggle collapsed" data-toggle="collapse"
						data-target="#collapsable-nav" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span> <span
							class="icon-bar"></span> <span class="icon-bar"></span> <span
							class="icon-bar"></span>
					</button>
				</div>
				<div id="collapsable-nav" class="collapse navbar-collapse">
					<ul id="nav-list" class="nav navbar-nav navbar-right">
						<li id="navHomeButton" class="visible-xs active"><a
							href="index.html"> <span class="glyphicon glyphicon-home"> Home</span>
						</a></li>
						<li id="navProgButton"><a href="#"
							onclick="$nameSpace.loadProgramCategories();"> <span
								class="glyphicon glyphicon-book"></span><br class="hidden-xs">
								Programs
						</a></li>
						<li><a href="#" onclick="$nameSpace.loadCamps();"> <span
								class="glyphicon glyphicon-flag"></span> <br class="hidden-xs">
								Camps
						</a></li>
						<li><a href="#" onclick="$nameSpace.loadAbout();"> <span
								class="glyphicon glyphicon-info-sign"></span> <br
								class="hidden-xs"> About Us
						</a></li>
						<li id="phone" class="hidden-xs"><a href="tel:+1 123-456-7890"> <span>+1
									123-456-7890</span>
						</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</header>

	<div id="call-btn" class="visible-xs">
		<a class="btn" href="tel:+1 123-456-7890"> <span
			class="glyphicon glyphicon-earphone"></span> +1 123-456-7890
		</a>
	</div>

	<div>
	<?php
    require_once 'db.php';
    try {
        if(isset($_POST['lEmail']) && isset($_POST['lPwd'])){
            $stmt1 = $pdo->prepare('SELECT fname FROM Website.Parent where email = :em and pwd = :pw');
            $stmt2 = $pdo->prepare('SELECT fname FROM Website.Tutor where email = :em and pwd = :pw');
            $stmt3 = $pdo->prepare('SELECT fname FROM Website.Student where email = :em and pwd = :pw');
            $stmt1->execute(array(
                ':em' => $_POST['lEmail'],
                ':pw' => $_POST['lPwd']
            ));
            $stmt2->execute(array(
                ':em' => $_POST['lEmail'],
                ':pw' => $_POST['lPwd']
            ));
            $stmt3->execute(array(
                ':em' => $_POST['lEmail'],
                ':pw' => $_POST['lPwd']
            ));
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
            if(! empty($row1) && empty($row2) && empty($row3)){
                echo '<h1 style = "text-align: center;">Welcome '.$row1['fname'].'!</h1>';
                
            }
            else if(! empty($row2) && empty($row1) && empty($row3)){
                echo '<h1 style = "text-align: center;">Welcome '.$row2['fname'].'!</h1>';
            }
            else if(! empty($row3) && empty($row1) && empty($row2)){
                echo '<h1 style = "text-align: center;">Welcome '.$row3['fname'].'!</h1>';
            }else{
                echo '<h2 style="color: red;">UserID or Password is incorrect.</h2>';
            }
            echo '<br><h3>Click <a href="../index.html">HERE</a> to Logout!</h3>';
        }else{
            echo '<h1 style="color: red;">UserID not found</h1>' ;
            echo '<br><h3>Click <a href="../index.html">HERE</a> to return to main screen.</h3>';
        }
    } catch (Exception $e) {
        print_r($e->errorInfo);
        echo '<br><h3>Click <a href="../index.html">HERE</a> to to return to main screen.</h3>';
    }
    ?>
	</div>

	<footer class="panel-footer">
		<div class="container">
			<div class="row">
				<section id="hours" class="col-sm-4">
					<span>Hours:</span><br> Mon-Sat: 08:00 AM - 05:00 PM<br> Sunday
					Closed
					<hr class="visible-xs">
				</section>

				<section id="address" class="col-sm-4">
					<span>Address:</span><br> 5 Rock Run Road<br> East Windsor, NJ
					08520.
					<hr class="visible-xs">
				</section>

				<section id="testimonials" class="col-sm-4">
					<p>"The best tutor my kid has ever been to! And that's saying a
						lot, sice we have tried many!"</p>
					<p>"Amazing staff! Great education! Couldn't be more satisfied!
						I'll spread the word about them!"
				
				</section>
			</div>

			<div class="text-center">&copy; Copyright Excel Education Services
				LLC 2021. All rights reserved.</div>
		</div>
	</footer>

	<!-- jQuery (Bootstrap JS plugins depend on it) -->
	<script src="../js/jquery-2.1.4.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/ajax-utils.js"></script>
	<script src="../js/script.js"></script>
</body>
</html>
