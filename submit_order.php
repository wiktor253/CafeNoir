<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST['name']);
    $coffeeType = htmlspecialchars($_POST['coffeeType']);
    $size = htmlspecialchars($_POST['size']);
    $totalCost = htmlspecialchars($_POST['totalCost']);
    
    $extras = isset($_POST['extras']) ? (array) $_POST['extras'] : [];
    $extrasList = implode(', ', $extras); // Bezpieczne tworzenie ciągu dodatków

    
    $conn = new mysqli('localhost', 'root', '', 'coffee_orders');

    if ($conn->connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO orders (name, coffee_type, size, extras, total_cost) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $name, $coffeeType, $size, $extrasList, $totalCost);

    if ($stmt->execute()) {
        echo "Zamówienie zostało zapisane pomyślnie!";
    } else {
        echo "Błąd przy zapisywaniu zamówienia: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Nieprawidłowe żądanie.";
}
