<?php

// Définir le type de réponse
header("Content-Type: application/json; charset=UTF-8");

// Créer une réponse de test
$response = [
    "status" => "success",
    "message" => "Backend PHP opérationnel !",
    "server" => "Apache",
    "version" => phpversion()
];

// Envoyer la réponse au format JSON
echo json_encode($response, JSON_PRETTY_PRINT);
