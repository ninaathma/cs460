<?php
    // ENVIRONMENT VARS
    $servername = "localhost";
    $dbname = "project1";
    $username = "root";
    $password = "";
    $dsn = "mysql:host=$servername;dbname=$dbname";

    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL
        $stmt = $conn->prepare("SELECT People.name, 
        Award.award_year - YEAR(People.dob) 'Age'
        FROM People 
        INNER JOIN Award ON Award.pid = People.id 
        INNER JOIN Role ON Role.pid = People.id AND Role.role_name = 'Actor' 
        WHERE People.dob = (SELECT MAX(People.dob) 
                            FROM People 
                            INNER JOIN Award ON Award.pid = People.id 
                            INNER JOIN Role ON Role.pid = People.id AND Role.role_name = 'Actor') 
            OR People.dob = (SELECT MIN(People.dob) as min_age 
                            FROM People 
                            INNER JOIN Award ON Award.pid = People.id 
                            INNER JOIN Role ON Role.pid = People.id 
                            AND Role.role_name = 'Actor') 
                            GROUP BY People.id;");
        $stmt->execute();

        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $query_results = $stmt->fetchAll();

    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;

   
    //$results = $_POST;
    echo json_encode($query_results);
?>
