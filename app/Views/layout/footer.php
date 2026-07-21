    </main>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Mobile sidebar toggle functionality
  document.getElementById('sidebarToggle')?.addEventListener('click', function() {
    document.querySelector('.sidebar').classList.toggle('show');
    document.getElementById('sidebarOverlay')?.classList.toggle('show');
  });

  // Close sidebar when overlay is clicked
  document.getElementById('sidebarOverlay')?.addEventListener('click', function() {
    document.querySelector('.sidebar').classList.remove('show');
    this.classList.remove('show');
  });
</script>
</body>
</html>
