<?php
include 'config.php';
session_start();

if (!isset($_SESSION['client_id'])) {
    header('Location: login.php');
    exit;
}
$client_id = $_SESSION['client_id'];
$stmt = $pdo->prepare("SELECT r.id, r.date_debut, r.date_fin, v.marque, v.modele, v.immatriculation 
                       FROM reservations r, voitures v
                       WHERE r.voiture_id = v.id
                       AND r.client_id = ?");
$stmt->execute([$client_id]);
$reservations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tableau de Bord</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .navbar {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
            font-weight: bold;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #f8f8f8;
            font-weight: bold;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        a.button {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 15px;
            text-decoration: none;
            color: #fff;
            background-color: #007BFF;
            border-radius: 5px;
            text-align: center;
        }
        a.button:hover {
            background-color: #0056b3;
        }
        .container {
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <a href="dashboard.php">Tableau de Bord</a>
            <a href="reserve.php">Réserver une Voiture</a>
        </div>
        <a href="logout.php">Se Déconnecter</a>
    </div>
    <div class="container">
        <h2>Mes Réservations</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Voiture</th>
                    <th>Date de Début</th>
                    <th>Date de Fin</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?= htmlspecialchars($reservation['id']) ?></td>
                        <td><?= htmlspecialchars($reservation['marque']) . ' ' . htmlspecialchars($reservation['modele']) . ' (' . htmlspecialchars($reservation['immatriculation']) . ')' ?></td>
                        <td><?= htmlspecialchars($reservation['date_debut']) ?></td>
                        <td><?= htmlspecialchars($reservation['date_fin']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
