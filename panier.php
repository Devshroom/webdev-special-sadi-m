<?php
session_start();
require 'php/db.php';

$user = $_SESSION['username'] ?? null;
if($user) {
  $query = $db->prepare("SELECT * FROM orderdetails WHERE orderID = :user");
  $query->bindValue(':user', $user);
  $query->execute();
  $items = $query->fetchAll(PDO::FETCH_ASSOC);

  if($items) {
    echo '<table>';
    echo '<tr><th>Produit</th><th>Prix</th><th>Quantité</th></tr>';
    foreach($items as $item) {
      echo '<tr>';
      echo '<td>' . htmlspecialchars($item['product_name']) . '</td>';
      echo '<td>' . htmlspecialchars($item['price']) . '</td>';
      echo '<td>' . htmlspecialchars($item['quantity']) . '</td>';
      echo '</tr>';
    }
    echo '</table>';
  } else {
    echo 'Panier vide.';
  }
} else {
  echo 'Utilisateur non connecté.';
}
?>