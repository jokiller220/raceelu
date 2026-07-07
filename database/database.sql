-- Railway: La base de données est déjà créée et sélectionnée automatiquement.

-- Table users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    telephone VARCHAR(50),
    adresse TEXT,
    ville VARCHAR(100),
    role ENUM('admin', 'client') DEFAULT 'client',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table categories
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    image VARCHAR(255),
    status ENUM('actif', 'inactif') DEFAULT 'actif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table products
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NULL,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    image VARCHAR(255),
    unite VARCHAR(50) DEFAULT 'kg', -- ex: 25kg, 1L, etc.
    status ENUM('actif', 'inactif') DEFAULT 'actif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Table orders
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    nom_client VARCHAR(255) NOT NULL,
    telephone_client VARCHAR(50) NOT NULL,
    adresse_livraison TEXT NOT NULL,
    ville_livraison VARCHAR(100) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    mode_paiement VARCHAR(50) NOT NULL,
    status ENUM('en_attente', 'payee', 'expediee', 'livree', 'annulee') DEFAULT 'en_attente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Table order_items
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Table promotions
CREATE TABLE IF NOT EXISTS promotions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    pourcentage_remise INT NOT NULL,
    date_debut DATE,
    date_fin DATE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Insertion admin par defaut (mdp: panaSSi88@)
INSERT INTO users (nom, email, password, role) VALUES 
('Administrateur', 'contact@raceelu.com', '$2y$10$567AdXU2E.2rqbSeSmXce.kq2tAocM2gre9TQKaf0rU6pteeY2s2m', 'admin');

-- Insertion categories
INSERT INTO categories (nom, slug, image) VALUES 
('Riz', 'riz', 'cat-riz.jpg'),
('Huile', 'huile', 'cat-huile.jpg'),
('Sucre', 'sucre', 'cat-sucre.jpg'),
('Conserves', 'conserves', 'cat-conserves.jpg'),
('Boissons', 'boissons', 'cat-boissons.jpg'),
('Produits laitiers', 'produits-laitiers', 'cat-lait.jpg'),
('Pâtes', 'pates', 'cat-pates.jpg'),
('Épices', 'epices', 'cat-epices.jpg');

-- Insertion produits exemples
INSERT INTO products (category_id, nom, description, prix, stock, image, unite) VALUES 
(1, 'Riz long grain 25kg', 'Riz de qualité supérieure, long grain.', 26500.00, 150, 'riz-25kg.jpg', '25kg'),
(2, 'Huile végétale 20L', 'Huile végétale raffinée.', 21000.00, 80, 'huile-20l.jpg', '20L'),
(3, 'Sucre blanc 50kg', 'Sucre en poudre cristallisé.', 28000.00, 100, 'sucre-50kg.jpg', '50kg'),
(6, 'Lait NIDO 400g', 'Lait en poudre entier.', 3200.00, 200, 'nido-400g.jpg', '400g'),
(4, 'Tomate concentrée 400g', 'Purée de tomate.', 800.00, 500, 'tomate-400g.jpg', '400g'),
(5, 'Boisson Malta Guinness 33cl', 'Boisson maltée.', 600.00, 300, 'malta-33cl.jpg', '33cl'),
(7, 'Pâtes alimentaires 250g', 'Macaroni.', 400.00, 400, 'pates-250g.jpg', '250g'),
(8, 'Sel iodé 1kg', 'Sel de cuisine iodé.', 300.00, 600, 'sel-1kg.jpg', '1kg');
