<!DOCTYPE html>
<html>
	<head>
		<title>Portefeuille numérique</title>
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<link rel="stylesheet" href="https://getbootstrap.com/docs/3.3/dist/css/bootstrap.min.css">
	</head>
	<body>
		<header>
			 <nav class="navbar navbar-inverse navbar-fixed-top">
		      <div class="container">
		        <div class="navbar-header">
		          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		            <span class="sr-only">Toggle navigation</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		          </button>
		          <a class="navbar-brand" href="#">Portefeuille Numérique</a>
		        </div>
		        <div id="navbar" class="navbar-collapse collapse">
		          <ul class="nav navbar-nav">
		            <li class="active"><a href="#">Accueil</a></li>
		            <li><a href="#about">Inscription</a></li>
		            <li><a href="#contact">Connexion</a></li>
		          </ul>
		        </div>
		      </div>
		    </nav>
		</header>
		<article>
			<div class="container">
				<div class="row main">
					<div class="panel-heading">
		               <div class="panel-title text-center">
		               		<h1 class="title">Portefeuille Numérique</h1>
		               		<hr />
		               	</div>
		            </div> 
					<div class="main-login main-center">
						<form class="form-horizontal" method="post" action="#">
							
							<div class="form-group">
								<label for="name" class="cols-sm-2 control-label">Votre nom</label>
								<div class="cols-sm-10">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
										<input type="text" class="form-control" name="name" id="name"  placeholder="Entrez votre nom"/>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="login" class="cols-sm-2 control-label">Votre login</label>
								<div class="cols-sm-10">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
										<input type="text" class="form-control" name="login" id="login"  placeholder="Entrez votre login"/>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="cols-sm-2 control-label">Mot de passe</label>
								<div class="cols-sm-10">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
										<input type="password" class="form-control" name="password" id="password"  placeholder="Entrez votre mot de passe"/>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="confirm" class="cols-sm-2 control-label">Confirmez mot de passe</label>
								<div class="cols-sm-10">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
										<input type="password" class="form-control" name="confirm" id="confirm"  placeholder="Confirmez mot de passe"/>
									</div>
								</div>
							</div>

							<div class="form-group ">
								<button type="button" class="btn btn-primary btn-lg btn-block login-button">Inscription</button>
							</div>
							<div class="login-register">
					            <a href="index.php">Connexion</a>
					         </div>
						</form>
					</div>
				</div>
			</div>
		</article>
	</body>

</html>