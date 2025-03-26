<?php
	include 'konfiguracja.php';
	$haslo = hash("sha256", $_GET["pwd"]);
	$login = $_GET["lgn"];
	$conn = new mysqli($bazaAdres, $bazaLogin, $basaHaslo, $bazaNazwa);
	if ($conn->connect_error) {
	    die("Połączenie nieudane: " . $conn->connect_error);
	}
	$stmt = $conn->prepare("SELECT id FROM uzytkownicy WHERE login = ? AND haslo = ?");
	$stmt->bind_param("ss", $login, $haslo);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows == 1) {
		$stmt->close();
		$conn->close();
		setcookie('login', $login, time()+3600*24);
		setcookie('haslo', $haslo, time()+3600*24);
		header("Location: menu.php");
		die();
	}
	$stmt->close();
	$conn->close();
	header("Location: logowanie.php");
	die();
?>
