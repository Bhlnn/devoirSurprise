-- Création de la base de données
CREATE DATABASE IF NOT EXISTS surprise;

-- Utilisation de la base
USE surprise;

-- Création de la table des tâches
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    completed BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertion de quelques tâches de test
INSERT INTO tasks (title, description, completed)
VALUES
('Faire les exercices DevOps', 'Terminer les exercices du cours', FALSE),
('Configurer Docker', 'Créer les images Docker', TRUE),
('Déployer Kubernetes', 'Déployer les différents services', FALSE);