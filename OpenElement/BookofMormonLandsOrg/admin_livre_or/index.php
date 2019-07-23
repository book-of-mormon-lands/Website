
			<?php
			session_start();

			if(isset($_SESSION["adminOk"])){
				header("location:admin.php");
			}

			if(isset($_POST["go"])){
				$pattern = array("\""=>"");

				$login = strtr($_POST["login"],$pattern);
				$pass  = strtr($_POST["pass"],$pattern);
				$ok    = true;

				if(empty($login)){
					$ok = false;
					$message1 = "Veuillez entrer un identifiant";
				}
				if(empty($pass)){
					$ok = false;
					$message2 = "Veuillez entrer un mot de passe";
				}

				//Verification
				if($ok){
					$contenu = file("info_connexion.php");
					$contenu = explode(":",$contenu[0]);

					$loginDoc = $contenu[0];
					$passDoc  = $contenu[1];

					$loginOk  = hash("sha512",$login);
					$passOk   = hash("sha512",$pass);
					if(($loginOk == $loginDoc)&&($passOk == $passDoc)){
						$_SESSION["adminOk"] = 1;
						header("location:admin.php");
					}else{
						$message3 = "Identifiant ou mot de passe incorrect.";
					}
				}

			}
			?>
			<!doctype html>
			<html>
			<head>
			<meta charset="utf-8">
			<title>Connexion</title>
			</head>

			<body>
				<h1>Connexion à l'administration du livre d'or</h1>

				<div class="wrap">
					<?php if(isset($message3)) echo "<p class=\"alerte\">$message3</p>" ?>
					<form action="index.php" method="post">
						<p>
						<label for="login">Votre identifiant : </label>
						<input type="text" name="login" id="login"
						<?php if(isset($login)) echo "value=\"$login\"" ?>
						>
						<?php if(isset($message1)) echo "<span>$message1</span>" ?>
						</p>

						<p>
						<label for="pass">Votre identifiant : </label>
						<input type="password" name="pass" id="pass"
						<?php if(isset($pass)) echo "value=\"$pass\"" ?>
						>
						<?php if(isset($message2)) echo "<span>$message2</span>" ?>
						</p>

						<p><input type="submit" name="go" id="go" value="Connexion"></p>
					</form>
				</div>
			</body>
			</html>

		