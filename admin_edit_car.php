<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM voitures WHERE id = ?");
$stmt->execute([$id]);
$voiture = $stmt->fetch();

if (!$voiture) {
    echo "Voiture introuvable.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $annee = $_POST['annee'];
    $immatriculation = $_POST['immatriculation'];
    $disponibilite = isset($_POST['disponibilite']) ? 1 : 0;
    $stmt = $pdo->prepare("UPDATE voitures SET marque=?, modele=?, annee=?, immatriculation=?, disponibilite=? WHERE id=?");
    $stmt->execute([$marque, $modele, $annee, $immatriculation, $disponibilite, $id]);
    header('Location: admin_dashboard.php'); 
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier une Voiture</title>
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
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Modifier la Voiture</h2>
        <form method="POST">
            <label for="marque">Marque:</label>
            <input type="text" name="marque" value="<?= $voiture['marque'] ?>" required>
            <label for="modele">Modèle:</label>
            <input type="text" name="modele" value="<?= $voiture['modele'] ?>" required>
            <label for="annee">Année:</label>
            <input type="number" name="annee" value="<?= $voiture['annee'] ?>" required>
            <label for="immatriculation">Immatriculation:</label>
            <input type="text" name="immatriculation" value="<?= $voiture['immatriculation'] ?>" required>
            <label for="disponibilite">Disponible:</label>
            <input type="checkbox" name="disponibilite" <?= $voiture['disponibilite'] ? 'checked' : '' ?>>
            <button type="submit">Mettre à jour</button>
        </form>
    </div>
</body>
</html>
