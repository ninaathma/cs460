<?php
    // ENVIRONMENT VARS
    $servername = "localhost";
    $dbname = "project1";
    $username = "root";
    $password = "";
    $dsn = "mysql:host=$servername;dbname=$dbname";
    
    $l_selected = $_GET['likecount_selected'];
    $a_selected = $_GET['age_selected'];
    $results = [];
    
    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
        $age_condition = isset($a_selected) && !empty($a_selected)? " Registered_User.age < '{$a_selected}'" : '';
        $likes_condition = isset($l_selected) && !empty($l_selected)? " COUNT(Likes.mpid) > '{$l_selected}'" : '';


        $query = "SELECT COUNT(Likes.mpid) AS 'Likes',
        MotionPicture.name
        FROM MotionPicture
        INNER JOIN Movie ON Movie.mpid = MotionPicture.id
        INNER JOIN Likes ON Likes.mpid = MotionPicture.id
        INNER JOIN Registered_User ON Registered_User.email = Likes.uemail AND {$age_condition}
        GROUP BY MotionPicture.id
        HAVING {$likes_condition};";
        
        $stmt = $conn->prepare($query);
        
        $stmt->execute();

        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $results = $stmt->fetchAll(); 

    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;

   
    //$results = $_POST;
    echo json_encode($results);
?>