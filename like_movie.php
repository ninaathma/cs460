<?php
    // ENVIRONMENT VARS
    $servername = "localhost";
    $dbname = "project1";
    $username = "root";
    $password = "";
    $dsn = "mysql:host=$servername;dbname=$dbname";
    $mpid = $_GET['mpid'];
    $email = $_GET['email'];
    $query_results = [];

    if(isset($mpid) && !empty($mpid) && isset($email) && !empty($email)) {
        try {
            $conn = new PDO($dsn, $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL
            $stmt = $conn->prepare("INSERT INTO Likes (mpid, uemail)
            VALUES ($mpid, '$email');");
            $stmt->execute();

            // set the resulting array to associative
            // $stmt->setFetchMode(PDO::FETCH_ASSOC);
            // $query_results = $stmt->fetchAll();

            $query_results = "INSERT INTO Likes (mpid, uemail)
            VALUES ($mpid, '$email');";
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;
    } else {
        $query_results['error_message'] = "Invalid mpid or email";
    }

   
    echo json_encode($query_results);
?>
