<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $annee = $_POST['annee'];
    $immatriculation = $_POST['immatriculation'];
    $stmt = $pdo->prepare("INSERT INTO voitures (marque, modele, annee, immatriculation, disponibilite) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$marque, $modele, $annee, $immatriculation, 1]);
    header('Location: admin_dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une Voiture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            padding: 20px;
            max-width: 600px;
            margin: auto;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ajouter une Nouvelle Voiture</h2>
        <form method="POST">
            <label for="marque">Marque:</label>
            <input type="text" name="marque" required>
            <label for="modele">Modèle:</label>
            <input type="text" name="modele" required>
            <label for="annee">Année:</label>
            <input type="number" name="annee" required>
            <label for="immatriculation">Immatriculation:</label>
            <input type="text" name="immatriculation" required>
            <button type="submit">Ajouter</button>
        </form>
    </div>
</body>
</html>
