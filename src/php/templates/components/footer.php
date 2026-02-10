    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <img src="/templates/components/logo/groupLogo.svg" alt="Group logo" class="d-block mx-auto mb-2" style="height: 78px; width: auto;">
            <p class="mb-2">&copy; <?=date('Y')?> CV Generator. All rights reserved.</p>
            <p class="text-muted small">
                Environment: <?php echo ucfirst($app_env); ?> | Current Page: <?php echo ucfirst($page); ?>
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
