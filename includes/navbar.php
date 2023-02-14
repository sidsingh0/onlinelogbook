<nav class="navbar navbar-expand-sm navbar-dark bg-dark-subtle">
        <div class="d-flex container-fluid">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar3  mx-1" viewBox="0 0 16 16">
                <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z"/>
                <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
              </svg>
          <a class="flex-grow-1 navbar-brand mx-1 font-weight-bold" href="javascript:void(0)">APSIT Online Logbook</a>
          <button class="navbar-toggler mx-1" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav nav-pills ms-auto">
              <?php 
              if($_COOKIE["role"] == "proco"){
                echo '
                  <li class="nav-item mx-1">
                    <a class="nav-link" href="/logbook_online/onlinelogbook/procord/index.php">Add Logs</a>
                  </li>
                  <li class="nav-item mx-1">
                    <a class="nav-link" href="/logbook_online/onlinelogbook/procord/add-group.php">Add A Group</a>
                  </li>
                  <li class="nav-item mx-1">
                    <a class="nav-link" href="/logbook_online/onlinelogbook/procord/view-groups.php">My Groups</a>
                  </li>
                  <li class="nav-item mx-1">
                    <a class="nav-link" href="/logbook_online/onlinelogbook/procord/search.php" aria-current="page">Search</a>
                  </li>
                  <li class="nav-item mx-1">
                    <a class="nav-link" href="/logbook_online/onlinelogbook/procord/procord-view.php" aria-current="page">View All Groups</a>
                  </li>
                ';
              }
              if($_COOKIE["role"] == "admin"){
                echo '
                <li class="nav-item mx-1">
                  <a class="nav-link" href="/logbook_online/onlinelogbook/admin/index.php" aria-current="page">Edit Faculties</a>
                </li>
                <li class="nav-item mx-1">
                    <a class="nav-link" href="/logbook_online/onlinelogbook/admin/add-logs.php">Add Logs</a>
                  </li>
                <li class="nav-item mx-1">
                  <a class="nav-link" href="/logbook_online/onlinelogbook/admin/admin-view.php" aria-current="page">View all groups</a>
                </li>
                <li class="nav-item mx-1">
                    <a class="nav-link" href="/logbook_online/onlinelogbook/admin/search.php" aria-current="page">Search</a>
                </li>
              ';
              }
              if($_COOKIE["role"] == "student"){
                echo '
                <li class="nav-item mx-1">
                  <a class="nav-link" href="/logbook_online/onlinelogbook/student/index.php" aria-current="page">Home</a>
                </li>
              ';
              }
              if($_COOKIE["role"] == "guide"){
                echo '
                <li class="nav-item mx-1">
                  <a class="nav-link" href="/logbook_online/onlinelogbook/guide/index.php" aria-current="page">Home</a>
                </li>

                <li class="nav-item mx-1">
                  <a class="nav-link" href="/logbook_online/onlinelogbook/guide/add-group.php" aria-current="page">Add A Group</a>
                </li>
              ';
              }
              ?>
              <li class="mx-1">
                <a href="/logbook_online/onlinelogbook/logout.php?logout=true" class="btn btn-outline-info text-info-emphasis bg-info-subtle">Sign Out</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>