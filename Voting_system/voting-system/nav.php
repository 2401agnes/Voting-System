<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
    <a class="navbar-brand" href="#">Automated Online <br>
        Voting System</a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION["logged_in"])): ?>


                <li class="nav-item nav">
                    <a class="nav-link" href="vote.php">Vote</a>
                </li>

            <?php if ($_SESSION["admin"] ==1 ): ?>
                <li class="nav-item">
                    <a class="nav-link" href="fetch_user.php">Manage Users</a>
                </li>
                <?php endif; ?>

            <?php if ($_SESSION["admin"] ==1 ): ?>
                <li class="nav-item">
                    <a class="nav-link" href="fetch_position.php">Manage Positions</a>
                </li>
                <?php endif; ?>

                <?php if ($_SESSION["admin"] ==1 ): ?>
                <li class="nav-item">
                    <a class="nav-link" href="fetch_candidate.php">Manage Candidates</a>
                </li>
                <?php endif; ?>


                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                      <?= $_SESSION['names'] ?>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item pt-0 text-danger" href="logout.php"><b>Sign Out</b></a>
                    </div>
                </li>

<!--dropdown content or menu-->

            <?php endif; ?>


            <?php if (! isset($_SESSION["logged_in"])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="#">Login</a>
                </li>
            <?php endif; ?>


        </ul>
    </div>
</nav>