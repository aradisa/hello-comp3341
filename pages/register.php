<?php
    if(isset($_POST['email']) || isset($_POST['password'])){
        if(!$_POST['email'] || !$_POST['password']){
            $error = "Please enter an email and password";
        }
        
        if(strlen($_POST['password']) < 6){
            $passError = "Password is too short!";
        }
        
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $emailError = "Please enter valid email";
        }
        
        if(!$error && !$passError && !$emailError){
            //create encrypted password with salt
            $encryptedPass = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
            //insert into database
            $query = "INSERT INTO users (user_email, user_password) VALUES (:email, :password)";
            $result = $DBH->prepare($query);
            $result->bindParam(':email', $_POST['email']);
            $result->bindParam(':password', $encryptedPass);
            $result->execute();
            
            $to = $_POST['email'];
            $subject = "Welcome to our ToDo List";
            
            $message = "
                <html>
                <head>
                <title>Welcome to our ToDo List</title>
                </head>
                <body>
                <p>Welcome to our to do list application!</p>
                </body>
                </html>";
            
            $headers = "MIME-Version: 1.0"."\r\n";
            $headers.= "Content-type:text/html;charset=UTF-8"."\r\n";
            $headers.='FROM: <14010857@student.worc.ac.uk>'."\r\n";
            
            mail($to,$subject,$message,$headers);
            
            //my email for textlocal, need to register at home in order to get free credits
            $username = 'rada1_14@uni.worc.ac.uk';
            $hash = 'ba499d637d1c3640f4f62a70a354fc3f880e6cef';
            
            //message details
            $numbers = $_POST['mobile'];
            $sender = urlencode('ToDo List');
            $message = rawurlencode('Welcome to my to do list!');
            
            //prepare data for request
            $data = array('username' => $username, 'hash' =>  $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
            
            //send data with cURL
            $ch = curl_init('http://api.txtlocal.com/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            
            echo "<script>window.location.assign('index.php?p=registersuccess'); </script>";
        }
    }

//text local hash:     ba499d637d1c3640f4f62a70a354fc3f880e6cef 
?>
<div class="container">
    <h1>Register</h1>
    <form action="index.php?p=register" method="post">
        <?php if($error){
            echo '<div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            '.$error.'
            </div>';
}
    
            if($passError){
                echo '<div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                '.$passError.'
                </div>';
            }
                
            if($emailError){
            echo '<div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            '.$emailError.'
            </div>';
        }?>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="email">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="password">
        </div>
        <div class="form-group">
            <label for="text">Mobile Number</label>
            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="01234123123">
        </div>
        <button type="submit" class="btn btn-default">Register</button>
    </form>
</div>