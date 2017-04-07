<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <title>TODO List Application</title>
    
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
       <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Todo List Application</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="index.php">Home</a></li>
					<li><a href="index.php?p=list">Todo List</a></li>
				</ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if($_SESSION['loggedin']){?>
                        <li><a href="index.php?p=logout">Logout</a></li>
                    <?php }else{ ?>
                    <li><a href="index.php?p=login">Login</a></li>
                        <li><a href="index.php?p=register">Register</a></li>
                    <?php } ?>
                </ul>
			</div>
		</div>
	</nav>
