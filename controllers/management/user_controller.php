<?php
require_once('controllers/base_controller.php');
require_once('model/UserModel.php');
require_once('validation/validation.php');
require_once('helper/common.php');

class userController extends BaseController
{
    public function __construct()
    {
        if (!isAdmin()) {
            $_SESSION['flash_message']['permission']['no_permission'] = getMessage('no_permission_admin');
            isLoggedIn();
        }
        $this->folder = 'user';
        $this->userModel = new UserModel();
    }

    //-----------------------------------------------------VIEW SECTION-------------------------------------------------
    //search front page
    public function searchPageUser()
    {
        if(isSuperAdmin()){
            header('Location: /management/admin/searchPageUser');
            exit;
        }
        return $this->render('searchUser');
    }


    //edit front page
    public function editPageUser()
    {
        if (isset($_GET['id'])) {
            $updatingUserInfo = $this->userModel->searchOneByID($_GET['id']);
        }
        if(isSuperAdmin()){
            header('Location: /management/admin/editPageUser?id='.$_GET['id']);
            exit;
        }
        return $this->render('editUser', ['targetUserToUpdate' => $updatingUserInfo]);
    }

    //-----------------------------------------------------USER SECTION-------------------------------------------------
    //search - USER(admin)
    function searchUser()
    {
        //validate input
        $method = $_SERVER['REQUEST_METHOD'];

        if (!validateSearchFormForUser($method)) {
            header('Location: /management/user/searchPageUser');
            exit;
        }

        $emailPhrase = $_GET['email'];
        $namePhrase = $_GET['name'];
        $page = 1;
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
        }

        $column = 'id';
        $direction = 'ASC';

        if(isset($_GET['col'])){
            $column = $_GET['col'];
        }
        if(isset($_GET['dir'])){
            $direction = $_GET['dir'];
        }

        //search
        $result = $this->userModel->findByEmailAndName($emailPhrase, $namePhrase, $page, $column, $direction);
        $_SESSION['flash_message']['search']['success'] = getMessage('search_success');
        if (isset($result)) {
            retrieveOldFormData();
            $this->render('searchUser', ['data' => $result]);
        } else {
            retrieveOldFormData();
            $this->render('searchUser');
        }
    }

    //edit/update - USER(admin)
    function editUser()
    {
        //validate input
        $method = $_SERVER['REQUEST_METHOD'];

        if (!isset($_SESSION['flash_message']['update_target']['id'])) {
            $_SESSION['flash_message']['update_id']['not_found'] = getMessage('no_id_found');
        }
        $id = $_SESSION['flash_message']['update_target']['id'];
        $location = '/management/user/editPageUser?id=' . $id;

        if (!validateUpdateFormForUser($method, $id)) {
            retrieveOldFormData();
            $_SESSION['flash_message']['edit']['failed'] = getMessage('update_failed');
            header('Location: ' . $location);
            exit;
        }

        //try to update (input id and value to change)
        $rowAffected = $this->userModel->update($id, $_POST);

        if ($rowAffected == 0 || $rowAffected > 1) {
            $_SESSION['flash_message']['edit']['failed'] = getMessage('update_failed');
            retrieveOldFormData();
            header('Location: ' . $location);
            exit;
        }
        else if ($rowAffected == 1) {
            $folder =  $_SESSION['avatar_folder_when_success_update'];
            if (file_exists($folder)) {
                unlink($folder);
                rename($_SESSION['avatar_temp'], $folder);
            } else {
                rename($_SESSION['avatar_temp'], $folder);
            }
            $_SESSION['flash_message']['edit']['success'] = getMessage('update_success');
            unset($_SESSION['avatar_folder_when_success_update']);
            clearTemp();
            retrieveOldFormData();
            header('Location: /management/user/searchPageUser');
            exit;
        }
    }

    //delete - USER(admin)
    function deleteUser()
    {
        //collecting $id to delete from GET
        $id = null;

        //if $_GET['id'] is empty or not set back to search with message
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            $_SESSION['flash_message']['id']['no_id_found'] = getMessage('no_id_found');
            header('Location: /management/user/searchPageUser');
            exit;
        }

        $id = $_GET['id'];
        //if $id failed validate
        if (validateID($id) !== 0) {
            $_SESSION['flash_message']['id']['invalid'] = getMessage('invalid_id');
            header('Location: /management/user/searchPageUser');
            exit;
        }

        //if $id passed validate
        //delete
        $rowChange = $this->userModel->deleteById($id);
        if ($rowChange == 1) {
            $_SESSION['flash_message']['delete']['success'] = getMessage('delete_success');
        } else {
            $_SESSION['flash_message']['delete']['failed'] = getMessage('delete_failed');
        }

        header('Location: /management/user//searchPageUser');
        exit;
    }
}