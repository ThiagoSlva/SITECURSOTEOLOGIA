        </main>
    </div>

    <!-- Admin Scripts -->
    <script>
        const btnToggle = document.getElementById('mobile-menu-toggle');
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const openIcon = document.getElementById('toggle-icon-open');
        const closeIcon = document.getElementById('toggle-icon-close');

        function toggleSidebar() {
            const isOpen = sidebar.classList.contains('translate-x-0');
            
            if (isOpen) {
                // Close
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                overlay.classList.remove('opacity-100');
                openIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                // Open
                sidebar.classList.add('translate-x-0');
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.add('opacity-100'), 10);
                openIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        btnToggle?.addEventListener('click', toggleSidebar);
        overlay?.addEventListener('click', toggleSidebar);
    </script>
</body>
</html>
