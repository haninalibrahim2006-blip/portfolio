<?php

function connectDatabase() {
    $connection = new mysqli("localhost", "root", "", "gameworld_db");

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    return $connection;
}

/* =========================
   PRODUCTEN
========================= */

function getProductsByCategory($categoryId) {
    $conn = connectDatabase();
    $categoryId = (int)$categoryId;

    $sql = "SELECT * FROM products WHERE category_id = $categoryId";
    return $conn->query($sql);
}

function getPopularProducts() {
    $conn = connectDatabase();

    $sql = "SELECT * FROM products ORDER BY id DESC LIMIT 4";
    return $conn->query($sql);
}

function getProductById($id) {
    $conn = connectDatabase();
    $id = (int)$id;

    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}

function searchProducts($search) {
    $conn = connectDatabase();
    $search = $conn->real_escape_string($search);

    $sql = "SELECT * FROM products 
            WHERE name LIKE '%$search%' 
            OR description LIKE '%$search%'";
    return $conn->query($sql);
}

/* =========================
   CONTENT
========================= */

function getContent($sectionName) {
    $conn = connectDatabase();

    $stmt = $conn->prepare("SELECT body_text FROM content WHERE section_name = ?");
    $stmt->bind_param("s", $sectionName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['body_text'];
    }

    return "";
}

/* =========================
   USERS
========================= */

function registerUser($username, $email, $password) {
    $conn = connectDatabase();

    $username = trim($username);
    $email = trim($email);
    $password = trim($password);

    if ($username === "" || $email === "" || $password === "") {
        return "Vul alle velden in.";
    }

    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        return "Dit e-mailadres bestaat al.";
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        return true;
    }

    return "Registreren mislukt.";
}

function loginUser($username, $password) {
    $conn = connectDatabase();

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            return $user;
        }
    }

    return false;
}

/* =========================
   WINKELWAGEN
========================= */

function addToCart($productId) {
    $productId = (int)$productId;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][] = $productId;
}

function getCartItems() {
    $items = [];

    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return $items;
    }

    foreach ($_SESSION['cart'] as $productId) {
        $product = getProductById($productId);

        if ($product) {
            $items[] = $product;
        }
    }

    return $items;
}

function getCartTotal() {
    $total = 0;
    $items = getCartItems();

    foreach ($items as $item) {
        $total += $item['price'];
    }

    return $total;
}

function clearCart() {
    unset($_SESSION['cart']);
}

/* =========================
   BLOG
========================= */

function getAllBlogPosts() {
    $conn = connectDatabase();
    $sql = "SELECT * FROM blog_posts ORDER BY post_date DESC";
    return $conn->query($sql);
}

function getBlogPostsByCategory($categoryId) {
    $conn = connectDatabase();
    $categoryId = (int)$categoryId;
    $sql = "SELECT * FROM blog_posts WHERE category_id = $categoryId ORDER BY post_date DESC";
    return $conn->query($sql);
}

function getBlogPostById($id) {
    $conn = connectDatabase();
    $id = (int)$id;
    $sql = "SELECT * FROM blog_posts WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}

function addBlogPost($title, $author, $postDate, $categoryId, $content) {
    $conn = connectDatabase();

    $title = trim($title);
    $author = trim($author);
    $postDate = trim($postDate);
    $categoryId = (int)$categoryId;
    $content = trim($content);

    if ($title === "" || $author === "" || $content === "" || $categoryId === 0) {
        return "Vul alle velden in.";
    }

    $stmt = $conn->prepare("INSERT INTO blog_posts (title, author, post_date, category_id, content) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $title, $author, $postDate, $categoryId, $content);

    if ($stmt->execute()) {
        return true;
    }

    return "Blog toevoegen mislukt.";
}

function getCategoryName($categoryId) {
    if ($categoryId == 1) {
        return "New Products";
    } elseif ($categoryId == 2) {
        return "Game Reviews";
    } elseif ($categoryId == 3) {
        return "Console Reviews";
    } else {
        return "Unknown";
    }
}

function getCommentsByPostId($postId) {
    $conn = connectDatabase();
    $postId = (int)$postId;
    $sql = "SELECT * FROM blog_comments WHERE post_id = $postId ORDER BY id DESC";
    return $conn->query($sql);
}

function addComment($postId, $name, $comment) {
    $conn = connectDatabase();

    $postId = (int)$postId;
    $name = trim($name);
    $comment = trim($comment);

    if ($name === "" || $comment === "") {
        return false;
    }

    $stmt = $conn->prepare("INSERT INTO blog_comments (post_id, name, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $postId, $name, $comment);

    return $stmt->execute();
}

/* =========================
   CONTACT
========================= */

function addContactMessage($name, $email, $message) {
    $conn = connectDatabase();

    $name = trim($name);
    $email = trim($email);
    $message = trim($message);

    if ($name === "" || $email === "" || $message === "") {
        return false;
    }

    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    return $stmt->execute();
}

function getContactMessages() {
    $conn = connectDatabase();
    $sql = "SELECT * FROM contact_messages ORDER BY id DESC";
    return $conn->query($sql);
}
?>