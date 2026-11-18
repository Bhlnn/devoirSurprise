<?php

// Définir le format des réponses
header("Content-Type: application/json; charset=UTF-8");

// Autoriser les requêtes provenant du frontend
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Gérer les requêtes OPTIONS du navigateur
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204);
    exit;
}

// Récupérer les paramètres de connexion
$host = getenv("DB_HOST");
$dbname = getenv("DB_NAME");
$username = getenv("DB_USER");
$password = getenv("DB_PASSWORD");

// Connexion à MySQL avec PDO
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

} catch (PDOException $e) {
    http_response_code(500);

    echo json_encode([
        "status" => "error",
        "message" => "Impossible de se connecter à la base de données."
    ]);

    exit;
}

// Récupérer la méthode HTTP
$method = $_SERVER["REQUEST_METHOD"];

// Récupérer le chemin demandé
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// Vérifier que la route demandée est /tasks
if ($path !== "/tasks") {
    http_response_code(404);

    echo json_encode([
        "status" => "error",
        "message" => "Route inconnue."
    ]);

    exit;
}

// Traiter les différentes méthodes HTTP
switch ($method) {

    // Récupérer toutes les tâches
    case "GET":

        $stmt = $pdo->query("SELECT * FROM tasks ORDER BY id");

        $tasks = $stmt->fetchAll();

        echo json_encode([
            "status" => "success",
            "tasks" => $tasks
        ]);

        break;


    // Ajouter une tâche
    case "POST":

        // Lire les données JSON envoyées
        $data = json_decode(file_get_contents("php://input"), true);

        // Vérifier le titre
        if (!is_array($data) || empty(trim($data["title"] ?? ""))) {
            http_response_code(400);

            echo json_encode([
                "status" => "error",
                "message" => "Le titre est obligatoire."
            ]);

            break;
        }

        $title = trim($data["title"]);
        $description = $data["description"] ?? "";

        // Insérer la nouvelle tâche
        $stmt = $pdo->prepare(
            "INSERT INTO tasks (title, description) VALUES (?, ?)"
        );

        $stmt->execute([$title, $description]);

        http_response_code(201);

        echo json_encode([
            "status" => "success",
            "message" => "Tâche créée.",
            "id" => $pdo->lastInsertId()
        ]);

        break;


    // Supprimer une tâche
    case "DELETE":

        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

        if (!$id || $id <= 0) {
            http_response_code(400);

            echo json_encode([
                "status" => "error",
                "message" => "Identifiant invalide."
            ]);

            break;
        }

        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");

        $stmt->execute([$id]);

        if ($stmt->rowCount() === 0) {
            http_response_code(404);

            echo json_encode([
                "status" => "error",
                "message" => "Tâche introuvable."
            ]);

            break;
        }

        echo json_encode([
            "status" => "success",
            "message" => "Tâche supprimée."
        ]);

        break;


    // Méthode non autorisée
    default:

        header("Allow: GET, POST, DELETE, OPTIONS");

        http_response_code(405);

        echo json_encode([
            "status" => "error",
            "message" => "Méthode HTTP non autorisée."
        ]);
}
