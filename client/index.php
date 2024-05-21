<?php
    session_start();

    if (!isset($_SESSION["userId"])) {
        header("location: ../user/login.php");
        exit();
    }

    $currentPage = 'client';

    include("../db/dbh.inc.php");
    include("../config.php");
    include("../userincludes/userfunctions.inc.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" lang="en" content="width=device-width, initial-scale=1.0">
    <title>Klanten | Gilde DevOps</title>
    <link rel="stylesheet" href="client.css">
    <link rel="stylesheet" href="../assets/layout.css">
    <link rel="stylesheet" href="../assets/navbar.css">
    <link rel="stylesheet" href="clientc.css">
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $(".generate-invoice").click(function(){
        var clientId = $(this).data('client-id');
        $.ajax({
            url: 'generate_invoice.php',
            type: 'post',
            data: {clientId: clientId},
            xhrFields: {
                responseType: 'blob' // to handle a binary stream
            },
            success: function(response){
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "invoice.pdf";
                link.click();
            }
        });
    });
});
</script>
<body>
    <main>
        <?php include("../assets/navbar.php") ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-window">
                <div class="client-registration-wrapper">
                    <form action="client.php" method="POST">
                        <label for="clientFirstname">Klant voornaam</label>
                        <input type="text" id="clientName" name="clientFirstname">

                        <label for="clientLastname">Klant achternaam</label>
                        <input type="text" id="clientName" name="clientLastname">

                        <label for="ClientEmail">Klant E-mail</label>
                        <input type="email" id="clientEmail" name="clientEmail">

                        <label for="clientPhoneNumber">Telefoonnummer</label>
                        <input type="text" id="clientPhoneNumber" name="clientPhoneNumber">

                        <label for="companyName">Bedrijfsnaam</label>
                        <input type="text" id="companyName" name="companyName">

                        <label for="companyAddress">Adress(bedrijf)</label>
                        <input type="text" id="companyAddress" name="companyAddress">

                        <input type="submit" value="Register Client">
                    </form>
                </div>

                <div class="border">
                </div>

                <div class="client-list-wrapper">
                    <?php
                    $sql = "SELECT client.clientFirstname, client.clientLastname, client.clientEmail, client.clientPhoneNumber, client.clientId, client.companyName, client.companyAddress, assignment.assignmentName FROM client LEFT JOIN assignment ON client.clientId = assignment.clientId";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='client-list-item'>";
                            echo "First Name: " . $row["clientFirstname"] . "<br>";
                            echo "Last Name: " . $row["clientLastname"] . "<br>";
                            echo "Email: " . $row["clientEmail"] . "<br>";
                            echo "Phone Number: " . $row["clientPhoneNumber"] . "<br>";
                            echo "Company Name: " . $row["companyName"] . "<br>";
                            echo "Company Address: " . $row["companyAddress"] . "<br>";
                            echo "Assignment: " . $row["assignmentName"] . "<br>";
                            echo "<button class='generate-invoice' data-client-id='". $row['clientId'] ."'>Factuur genereren</button>";
                            echo "</div>";
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                </div>

            </div>
        </div>
    </main>
</body>

</html>
