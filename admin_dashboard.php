<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: index.php'); 
    exit;
}

$stmt = $pdo->query("SELECT * FROM voitures");
$voitures = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tableau de Bord Administrateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            padding: 10px 20px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
        }
        .navbar a:hover {
            background-color: #575757;
            border-radius: 4px;
        }
        .container {
            padding: 20px;
        }
        h2, h3 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .action-links a {
            margin-right: 10px;
            color: #007BFF;
            text-decoration: none;
        }
        .action-links a:hover {
            text-decoration: underline;
        }
        .logout {
            color: white;
            background-color: #d9534f;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
        }
        .logout:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <a href="dashboard.php">Tableau de Bord</a>
            <a href="admin_add_car.php">Ajouter une Voiture</a>
        </div>
        <a class="logout" href="logout.php" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')">Déconnexion</a>
    </div>
    <div class="container">
        <h2>Bienvenue Administrateur</h2>
        <h3>Gestion des Voitures</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Année</th>
                    <th>Immatriculation</th>
                    <th>Disponibilité</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($voitures as $voiture): ?>
                    <tr>
                        <td><?= $voiture['id'] ?></td>
                        <td><?= $voiture['marque'] ?></td>
                        <td><?= $voiture['modele'] ?></td>
                        <td><?= $voiture['annee'] ?></td>
                        <td><?= $voiture['immatriculation'] ?></td>
                        <td><?= $voiture['disponibilite'] ? 'Disponible' : 'Indisponible' ?></td>
                        <td class="action-links">
                            <a href="admin_edit_car.php?id=<?= $voiture['id'] ?>">Modifier</a>
                            <a href="admin_delete_car.php?id=<?= $voiture['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette voiture ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
