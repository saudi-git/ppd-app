<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<style>
		#myBtn {
			display: none;
			position: fixed;
			bottom: 20px;
			right: 30px;
			z-index: 99;
			border: none;
			outline: none;
			background-color: rgba(28, 28, 28, 0.5); /* Transparent background */
			cursor: pointer;
			width: 50px;
			height: 50px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			transition: background-color 0.3s, transform 0.3s;
			margin-bottom: 4px;
		}

		#myBtn i {
			color: white;
			font-size: 22px;
		}

		#myBtn:hover {
			background-color: rgba(0, 0, 0, 0.8); /* Slightly darker on hover */
			transform: scale(1.1);
		}
	</style>
</head>
<body>
	<button onclick="topFunction()" id="myBtn" title="Go to top">
		<i class="fas fa-arrow-up"></i>
	</button>

	<script>
		let mybutton = document.getElementById("myBtn");
		let lastScrollTop = 0;

		window.onscroll = function() {
			scrollFunction();
		};

		function scrollFunction() {
			let st = document.documentElement.scrollTop || document.body.scrollTop;
			if (st > lastScrollTop && st > 20) {
				// Scrolling down
				mybutton.style.display = "none";
			} else if (st < lastScrollTop && st > 20) {
				// Scrolling up
				mybutton.style.display = "block";
			}
			// Hide the button if the user is at the top of the page
			if (st <= 20) {
				mybutton.style.display = "none";
			}
			lastScrollTop = st <= 0 ? 0 : st; // For Mobile or negative scrolling
		}

		function topFunction() {
			window.scrollTo({
				top: 0,
				behavior: 'smooth' // Smooth scroll to top
			});
			// Hide the button immediately when clicked
			mybutton.style.display = "none";
		}
	</script>
</body>
</html>
