<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php">
                <i class="mdi mdi-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <?php

        if ($_SESSION[PREFIX . '_security'] > 9) {


            ?>
            <li class="nav-item">
                <a class="nav-link" href="user_list.php">
                    <i class="mdi mdi-account menu-icon"></i>
                    <span class="menu-title">Users</span>
                </a>
            </li>
        <?php } ?>
        <li class="nav-item">
            <a class="nav-link" href="loan_application.php">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">Loan Application</span>
            </a>
        </li>
    </ul>
</nav>

