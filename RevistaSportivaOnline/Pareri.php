<?php
    // Conexiunea la baza de date
    $conn = new mysqli('sql213.infinityfree.com', 'if0_35801456','revistasportiva', 'if0_35801456_revistasportiva');

    // Verifică conexiunea
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Verifică dacă formularul a fost trimis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Curăță și pregătește datele primite
        $nume = mysqli_real_escape_string($conn, $_POST['nume']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);

        // Pregătește interogarea SQL
        $stmt = $conn->prepare("INSERT INTO pareri (nume, email, feedback) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nume, $email, $feedback);

        // Execută interogarea
        if ($stmt->execute()) {
            echo "Mulțumim pentru feedback!";
        } else {
            echo "Eroare: " . $stmt->error;
        }

        // Închide statement-ul și conexiunea
        $stmt->close();
    }
    <?php
    // ... restul codului ...

    // Execută interogarea
    if ($stmt->execute()) {
        echo "Mulțumim pentru feedback!";

        // Prepară și trimite email-ul
        $to = $email; // destinatarul email-ului
        $subject = "Mulțumim pentru feedback-ul tău!";
        $message = "Bună " . $nume . ",\n\nMulțumim pentru feedback-ul tău! Acesta este foarte important pentru noi.\n\nAi scris:\n" . $feedback;
        $headers = "From: webmaster@exemplu.com"; // înlocuiește cu adresa ta de email

        // Trimiterea email-ului
        if(mail($to, $subject, $message, $headers)) {
            echo "Un email de confirmare a fost trimis.";
        } else {
            echo "Emailul de confirmare nu a putut fi trimis.";
        }

    } else {
        echo "Eroare: " . $stmt->error;
    }

    // ... restul codului ...
?>


    $conn->close();
?>


