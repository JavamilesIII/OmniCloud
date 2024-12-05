<?php
    $preis = $_GET['preis'];
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //if(isset)
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zahlung</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="post">
        <input id="ccn" type="tel" inputmode="numeric" pattern="[0-9\s]{13,19}" 
            autocomplete="cc-number" maxlength="19" 
            placeholder="xxxx xxxx xxxx xxxx" required>
            <!--<input type="date" name="" id="">-->
            <select name='expireMM' id='expireMM'>
                <option value=''>Month</option>
                <option value='01'>January</option>
                <option value='02'>February</option>
                <option value='03'>March</option>
                <option value='04'>April</option>
                <option value='05'>May</option>
                <option value='06'>June</option>
                <option value='07'>July</option>
                <option value='08'>August</option>
                <option value='09'>September</option>
                <option value='10'>October</option>
                <option value='11'>November</option>
                <option value='12'>December</option>
            </select> 
            <select name='expireYY' id='expireYY'>
                <option value=''>Year</option>
                <option value='20'>2020</option>
                <option value='21'>2021</option>
                <option value='22'>2022</option>
                <option value='23'>2023</option>
                <option value='24'>2024</option>
            </select> 
            <input class="inputCard" type="hidden" name="expiry" id="expiry" maxlength="4"/>
    </form>
</body>
</html>