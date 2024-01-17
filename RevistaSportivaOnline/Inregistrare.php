<?php
    // Database connection
    $conn = new mysqli('sql213.infinityfree.com', 'if0_35801456','revistasportiva', 'if0_35801456_revistasportiva');

    if ($conn->connect_error) {
        die('Connection Failed : ' . $conn->connect_error);
    }

    // Verifică dacă datele au fost trimise
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Curăță și pregătește datele primite
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        // Crează un hash pentru parolă
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Pregătește interogarea SQL
        $stmt = $conn->prepare("INSERT INTO revistasportiva(email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);

        // Execută interogarea
        if ($stmt->execute()) {
            echo "Registration Successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Închide statement-ul și conexiunea
        $stmt->close();
      
    } else {
        echo "Email and password required";
    }

    // Procesează cererea de login
    if (isset($_REQUEST['login'])) {
        $email = mysqli_real_escape_string($conn, $_REQUEST['email']);
        $password = $_REQUEST['password'];

        // Pregătește interogarea SQL pentru autentificare
        $stmt = $conn->prepare("SELECT password FROM revistasportiva WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verifică dacă parola hash-uită se potrivește
            if (password_verify($password, $row['password'])) {
                ?>
                <script>
                    alert("Login success");
                </script>
                <?php
            } else {
                ?>
                <script>
                    alert("Invalid login credentials");
                </script>
                <?php
            }
        } else {
            ?>
            <script>
                alert("Invalid login credentials");
            </script>
            <?php
        }

        $stmt->close();
    }
    $conn->close();
?>
