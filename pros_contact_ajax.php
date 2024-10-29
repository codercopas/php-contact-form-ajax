<?php

	session_start();
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$name = htmlspecialchars($_POST['name']); $email = htmlspecialchars($_POST['email']); $message = htmlspecialchars($_POST['message']);
		
		$_SESSION['name'] = $name; $_SESSION['email'] = $email; $_SESSION['message'] = $message;
		
		$error = "";
		
		if (empty($name) || empty($email) || empty($message)) {
			$error = "Mohon isi semua field.";
		} else {
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				if(sendmail($name, $email, $message)) {
					echo "OKE|Terimakasih! Pesan anda berhasil dikirim.";
					exit();
				} else {
					$error = "Ada kesalahan dalam pengiriman email.";
				}
			} else {
				$error = "Mohon isi email dengan format yang benar";
			}
		}
		
		if($error!=="") {
			echo "ERR|" . $error;
			exit();
		}
	}
	
	function is_containing_non_english($input) {
		$ret = 0;
		if (preg_match('/^[a-zA-Z0-9\s.,!?\'"~\-()@:;]*$/', $input)) {
			$ret = 1;
		}
		return $ret;
	}
	
	function is_containing_url($input) {
		$ret = 0;
		if (preg_match('/https?:\/\//', $input)) {
			$ret = 1;
		}
		return $ret;
	}
	
	function sendmail($name, $email, $message) {
		$to = "contact@example.com"; 
		$subject = "Form Submission from $name";
		$body = "Name: $name\nEmail: $email\nMessage: $message";
		$headers = "From: $email";

		if (mail($to, $subject, $body, $headers)) {
			return true;
		} else {
			return false;
		}
	}
	
?>