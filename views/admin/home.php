

<header class="admin-page-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light float-right">
        <div class="collapse navbar-collapse flex-row-reverse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Admin management
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Search</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Create</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        User management
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Search</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Create</a>
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Log out <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<section class="h-100 w-100 flex-column mb-auto admin-home-sect">
    <div class="w-80 mt-3 mb-3 notification border border-success rounded">
        <span class="noti-message h-100 d-flex align-text-center justify-content-center align-items-center">
            <?php
                if (isset($_SESSION['flash_message']['logged_in'])) {
                    echo(handleFlashMessage('logged_in'));
                }
            ?>
        </span>
    </div>
    <div class="mt-3 mb-3 search-box border border-dark">
        <form method="POST" action="##" class=" m-4 form-create">
            <!-- Email input -->
            <div class="row g-2 align-items-center mb-3 mt-3">
                <div class="col-auto m-3">
                    <label for="inputEmail" class="col-form-label">Email</label>
                </div>
                <div class="col-auto m-3">
                    <input type="email" id="inputEmail" class="form-control">
                </div>
            </div>

            <!-- Password input -->
            <div class="row g-2 align-items-cente mb-3 mt-3">
                <div class="col-auto m-3">
                    <label for="inputName" class="col-form-label">Name</label>
                </div>
                <div class="col-auto m-3">
                    <input type="text" id="inputName" class="form-control">
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
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
        <div class="table-cover border border-dark">
            <table class="result-table table table-striped table-bordered table-hover">
                <thread class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Avatar</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thread>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <div class="row g-2 align-items-center">
                                <div class="col-auto">
                                    <button type="reset" class="btn btn-primary btn-block mb-4">
                                        <a href="##"></a>
                                        Edit
                                    </button>
                                </div>
                                <div class="col-auto">
                                    <button type="reset" class="btn btn-primary btn-block mb-4">
                                        <a href="##"></a>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>