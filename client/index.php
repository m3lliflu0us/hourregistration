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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klanten | Gilde DevOps</title>
    <link rel="stylesheet" href="client.css">
    <link rel="stylesheet" href="../assets/layout.css">
    <link rel="stylesheet" href="../assets/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <script>
        $(document).ready(function() {
            $(".generate-invoice").click(function() {
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
    <main>
        <?php include("../assets/navbar.php") ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-window">

                <div class="client-wrapper">
                    <div class="client-title">
                        <span>Klanten</span>
                    </div>

                    <div class="client-registration-wrapper">
                        <form action="client.php" method="POST">
                            <div class="client-registration-title-wrapper">
                                <span>Registreer een klant</span>
                            </div>
                            <div class="input-field-wrapper">
                                <input type="text" id="clientFirstname" name="clientFirstname" value="" onkeyup="this.setAttribute('value', this.value);">
                                <label for="clientFirstname">Klant voornaam</label>
                            </div>

                            <div class="input-field-wrapper">
                                <input type="text" id="clientLastname" name="clientLastname" value="" onkeyup="this.setAttribute('value', this.value);">
                                <label for="clientLastname">Klant achternaam</label>
                            </div>

                            <div class="input-field-wrapper">
                                <input type="email" id="clientEmail" name="clientEmail" value="" onkeyup="this.setAttribute('value', this.value);">
                                <label for="clientEmail">Klant E-mail</label>
                            </div>

                            <div class="input-field-wrapper">
                                <input type="text" id="clientPhoneNumber" name="clientPhoneNumber" value="" onkeyup="this.setAttribute('value', this.value);">
                                <label for="clientPhoneNumber">Telefoonnummer</label>
                            </div>

                            <div class="input-field-wrapper">
                                <input type="text" id="companyName" name="companyName" value="" onkeyup="this.setAttribute('value', this.value);">
                                <label for="companyName">Bedrijfsnaam</label>
                            </div>

                            <div class="input-field-wrapper">
                                <input type="text" id="companyAddress" name="companyAddress" value="" onkeyup="this.setAttribute('value', this.value);">
                                <label for="companyAddress">Adress(bedrijf)</label>
                            </div>

                            <div class="register">
                                <input type="submit" value="Registreer klant">
                            </div>
                        </form>
                    </div>

                    <div class="client-list-wrapper">

                        <div class="client-list-title-wrapper">
                            <span>Alle klanten</span>
                        </div>
                        <?php
                        $sql = "SELECT client.clientFirstname, client.clientLastname, client.clientEmail, client.clientPhoneNumber, client.clientId, client.companyName, client.companyAddress, assignment.assignmentName, assignment.assignmentId FROM client LEFT JOIN assignment ON client.clientId = assignment.clientId";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='client-list-item'>";
                                echo "<span>Naam: " . $row["clientFirstname"] . " " . $row["clientLastname"] . "</span>";
                                echo "<span>E-mailadres: " . $row["clientEmail"] . "</span>";
                                echo "<span>Telefoonnummer: " . $row["clientPhoneNumber"] . "</span>";
                                echo "<span>Bedrijfsnaam: " . $row["companyName"] . "</span>";
                                echo "<span>Adress(bedrijf): " . $row["companyAddress"] . "</span>";
                                echo "<span>Opdrachtnaam: " . $row["assignmentName"] . "</span>";
                                echo "<div class='generateInvoice'><button data-client-id='" . $row['clientId'] . "' data-assignment-id='" . $row['assignmentId'] . "'>Factuur genereren</button></div>";
                                echo "</div>";
                            }
                        } else {
                            echo "Geen resultaten";
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </main>
</body>

</html>