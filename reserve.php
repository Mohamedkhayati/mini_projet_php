<?php
include 'config.php';
session_start();

if (!isset($_SESSION['client_id'])) {
    header('Location: login.php');
    exit;
}
$client_id = $_SESSION['client_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $voiture_id = $_POST['voiture_id'];

    if (strtotime($date_debut) < strtotime($date_fin)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO reservations (date_debut, date_fin, voiture_id, client_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$date_debut, $date_fin, $voiture_id, $client_id]);

            $stmt = $pdo->prepare("UPDATE voitures SET disponibilite = 0 WHERE id = ?");
            $stmt->execute([$voiture_id]);

            echo "<p style='color: green;'>Réservation confirmée avec succès !</p>";
        } catch (PDOException $e) {
            echo "<p style='color: red;'>Erreur lors de la réservation : " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>La date de fin doit être après la date de début.</p>";
    }
}

$stmt = $pdo->query("SELECT * FROM voitures WHERE disponibilite = 1");
$voitures_disponibles = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Réserver une Voiture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 400px;
        }
        form label, form input, form select, form button {
            display: block;
            margin-bottom: 15px;
            width: 100%;
        }
        form input, form select, form button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background-color: #0056b3;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Réserver une Voiture</h2>
    <form method="POST">
        <label for="date_debut">Date de début :</label>
        <input type="date" name="date_debut" required>

        <label for="date_fin">Date de fin :</label>
        <input type="date" name="date_fin" required>

        <label for="voiture_id">Choisir une voiture :</label>
        <select name="voiture_id" required>
            <?php foreach ($voitures_disponibles as $voiture): ?>
                <option value="<?= htmlspecialchars($voiture['id']) ?>">
                    <?= htmlspecialchars($voiture['marque']) . ' ' . htmlspecialchars($voiture['modele']) . ' (' . htmlspecialchars($voiture['immatriculation']) . ')' ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Réserver</button>
    </form>
</body>
</html>

