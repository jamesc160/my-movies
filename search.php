<?php
if (isset($_GET['query'])) {
  $query = urlencode($_GET['query']);
  $api_key = "62d9e03ec374f8c75dcee152c64bcc50";
  $url = "https://api.themoviedb.org/3/search/movie?api_key=$api_key&query=$query";
  $response = file_get_contents($url);
  $movies = json_decode($response, true)['results'];

  echo "<html>";
echo "<head><title>Search Results</title>";
echo "<style>";
echo "ul {list-style-type: none; margin: 0; padding: 0;}";
echo "li {display: inline-block; width: 30%; margin: 10px; text-align: center;}";
echo "a {text-decoration: none; color: black; font-size: 18px;}";
echo "a:hover {text-decoration: underline;}";
echo "h1 {text-align: center; color: white; font-size: 36px;}";
echo "body {background-color: #4B4E6D; color: white;}";
echo ".mymovies-link {display: block; margin-bottom: 10px; color: white; font-size: 18px;}";
echo ".mymovies-link:hover {text-decoration: underline;}";
echo "</style>";
echo "</head>";
echo "<body>";

echo "<h1>Search Results</h1>";
echo "<a href='my_movies.php' class='mymovies-link'>Movies I've Seen</a>";
echo "<form method='POST'>";
echo "<ul>";
foreach ($movies as $movie) {
  // Check if the movie has a poster image
  if ($movie["poster_path"]) {
    // Build the full image URL
    $poster_url = "https://image.tmdb.org/t/p/w185{$movie["poster_path"]}";

    // Render the movie title and poster as a link to the movie's page
    echo "<li>";
    echo "<a href=\"https://www.themoviedb.org/movie/{$movie["id"]}\">{$movie["title"]}</a><br>";
    echo "<img src=\"{$poster_url}\"><br>";
    echo "<label><input type='checkbox' name='seen[]' value='{$movie["id"]}'> Seen it</label>";
    echo "</li>";
  } else {
    // If there is no poster image, just render the movie title
    echo "<li>" . $movie["title"] . "</li>";
  }
}
echo "</ul>";

include 'back-to-home.php';
echo "<button type='submit' name='submit'>Save seen movies</button>";
echo "</form>";
echo "</body>";
echo "</html>";



  // Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["seen"])) {
      $seen_movies = $_POST["seen"];
      foreach ($seen_movies as $movie_id) {
        // Fetch the movie details from the API
        $movie_url = "https://api.themoviedb.org/3/movie/{$movie_id}?api_key={$api_key}";
        $movie_data = file_get_contents($movie_url);
        $movie = json_decode($movie_data, true);
  
        // Insert the movie into the database
        $conn = mysqli_connect('localhost', 'myuser', 'Vodkabecks1!', 'my_movies');
        $sql = "INSERT INTO seen_movies (movie_id, title, poster_path) SELECT ?, ?, ? WHERE NOT EXISTS (SELECT * FROM seen_movies WHERE movie_id = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $movie_id, $movie["title"], $movie["poster_path"], $movie_id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
      }
    }
  }
}