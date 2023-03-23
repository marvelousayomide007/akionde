<?php 
    require_once('./classes/JWT.php');
        $jwt = (new JWT());
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JWT Authentication</title>
</head>
<body>
    <h1>JWT Authentication</h1>
    
    <?php
        
        $payload = [
            'id' => 1,
            'name' => 'Fortunatus Adegoke',
            'iss' => 'http://localhost/API_project/jwt/',
            'aud' => 'http://localhost/API_project'
        ];

        $token = $jwt->generate($payload);
        // echo $token ."<br>";
        if($jwt->is_valid($token)) {
            echo "is_valid <br>";
        }
    ?>
</body>
</html>

