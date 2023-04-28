<!DOCTYPE html>
<html>
<head>
	<title>Movie App</title>
	<script>
		function showSearchBar() {
			// Get the search bar element
			var searchBar = document.getElementById("search-bar");

			// Show the search bar
			searchBar.style.display = "block";
		}
	</script>
	<style>
		.back-to-home {
			position: fixed;
			bottom: 20px;
			right: 20px;
			background-color: #007bff;
			color: white;
			padding: 10px;
			border-radius: 5px;
			text-decoration: none;
			font-size: 16px;
			font-weight: bold;
			box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
			z-index: 1;
		}
	</style>
</head>
<body>
	<h1>Movie App</h1>
	<nav>
		<ul>
			<li><a href="movies.php">View Popular Movies</a></li>
			<li><a href="my_movies.php">My Movies</a></li>
			<li><a href="#" onclick="showSearchBar()">Search for a Movie</a></li>
		</ul>
	</nav>

	<!-- Search bar -->
	<div id="search-bar" style="display: none;">
		<h2>Search for a movie</h2>
		<form action="search.php" method="get">
			<input type="text" name="query" placeholder="Enter a movie title">
			<button type="submit">Search</button>
		</form>
	</div>

	<!-- Back to home button -->
	<a href="index.php" class="back-to-home">Back to Home</a>

</body>
</html>
