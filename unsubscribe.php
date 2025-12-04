<?php
if (isset($_POST['email'])) {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        header('location: unsubscribe.php?error=1');
        exit;
    }
    
    $email = $_POST['email'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $dater = date('Y-m-d h:i:s');
    
    
    $line = array($email, $ip, $dater);

    $handle = fopen("unsubs.csv", "a");
    fputcsv($handle, $line); # $line is an array of string values here
    fclose($handle);
    header('location: unsubscribe.php?success');
    exit;
}

?>
<style>
    body{
        margin:0;
    }
    * {
        font-size: 18px;
        font-family: Arial;
    }

    label {
        font-weight: bold;
    }

    .btn {
        margin-top: 10px;
        font-size: 25px;
    }

    .styler {
        font-size: 25px;
        padding: 5px 5px 5px 5px;
    }
</style>
<title>Try Aeterna Skin Unsubscribe</title>

<center>
    <div style=" width: 100%;
    background-color: crimson;
    height: 200px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;">
    <img src="images/aeterna_unsubs_logo.png" alt="aeternaskin" style="height:100px;"><br>

    </div>

    <!-- <div style="width: 100%;font-size:40px">Try Aeterna Skin Unsubscribe</div> -->
    <?php

    if (isset($_REQUEST['error']) && $_REQUEST['error'] == '1') {
        echo "<h1 style='color:#FF0000;'>Please Enter A Real Email</h1>";
    }
    if (isset($_REQUEST['success'])) {
        echo "<h1 style='color:green;'>You Have Been Removed</h1>";
    }
?>
    <form method="post" action="" style="margin-top: 100px;">
        <label>Email:</label><br>
        <input name="email"
            value="<?php echo isset($_REQUEST['emails']) ? $_REQUEST['emails'] : '' ?>"
            placeholder="Enter Email Address" class="styler"><br>
        <input type="submit" value="Remove Me From Your List" class='btn'>
    </form>
</center>