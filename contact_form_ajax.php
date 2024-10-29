<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Contact Form</title>
		<style>
			body {
				display: flex;
				justify-content: center;
				align-items: center;
				height: 100vh;
				margin: 0;
				font-family: Arial, sans-serif;
				background-color: #f0f0f0;
			}
			.contact-form {
				background-color: #fff;
				padding: 20px;
				border-radius: 8px;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
				width: 100%;
				max-width: 400px;
			}
			.contact-form h1 {
				margin-top: 0;
				background: #D4F8FF;
				padding: 10px;
				text-align: center;
				border: 1px solid #ccc;
			}
			.contact-form label {
				display: block;
				margin-bottom: 8px;
			}
			
			.contact-form input,
			.contact-form textarea {
				width: 95%;
				padding: 10px;
				margin-bottom: 16px;
				border: 1px solid #ccc;
				border-radius: 4px;
			}
			.contact-form input[type="submit"] {
				background-color: #4CAF50;
				color: white;
				border: none;
				cursor: pointer;
				width:100%;
			}
			.contact-form input[type="submit"]:hover {
				background-color: #45a049;
			}
			
			#loader-block {
				text-align: center;
				display: none;
			}
			
			#loader-block img {
				width: 90px;
			}
			
			#success-block {
				padding: 20px;
				text-align: center;
				color: green;
				display: none;
			}
			
			#error-block {
				border: 1px solid red;
				padding: 20px;
				text-align: center;
				color: red;
				display: none;
			}
			
			#kirim-lagi {
				text-align: center;
				display: none;
			}
		</style>
	</head>
<body>
	<div class="contact-form">
			<h1>Contact Us</h1>
			<div id="form-block">
				<form id="contact-form" method="post">
					<label for="name">Name:</label>
					<input type="text" id="name" name="name">
					
					<label for="email">Email:</label>
					<input type="email" id="email" name="email">
					
					<label for="message">Message:</label>
					<textarea id="message" name="message" rows="5"></textarea>
					
					<input id="btn-submit" type="submit" value="Submit">
				</form>
			</div>
			
			<div id="loader-block">
				<p><img src="resources/loading.gif" alt="Loader Animation" /></p>
				<p>Mohon Tunggu</p>
			</div>
			
			<div id="success-block">
				<p>Pesan berhasil dikirim</p>
			</div>
			
			<div id="error-block">
				<p>Pesan gagal dikirim</p>
			</div>
			
			<div id="kirim-lagi">
				<p><a href="#">KIRIM LAGI</a></p>
			</div>
	</div>
	
	<script>
		var formBlock = document.getElementById("form-block");
		var successBlock = document.getElementById("success-block");
		var errorBlock = document.getElementById("error-block");			
		var loaderBlock = document.getElementById("loader-block");
		var kirimLagi = document.getElementById("kirim-lagi");
		var theForm = document.getElementById("contact-form");
		
		document.getElementById("kirim-lagi").addEventListener("click", function(event) {
			kirimLagi.style.display = "none";
			successBlock.style.display = "none";
			formBlock.style.display = "block";
			theForm.reset();
		});
		
		document.getElementById('contact-form').addEventListener('submit', function(event) {
			event.preventDefault();
			
			formBlock.style.display = "none";
			successBlock.style.display = "none";
			errorBlock.style.display = "none";
			loaderBlock.style.display = "block";
			
			var formData = new FormData(this);
			
			var xhr = new XMLHttpRequest();			
			xhr.open('POST', 'pros_contact_ajax.php', true);
			xhr.timeout = 3000;
			
	
			xhr.onload = function() {
				console.log(xhr.status);
				console.log(xhr.responseText);
				
				if (xhr.status === 200) {
					var ret = xhr.responseText.split("|");
					if(ret[0] == "OKE") {
						successBlock.innerHTML  = ret[1];
						successBlock.style.display = "block";
						loaderBlock.style.display = "none";
						kirimLagi.style.display = "block";
					}
					else {
						errorBlock.innerHTML  = ret[1];
						errorBlock.style.display = "block";
						loaderBlock.style.display = "none";
						formBlock.style.display = "block";
					}
				} else {
					// Handle errors based on status code
					errorBlock.innerHTML  = xhr.responseText;
					errorBlock.style.display = "block";
					loaderBlock.style.display = "none";
				}
			}
			
			// This will be called if the request fails
			xhr.onerror = function() {
				errorBlock.innerHTML  = "Network Error: Tidak bisa menghubungi server.<br><small>(Mohon tunggu beberapa saat sebelum mencoba lagi)</small>";
				errorBlock.style.display = "block";
				loaderBlock.style.display = "none";
				formBlock.style.display = "block";
			};

			// This will be called if the request times out
			xhr.ontimeout = function() {
				errorBlock.innerHTML  = "Request Timeout.<br><small>(Mohon tunggu beberapa saat sebelum mencoba lagi)</small>";
				errorBlock.style.display = "block";
				loaderBlock.style.display = "none";
				formBlock.style.display = "block";
			};
			
			setTimeout(function() {
				xhr.send(formData);
			}, 1000);
		});
	</script>
</body>
</html>






















