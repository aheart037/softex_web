      </main>

      <!-- App Footer -->
      <footer class="app-footer">
        <div class="container-fluid">
          <div class="row align-items-center">
            <div class="col-md-6 text-md-start text-center mb-2 mb-md-0">
              &copy; <?= date('Y') ?> <strong><?= h(get_setting('company_name', 'Softex Technologies')) ?></strong>. All rights reserved.
            </div>
            <div class="col-md-6 text-md-end text-center">
              <span class="text-muted">Designed securely with Bootstrap 5</span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <!-- Bootstrap 5 Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Interactive Navigation Helper Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Sidebar Toggle for Mobile View
      const sidebarToggle = document.getElementById('sidebar-toggle-btn');
      const sidebar = document.getElementById('app-sidebar');
      
      if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function(e) {
          e.stopPropagation();
          sidebar.classList.toggle('show');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
          if (window.innerWidth < 992 && !sidebar.contains(e.target) && e.target !== sidebarToggle) {
            sidebar.classList.remove('show');
          }
        });
      }
    });
  </script>
</body>
</html>
