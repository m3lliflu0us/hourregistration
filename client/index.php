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
                                                                           
$highlightId = '';                                                                           
if (isset($_GET['highlight'])) {                                                                           
    $highlightId = htmlspecialchars(urldecode($_GET['highlight']));                                                                           
}                                                                           
?>                                                                           
 
<!DOCTYPE html> 
<html lang="en"> 
 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Klanten | Gilde DevOps</title> 
    <link rel="stylesheet" href="client.css"> 
    <link rel="stylesheet" href="../assets/layout.css"> 
    <link rel="stylesheet" href="../assets/navbar.css"> 
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet"> 
 
    <style> 
    </style> 
</head> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
<script> 
    $(document).ready(function() { 
        $(".invoice-button").click(function() {
            var clientId = $(this).data('client-id');
            var assignmentId = $(this).data('assignment-id');
            $.ajax({
                url: 'generate_invoice.php',
                type: 'post',
                data: {
                    clientId: clientId,
                    assignmentId: assignmentId
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    var blob = new Blob([response], {
                        type: 'application/pdf'
                    });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "invoice_" + clientId + "_" + assignmentId + ".pdf";
                    link.click();
                },
                error: function() {
                    alert('Error generating invoice');
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
                <div class="client-container">
                    <div class="title-wrapper">
                        <span>Klanten</span>
                    </div>
                    <div class="client-registration-wrapper">
                        <div class="subheading-wrapper">
                            <span>Registreer een klant</span>
                        </div>
                        <form action="client.php" method="POST">
                            <div class="input-container">
                                <div class="input">
                                    <input type="text" id="clientFirstname" name="clientFirstname" value="" onkeyup="this.setAttribute('value', this.value);">
                                    <label for="clientFirstname">Klant voornaam</label>
                                </div>
                            </div>

                            <div class="input-container">
                                <div class="input">
                                    <input type="text" id="clientLastname" name="clientLastname" value="" onkeyup="this.setAttribute('value', this.value);">
                                    <label for="clientLastname">Klant achternaam</label>
                                </div>
                            </div>

                            <div class="input-container">
                                <div class="input">
                                    <input type="email" id="clientEmail" name="clientEmail" value="" onkeyup="this.setAttribute('value', this.value);">
                                    <label for="clientEmail">Klant E-mail</label>
                                </div>
                            </div>

                            <div class="input-container">
                                <div class="input">
                                    <input type="text" id="clientPhoneNumber" name="clientPhoneNumber" value="" onkeyup="this.setAttribute('value', this.value);">
                                    <label for="clientPhoneNumber">Telefoonnummer</label>
                                </div>
                            </div>

                            <div class="input-container">
                                <div class="input">
                                    <input type="text" id="companyName" name="companyName" value="" onkeyup="this.setAttribute('value', this.value);">
                                    <label for="companyName">Bedrijfsnaam</label>
                                </div>
                            </div>

                            <div class="input-container">
                                <div class="input">
                                    <input type="text" id="companyAddress" name="companyAddress" value="" onkeyup="this.setAttribute('value', this.value);">
                                    <label for="companyAddress">Adress(bedrijf)</label>
                                </div>
                            </div>

                            <div class="submit-button">
                                <input type="submit" value="Register Client">
                            </div>
                        </form>
                        <?php 
                        
                        echo $_SESSION["userId"];

                        ?>
                    </div>
                    <div class="client-list-wrapper">
                        <div class="subheading-wrapper">
                            <span>Alle klanten</span>
                        </div>
                        <?php
                        // Adjusted SQL query to select distinct clients without assignments
                        $sql = "SELECT DISTINCT client.clientFirstname, client.clientLastname, client.clientEmail, client.clientPhoneNumber, client.clientId, client.companyName, client.companyAddress FROM client";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='client-list-item'>";
                                echo "Voornaam: " . $row["clientFirstname"] . "<br>";
                                echo "Achternaam: " . $row["clientLastname"] . "<br>";
                                echo "E-mailadres: " . $row["clientEmail"] . "<br>";
                                echo "Telefoonnummer: " . $row["clientPhoneNumber"] . "<br>";
                                echo "Bedrijfsnaam: " . $row["companyName"] . "<br>";
                                echo "Adress(bedrijf): " . $row["companyAddress"] . "<br>";
                                echo "Opdrachtnaam: " . $row["assignmentName"] . "<br>";
                                echo "<button class='generate-invoice' data-client-id='". $row['clientId'] ."' data-assignment-id='". $row['assignmentId'] ."'>Factuur genereren</button>";
                                echo "</div>";
                            }
                        } else {
                            echo "Geen resultaten";
                        }

                        $conn->close();
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </main>
</body>

</html>