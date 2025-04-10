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



if ($result->num_rows > 0) {
    $current_post_id = null; 
    while ($row = $result->fetch_assoc()) {
        
        if ($row["post_id"] != $current_post_id) {
            if ($current_post_id !== null) {
                echo "</ul>"; 
            }

            //post1 comment1
            //post1 comment2
            //post1 comment3
            //post2 comment1
            //post2 comment2
            //post3

            $current_post_id = $row["post_id"];
            echo "<h2>" . $row["title"] . "</h2>";
            echo "<p>" . $row["content"] . "</p>";
            echo "<h3>Komentāri:</h3><ul>";
        }

       
        if ($row["comment_author"] && $row["comment_text"]) {
            echo "<li><strong>" . $row["comment_author"] . ":</strong> " . $row["comment_text"] . "</li>";
        }
    }
    echo "</ul>"; 
} else {
    echo "Nav atrasti raksti.";
}

$conn->close();





?>