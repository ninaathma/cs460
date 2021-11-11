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
        $stmt = $conn->prepare("select MotionPicture.name, PeopleCount, RoleCount
        from MotionPicture, (select Role.mpid, count(Role.mpid) PeopleCount from Role, Movie where Role.mpid=Movie.mpid group by Role.mpid) as A
        NATURAL JOIN (select B.mpid, count(*) RoleCount from (select Role.mpid, Role.role_name, count(*) from Role, Movie where Role.mpid=Movie.mpid group by Role.mpid, Role.role_name) as B group by B.mpid) as C
        WHERE MotionPicture.id=mpid
        ORDER BY PeopleCount DESC
        LIMIT 5;");

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