<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? '' : 'collapsed'; ?>" href="index.php">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
      <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'users.php') ? '' : 'collapsed'; ?>" href="users.php">
        <i class="bi bi-person"></i>
        <span>Users</span>
      </a>
    </li><!-- End Users Page Nav -->

    <li class="nav-item">
      <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'category.php') ? '' : 'collapsed'; ?>" href="category.php">
        <i class="bi bi-folder"></i>
        <span>Category</span>
      </a>
    </li><!-- End Category Page Nav -->

    <li class="nav-item">
      <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'suppliers.php') ? '' : 'collapsed'; ?>" href="suppliers.php">
        <i class="bi bi-people-fill"></i>
        <span>Suppliers</span>
      </a>
    </li><!-- End Suppliers Page Nav -->

    <li class="nav-item">
      <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'product.php') ? '' : 'collapsed'; ?>" href="product.php">
        <i class="bi bi-box-seam"></i>
        <span>Product</span>
      </a>
    </li><!-- End Product Page Nav -->

    <li class="nav-item">
      <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'sale.php') ? '' : 'collapsed'; ?>" href="sale.php">
        <i class="bi bi-cart3"></i>
        <span>Sale</span>
      </a>
    </li><!-- End Sale Page Nav -->

    <li class="nav-item">
      <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'sale_report.php') ? '' : 'collapsed'; ?>" href="sale_report.php">
        <i class="bi bi-card-list"></i>
        <span>Report</span>
      </a>
    </li><!-- End Report Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="../logout.php">
        <i class="bi bi-box-arrow-in-right"></i>
        <span>Login</span>
      </a>
    </li><!-- End Login Page Nav -->
  </ul>
</aside><!-- End Sidebar-->