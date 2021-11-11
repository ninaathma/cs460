<?php
    $servername = "localhost";
    $dbname = "project1";
    $username = "root";
    $password = "";
    $dsn = "mysql:host=$servername;dbname=$dbname";
    
    // connect to database
    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL
        $stmt = $conn->prepare("SELECT People.name, MarvelMovie 'Marvel Movie', WarnerBrosMovie 'Warner Bros Movie'
        FROM People, ((SELECT Role.pid, MotionPicture.name as 'MarvelMovie' FROM Role, MotionPicture WHERE Role.mpid=MotionPicture.id and Role.role_name='Actor' and MotionPicture.production='Marvel') as A) 
          INNER JOIN ((SELECT Role.pid, MotionPicture.name as 'WarnerBrosMovie' FROM Role, MotionPicture WHERE Role.mpid=MotionPicture.id and Role.role_name='Actor' and MotionPicture.production='Warner Bros') as B) 
            ON (A.pid=B.pid)
        WHERE People.id=A.pid;");

        $stmt->execute();

        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $results = $stmt->fetchAll();

    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    
    // convert to JSON and output   
    echo json_encode( $results);   
   
?>