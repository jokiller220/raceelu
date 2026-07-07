<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?? 'Admin - Race Élu' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css">
    <!-- DataTables CSS for tables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .admin-sidebar { min-height: 100vh; background-color: var(--color-dark-green); }
        .admin-sidebar .nav-link { color: rgba(255,255,255,0.8); padding: 0.8rem 1.5rem; border-left: 3px solid transparent; }
        .admin-sidebar .nav-link:hover, .admin-sidebar .nav-link.active { color: #fff; background-color: rgba(255,255,255,0.1); border-left-color: var(--color-yellow); }
    </style>
</head>
<body class="bg-light">

<div class="d-flex">
    <?php require_once 'sidebar.php'; ?>

    <!-- Content -->
    <div class="flex-grow-1" style="max-height: 100vh; overflow-y: auto;">
        <header class="bg-white p-3 shadow-sm d-flex justify-content-between align-items-center position-sticky top-0" style="z-index: 1000;">
            <h4 class="mb-0 fw-bold"><?= $data['page_title'] ?? 'Tableau de bord' ?></h4>
            <div class="d-flex align-items-center">
                <span class="me-3 fw-medium">Admin</span>
                <img src="https://ui-avatars.com/api/?name=Admin&background=0B5D3B&color=fff" class="rounded-circle" width="40" height="40" alt="Admin">
            </div>
        </header>

        <div class="p-4">
