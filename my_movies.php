<?php
// Connect to the database
$conn = mysqli_connect('localhost', 'myuser', 'Vodkabecks1!', 'my_movies');

// Check for errors in the connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

// Check if the delete button was clicked for a movie
if (isset($_POST['delete_movie'])) {
  $movie_id = $_POST['movie_id'];
  $sql = "DELETE FROM seen_movies WHERE movie_id = $movie_id";
  mysqli_query($conn, $sql);
}

// Query the database for the seen movies
$sql = "SELECT DISTINCT movie_id, title, poster_path FROM seen_movies";
$result = mysqli_query($conn, $sql);

// Render HTML
echo "<html>";
echo "<head><title>My Movies</title>";
echo "<style>";
echo "ul {list-style-type: none; margin: 0; padding: 0;}";
echo "li {display: inline-block; width: 30%; margin: 10px; text-align: center; position: relative;}";
echo "a {text-decoration: none; color: black;}";
echo "a:hover {text-decoration: underline;}";
echo "h1 {text-align: center;}";
echo "body {background-color: #4B4E6D; color: white;}";
echo "button {position: absolute; top: 5px; right: 5px; border: none; background-color: transparent; color: red; font-size: 30px;}";
echo ".grey-box {background-color: #DCDCDC; padding: 10px; display: inline-block;}";
echo ".grey-box a {text-decoration: none; color: black;}";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<h1>My Movies</h1>";

include 'back-to-home.php';
echo "<ul>";
while ($row = mysqli_fetch_assoc($result)) {
  echo "<li>";
  echo "<a href='https://www.themoviedb.org/movie/{$row['movie_id']}' target='_blank'>";
  echo "<img src='https://image.tmdb.org/t/p/w200{$row['poster_path']}' alt='{$row['title']}' width='200'>";
  echo "</a>";
  echo "<form method='post'>";
  echo "<input type='hidden' name='movie_id' value='{$row['movie_id']}'>";
  echo "<button type='submit' name='delete_movie'><span>&#x2715;</span></button>";
  echo "</form>";
  echo "<div>{$row['title']}</div>";
  echo "</li>";
}
echo "</ul>";
echo "</body>";
echo "</html>";

// Close the database connection
mysqli_close($conn);
