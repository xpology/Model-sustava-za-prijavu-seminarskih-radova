<?php 
	include 'configuration.php';

	// DEKLARACIJA VARIJABLI
	$id = "";
	$title = "";
	$fname = "";
	$lname = "";
	$email = "";
	$value = "";
	$date = "";
	$username = "";
	$errors = array(); 

	// POVEZIVANJE S BAZOM
	$db = mysqli_connect('localhost', 'root', '', 'registration');
	mysqli_set_charset($db, "utf8");

	// REGISTRIRANJE KORISNIKA
	if (isset($_POST['reg_user'])) {
		// ZAPRIMI SVE ULAZNE VRIJEDNOSTI IZ OBRASCA
		$fname = mysqli_real_escape_string($db, $_POST['fname']);
		$lname = mysqli_real_escape_string($db, $_POST['lname']); 
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$groups = mysqli_real_escape_string($db, $_POST['groups']);
		$status = mysqli_real_escape_string($db, $_POST['status']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

		// PROVJERA VALJANOSTI OBRASCA
		if (empty($fname)) { array_push($errors, "Potrebno unijeti ime!"); }
		if (empty($lname)) { array_push($errors, "Potrebno unijeti prezime!"); }
		if (empty($email)) { array_push($errors, "Potrebno unijeti email!"); }
		if (empty($groups)) { array_push($errors, "Potrebno odabrati grupu!"); }
		if (empty($status)) { array_push($errors, "Potrebno odabrati status!"); }
		
		$query = "SELECT * FROM users WHERE email='$email'";
		$results = mysqli_query($db, $query);
		if (mysqli_num_rows($results) != 0) { array_push($errors, "Email se već koristi!"); }

		if (empty($password_1)) { array_push($errors, "Potrebno unijeti lozinku!"); }
		if (strlen($password_1) < 6) { array_push($errors, "Lozinka treba sadržavati minimalno 6 znakova!"); }
		if ($password_1 != $password_2) {
			array_push($errors, "Lozinke se ne podudaraju!"); }

		// REGISTRIRAJ KORISNIKA AKO U OBRASCU NEMA GREŠAKA
		if (count($errors) == 0) {
			$password = md5($password_1);//ŠIFRIRAJ LOZINKU PRIJE SPREMANJA U BAZU
			$query = "INSERT INTO users (fname, lname, email, groups, status, password) 
					  VALUES('$fname', '$lname', '$email', '$groups', '$status', '$password')";
			mysqli_query($db, $query);

			header('location: login.php'); //PREUSMJERI NA STRANICU ZA LOGIRANJE

		}

	}


	// LOGIRANJE KORISNIKA
	if (isset($_POST['login_user'])) {
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		// PROVJERA VALJANOSTI OBRASCA
		if (empty($email)) { array_push($errors, "Potreban email"); }
		if (empty($password)) { array_push($errors, "Potrebna lozinka"); }

		//LOGIRAJ KORSINIKA UKOLIKO POSTOJI KORISNIK S TIM PODACIMA U BAZI
		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
			$results = mysqli_query($db, $query);
			$row = mysqli_fetch_assoc($results);

			if (mysqli_num_rows($results) == 1) {
				$_SESSION['email'] = $email;
				$_SESSION['groups'] = $groups;
				$_SESSION['id'] = $row['id'];

				$query = $con->prepare("SELECT teamid FROM teammembers WHERE userId = :userId;");
				$query->bindParam(":userId", $_SESSION["id"]);
				$query->execute();
				$result = $query->fetch(PDO::FETCH_OBJ);

				if($result != null){
					$_SESSION["teamid"] = $result->teamid;
					header('location: home.php'); //PREUSMJERI NA POČETNU STRANICU
				} 

				else {
					header("location: teams.php"); //PREUSMJERI NA KREIRANJE TIMOVA
				}
			}

			else {
				array_push($errors, "email/lozinka netočna");
			}
		}
	}

	// REGISTRIRANJE ADMINA
	if (isset($_POST['reg_admin'])) {
		// ZAPRIMI SVE ULAZNE VRIJEDNOSTI IZ OBRASCA
		$fname = mysqli_real_escape_string($db, $_POST['fname']);
		$lname = mysqli_real_escape_string($db, $_POST['lname']); 
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

		// PROVJERA VALJANOSTI OBRASCA
		if (empty($fname)) { array_push($errors, "Potrebno unijeti ime!"); }
		if (empty($lname)) { array_push($errors, "Potrebno unijeti prezime!"); }
		if (empty($username)) { array_push($errors, "Potrebno unijeti korisničko ime!"); }
				
		$query = "SELECT * FROM admins WHERE username='$username'";
		$results = mysqli_query($db, $query);
		if (mysqli_num_rows($results) != 0) { array_push($errors, "Korisničko ime već postoji!"); }

		if (empty($password_1)) { array_push($errors, "Potrebno unijeti lozinku!"); }
		if (strlen($password_1) < 6) { array_push($errors, "Lozinka treba sadržavati minimalno 6 znakova!"); }
		if ($password_1 != $password_2) {
			array_push($errors, "Lozinke se ne podudaraju!"); }

		// REGISTRIRAJ ADMINA AKO U OBRASCU NEMA GREŠAKA
		if (count($errors) == 0) {
			$password = md5($password_1);//ŠIFRIRAJ LOZINKU PRIJE SPREMANJA U BAZU
			$query = "INSERT INTO admins (fname, lname, username, password) 
					  VALUES('$fname', '$lname', '$username', '$password')";
			mysqli_query($db, $query);

			header('location: registerAdmin.php');

		}

	}

	//LOGIRANJE ADMINA
	if (isset($_POST['login_admin'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		// PROVJERA VALJANOSTI OBRASCA
		if (empty($username)) { array_push($errors, "Potrebno korisničko ime"); }
		if (empty($password)) { array_push($errors, "Potrebna lozinka"); }

		//LOGIRAJ ADMINA UKOLIKO POSTOJI ADMIN S TIM PODACIMA U BAZI
		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
			$results = mysqli_query($db, $query);
			$row = mysqli_fetch_assoc($results);

			if (mysqli_num_rows($results) == 1) {
				$_SESSION['username'] = $username;
				$_SESSION['id'] = $row['id'];
				header("location: topicAdmin.php"); //PREUSMJERI NA KREIRANJE TEMA
			}

			else {
				array_push($errors, "Korisničko ime/lozinka netočna");
			}
		}
	}

	// AŽURIRANJE ADMINA
	if (isset($_POST['update_admin'])) {
		// ZAPRIMI SVE ULAZNE VRIJEDNOSTI IZ OBRASCA
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password_old = mysqli_real_escape_string($db, $_POST['password_old']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

		// PROVJERA VALJANOSTI OBRASCA
		if (empty($username)) { array_push($errors, "Potrebno unijeti novo korisničko ime!"); }
				
		$query = "SELECT * FROM admins WHERE username='$username'";
		$results = mysqli_query($db, $query);
		if (mysqli_num_rows($results) != 0) { array_push($errors, "Korisničko ime već postoji!"); }

		$pass_old = md5($password_old);
		$query = "SELECT * FROM admins WHERE password='$pass_old'";
		$pass = mysqli_query($db, $query);
		if (mysqli_num_rows($pass) != 1) { array_push($errors, "Neispravna stara lozinka!"); }

		if (empty($password_1)) { array_push($errors, "Potrebno unijeti novu lozinku!"); }
		if (strlen($password_1) < 6) { array_push($errors, "Nova lozinka treba sadržavati minimalno 6 znakova!"); }
		if ($password_1 != $password_2) {
			array_push($errors, "Lozinke se ne podudaraju!"); }

		// AŽURIRAJ ADMINA AKO U OBRASCU NEMA GREŠAKA
		if (count($errors) == 0) {
			$password = md5($password_1);//ŠIFRIRAJ LOZINKU PRIJE SPREMANJA U BAZU
			$query = "UPDATE admins SET username='$username', password='$password' WHERE id=1";
			mysqli_query($db, $query);

			header('location: registerAdmin.php');

		}

	}

	// UNESI TEMU U BAZU
	if (isset($_POST['reg_topic'])) {
		// ZAPRIMI SVE ULAZNE VRIJEDNOSTI IZ OBRASCA
		$title = mysqli_real_escape_string($db, $_POST['title']);

		// PROVJERA VALJANOSTI OBRASCA
		if (empty($title)) { array_push($errors, "Potrebno unijeti naziv teme!"); }
		
		$query = "SELECT * FROM topics WHERE title='$title'";
		$results = mysqli_query($db, $query);
		if (mysqli_num_rows($results) != 0) { array_push($errors, "Tema s tim nazivom postoji!"); }

		// SPREMI TEMU AKO U OBRASCU NEMA GREŠAKA
		if (count($errors) == 0) {
			$query = "INSERT INTO topics (title) 
					  VALUES('$title')";
			mysqli_query($db, $query);
		}

	}

	// UNESI DATUM U BAZU
	if (isset($_POST['save_dates'])) {
		// ZAPRIMI SVE ULAZNE VRIJEDNOSTI IZ OBRASCA
		$date = mysqli_real_escape_string($db, $_POST['dates']);

		// PROVJERA VALJANOSTI OBRASCA
		if (empty($date)) { array_push($errors, "Potrebno unijeti termin izlaganja!"); }
		
		$query = "SELECT * FROM dates WHERE dates='$date'";
		$results = mysqli_query($db, $query);
		if (mysqli_num_rows($results) != 0) { array_push($errors, "Termin izlaganja s tim datumom postoji!"); }

		// SPREMI TEMU AKO U OBRASCU NEMA GREŠAKA
		if (count($errors) == 0) {
			$query = "INSERT INTO dates (dates) 
					  VALUES('$date')";
			mysqli_query($db, $query);
		}

	}

	// MAKSIMALNI BROJ ČLANOVA
	if (isset($_POST['value'])) {
		$value = mysqli_real_escape_string($db, $_POST['maxTeamMembers']);

		// PROVJERA VALJANOSTI OBRASCA
		if (empty($value)) { array_push($errors, "Potrebno unijeti broj"); }

		if (count($errors) == 0) {
			$query = "UPDATE settings SET value='".$_POST['maxTeamMembers']."'";
			mysqli_query($db, $query);
		}
	}

	// BRISANJE IZ TOPICS TABLICE
	if(isset($_POST["del_topic"])) {
		$box=$_POST['num'];
		while (list ($key, $val) = @each ($box)) {
			mysqli_query($db, "DELETE FROM topics WHERE id=$val");
		}
	}

	// BRISANJE IZ DATES TABLICE
	if(isset($_POST["del_dates"])) {
		$box=$_POST['num'];
		while (list ($key, $val) = @each ($box)) {
			mysqli_query($db, "DELETE FROM dates WHERE id=$val");
		}
	}

	// BRISANJE IZ USERS TABLICE
	if(isset($_POST["del_users"])) {
		$box=$_POST['users'];
		while (list ($key, $val) = @each ($box)) {
			mysqli_query($db, "DELETE FROM users WHERE id=$val");
		}
	}

	// BRISANJE IZ ADMINS TABLICE
	if(isset($_POST["del_admin"])) {
		$box=$_POST['admins'];
		while (list ($key, $val) = @each ($box)) {
			mysqli_query($db, "DELETE FROM admins WHERE id=$val");
		}
	}

	//BRISANJE IZ TEAMTOPICS TABLICE
	if(isset($_POST["del_teamtopic"])) {
		$box=$_POST['topics'];
		while (list ($key, $val) = @each ($box)) {
			mysqli_query($db, "DELETE FROM teamtopics WHERE id=$val");
		}
	}

	//BRISANJE IZ TEAMMEMBERS TABLICE
	if(isset($_POST["del_teammembers"])) {
		$box=$_POST['teammembers'];
		while (list ($key, $val) = @each ($box)) {
			mysqli_query($db, "DELETE FROM teammembers WHERE id=$val");
		}
	}

	//BRISANJE IZ TEAMS TABLICE
	if(isset($_POST["del_teams"])) {
		$box=$_POST['teams'];
		while (list ($key, $val) = @each ($box)) {
			mysqli_query($db, "DELETE FROM teams WHERE id=$val");
		}
	}

	//BRISANJE IZ TEAMTOPICS TABLICE
	if(isset($_POST["del_teamdate"])) {
		$box=$_POST['dates'];
		while (list ($key, $val) = @each ($box)) {
			mysqli_query($db, "DELETE FROM teamdates WHERE id=$val");
		}
	}

?>