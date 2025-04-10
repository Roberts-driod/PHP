<?php

$host = "localhost";
$username = "user27032025";
$password = "password";
$dbname = "php27032025";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Savienojuma neveiksme: " . $conn->connect_error);
}

$sql = "SELECT posts.*, comments.author AS comment_author, comments.comment AS comment_text 
        FROM posts 
        LEFT JOIN comments ON posts.post_id = comments.post_id";
$result = $conn->query($sql);

$posts = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $post_id = $row["post_id"];
        
        // Ja raksts vēl nav masīvā, pievienojam to
        if (!isset($posts[$post_id])) {
            $posts[$post_id] = [
                "title" => $row["title"],
                "content" => $row["content"],
                "comments" => []
            ];
        }

        // Ja komentārs pastāv, pievienojam to komentāru masīvam
        if ($row["comment_author"] && $row["comment_text"]) {
            $posts[$post_id]["comments"][] = [
                "author" => $row["comment_author"],
                "text" => $row["comment_text"]
            ];
        }
    }
    
    // Tagad izvadīsim datus kā HTML hierarhisku sarakstu
    foreach ($posts as $post) {
        echo "<h2>" . $post["title"] . "</h2>";
        echo "<p>" . $post["content"] . "</p>";
        echo "<h3>Komentāri:</h3><ul>";
        
        // Pievienojam komentārus, ja tie ir
        foreach ($post["comments"] as $comment) {
            echo "<li><strong>" . $comment["author"] . ":</strong> " . $comment["text"] . "</li>";
        }

        echo "</ul>";
    }
} else {
    echo "Nav atrasti raksti.";
}

$conn->close();

?>
