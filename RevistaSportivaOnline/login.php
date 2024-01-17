<?php
    // Database connection
    $conn = new mysqli('sql213.infinityfree.com', 'if0_35801456', 'revistasportiva', 'if0_35801456_revistasportiva');

    if ($conn->connect_error) {
        die('Connection Failed : ' . $conn->connect_error);
    }

    // Procesează cererea de login
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        // Pregătește interogarea SQL pentru autentificare
        $stmt = $conn->prepare("SELECT password FROM revistasportiva WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verifică dacă parola hash-uită se potrivește
            if (password_verify($password, $row['password'])) {
                // Autentificare reușită
                echo "Login success";
            } else {
                // Parolă incorectă
                echo "Invalid login credentials";
            }
        } else {
            // Emailul nu există în baza de date
            echo "Invalid login credentials";
        }

        $stmt->close();
    } else {
        echo "Email and password required";
    }

    $conn->close();
?>
