<footer class="footer footer-premium">
  <div class="container-fluid">
      <div>
          <div>
              <p>
                  &copy; <script>document.write(new Date().getFullYear())</script> Cerfaos
              </p>
          </div>
          <div>
              <div class="footer-links">
                  <a href="/" class="footer-link" target="_blank">
                      <i data-feather="external-link" class="footer-icon"></i>
                  </a>
                  <a href="{{ route('admin.profile') }}" class="footer-link">
                      <i data-feather="user" class="footer-icon"></i>
                  </a>
                  <a href="{{ route('admin.logout') }}" class="footer-link">
                      <i data-feather="log-out" class="footer-icon"></i>
                  </a>
              </div>
          </div>
      </div>
  </div>
</footer>