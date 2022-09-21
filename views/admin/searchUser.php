<header class="admin-page-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light float-right">
        <div class="collapse navbar-collapse flex-row-reverse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>Admin management</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/management/admin/home">Search</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/management/admin/createPageAdmin">Create</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="active">User management</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item active" href="/management/admin/searchPageUser">Search</a>
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/management/auth/logout">Log out </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<section class="h-100 w-100 flex-column mb-auto admin-home-sect">
    <?php
    clearTemp();
    $acceptableMessage = array('login', 'update', 'id', 'permission', 'delete');
    foreach ($_SESSION['flash_message'] as $key => $value) {
        if (in_array($key, $acceptableMessage)) {
            if (isset($_SESSION['flash_message'][$key])) {
                echo "
                            <div class=\"w-80 mt-3 mb-3 notification border border-success rounded\">
                            <span class=\"noti-message h-100 d-flex align-text-center justify-content-center align-items-center\">"; ?>
                <?php
                if (isset($_SESSION['flash_message'][$key])) {
                    echo handleFlashMessage($key);
                }
                echo "</span>
                    </div>";
            }
        }
    }
    ?>
    <div class="mt-3 mb-3 search-box border border-dark">
        <form method="GET" action="/management/admin/searchUser" class=" m-4 form-create">
            <!-- Email input -->
            <div class="row g-2 align-items-center mb-3 mt-3">
                <div class="col-auto m-3">
                    <label for="email" class="col-form-label">Email</label>
                </div>
                <div class="col-auto m-3">
                    <input type="text"
                           id="email"
                           name="email"
                           class="form-control"
                           value="<?php
                           if (isset($_SESSION['old_data']['email'])) {
                               echo oldData('email');
                           }
                           ?>"
                    />
                </div>
                <div class="error-holder m-3">
                    <?php if (isset($_SESSION['flash_message']['email'])) {
                        echo handleFlashMessage('email');
                    } ?>
                </div>
            </div>

            <!-- Name input -->
            <div class="row g-2 align-items-center mb-3 mt-3">
                <div class="col-auto m-3">
                    <label for="name" class="col-form-label">Name</label>
                </div>
                <div class="col-auto m-3">
                    <input type="text"
                           id="name"
                           name="name"
                           class="form-control"
                           value="<?php
                           if (isset($_SESSION['old_data']['name'])) {
                               echo oldData('name');
                           }
                           ?>"
                    />
                </div>
                <div class="error-holder m-3">
                    <?php if (isset($_SESSION['flash_message']['name'])) {
                        echo handleFlashMessage('name');
                    } ?>
                </div>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-between row g-2 align-items-center">
                <div class="col-auto">
                    <button type="reset" class="reset-button btn btn-primary btn-block mb-4">Reset</button>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary btn-block mb-4 btn-submit">Search</button>
                </div>
            </div>
        </form>
    </div>
    <div class="d-flex flex-column result-container mb-2 mt-2 p-3 border border-dark">
        <div class="pagination-cover flex-row-reverse m-2">
            <nav aria-label="Page navigation example" class="page-nav">
                <?php
                error_reporting(E_ERROR | E_PARSE);
                if(isset($data) and !empty($data['pagination']['totalPages'])){
                    loadPaginator($data);
                }
                ?>
            </nav>
        </div>

        <div class="table-cover border border-dark">
            <table id="searchTable" class="result-table table table-sortable table-striped table-bordered table-hover">
                <thead class="thead-dark">
                <tr>
                    <th class="thread-column" scope="col" >

                        <a href="<?php prepareColumnSort('id', 'ASC');?>">
                            ID <?php displayingSortIcon($data)?>
                        </a>
                    </th>
                    <th scope="col">Avatar</th>
                    <th class="thread-column" scope="col" >
                        <a href="<?php prepareColumnSort('name', 'ASC');?>">
                            Name <?php displayingSortIcon($data)?>
                        </a>
                    </th>
                    <th class="thread-column" scope="col" >
                        <a href="<?php prepareColumnSort('email', 'ASC');?>">
                            Email <?php displayingSortIcon($data)?>
                        </a>
                    </th>
                    <th class="thread-column" scope="col" >
                        <a href="<?php prepareColumnSort('status', 'ASC');?>">
                            Role <?php displayingSortIcon($data)?>
                        </a>
                    </th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                displayTableResultForUserSearch($data, 'admin');
                ?>
                </tbody>
            </table>
        </div>
    </div>
</section>