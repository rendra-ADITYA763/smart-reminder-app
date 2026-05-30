<?php
session_start();
// Auth guard — redirect to landing if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: landing.php');
    exit;
}
$sessionUser = [
    'id'    => $_SESSION['user_id'],
    'name'  => $_SESSION['user_name'],
    'email' => $_SESSION['user_email'],
    'role'  => $_SESSION['user_role']
];
?>
<?php include 'components/header.php'; ?>

    <!-- Session data for JS -->
    <script>
        const SESSION_USER = <?php echo json_encode($sessionUser); ?>;
    </script>

    <!-- Main Layout -->
    <div class="flex flex-1 pt-20 max-w-[1600px] mx-auto w-full">
<?php include 'components/sidebar.php'; ?>

        <!-- Content Area -->
        <main class="flex-1 p-8 lg:p-12 overflow-y-auto bg-slate-50 dark:bg-slate-950 transition-colors duration-300">
<?php include 'views/dashboard.php'; ?>
<?php include 'views/schedule.php'; ?>
<?php include 'views/events.php'; ?>
<?php include 'views/weather.php'; ?>
<?php if ($sessionUser['role'] === 'admin'): ?>
<?php include 'views/admin.php'; ?>
<?php endif; ?>
<?php include 'views/analytics.php'; ?>
<?php include 'views/logs.php'; ?>
<?php include 'views/settings.php'; ?>
<?php include 'views/ai.php'; ?>
        </main>
    </div>

<?php include 'components/footer.php'; ?>
