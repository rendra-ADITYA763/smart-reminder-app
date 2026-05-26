<?php include 'components/header.php'; ?>

    <!-- Main Layout -->
    <div class="flex flex-1 pt-20 max-w-[1600px] mx-auto w-full">
<?php include 'components/sidebar.php'; ?>

        <!-- Content Area -->
        <main class="flex-1 p-8 lg:p-12 overflow-y-auto bg-slate-50 dark:bg-slate-950 transition-colors duration-300">
<?php include 'views/dashboard.php'; ?>
<?php include 'views/schedule.php'; ?>
<?php include 'views/events.php'; ?>
<?php include 'views/weather.php'; ?>
<?php include 'views/admin.php'; ?>
<?php include 'views/analytics.php'; ?>
<?php include 'views/logs.php'; ?>
<?php include 'views/settings.php'; ?>
        </main>
    </div>

<?php include 'components/footer.php'; ?>
