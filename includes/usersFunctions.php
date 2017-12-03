<?php

require_once("usersModel.php");



function usersMain(){
    $users = new Users();
    $currentUser = $users->getUser($_COOKIE['datas']);
    if($currentUser->user_type != 1):
?>
<a href="?add" title="Add" class="link-but add">Add</a>
<?php endif; ?>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Type</th>
        <?php if($currentUser->user_type != 1): ?>
        <th>Action</th>
        <?php endif; ?>
    </tr>
<?php foreach($row = $users->getUsers() as $data) { ?>
    <tr>
        <td><?php echo $data->user_id; ?></td>
        <td><?php echo $data->user_name; ?></td>
        <td><?php echo typeName($data->user_type); ?></td>
        <?php if($currentUser->user_type != 1): ?>
        <td>
            <a href="?edit=<?php echo $data->user_id; ?>" title="Edit" class="link-but">Edit</a>
            <?php if($_COOKIE['datas'] != $data->user_id): ?>
            <a href="?delete=<?php echo $data->user_id; ?>" title="Delete" class="link-but">Delete</a>
            <?php endif; ?>
        </td>
        <?php endif; ?>
    </tr>
<?php }?>
</table>
<?php
}

function addUser(){
    $users = new Users();
    $currentUser = $users->getUser($_COOKIE['datas']);
    if($currentUser->user_type == 1) reload();
    if(isset($_POST['add'])) if($_POST['add'] == "Add"){
        $users->add($_POST);
        header("location: ".$GLOBALS['base']."/users.php");
    }
?>
<form method="post">
    <input type="text" name="name" placeholder="Name"<?php echo (isset($_POST['name'])? " value=\"".$_POST['name'].'"': null) ?>>
    <input type="password" name="passcode" placeholder="Passcode">
    <select name="type">
        <option value="1"<?php 
            if(isset($_POST['type']))
                if($_POST['type'] == 1)
                    echo " selected";
        ?>>SalesAssociate</option>
        <option value="0"<?php 
            if(isset($_POST['type']))
                if($_POST['type'] == 0)
                    echo " selected";
        ?>>Manager</option>
    </select>
    <input type="submit" name="add" value="Add">
</form>
<?php
}

function editUser(){
    $users = new Users();
    $currentUser = $users->getUser($_COOKIE['datas']);
    if($currentUser->user_type == 1) reload();
    $data = $users->getUser($_GET['edit']);
    if(isset($_POST['save'])) if($_POST['save'] == "Save"){
        unset($_POST['save']);
        if($_POST['name'] == $data->user_name) unset($_POST['name']);
        if($_POST['passcode'] == '') unset($_POST['passcode']);
        if($_POST['type'] == $data->user_type
            || $_GET['edit'] == $_COOKIE['datas'])
            unset($_POST['type']);
        if(count($_POST) == 0) header("location: ".$_SERVER['REQUEST_URI']);
        $_POST['id'] = $_GET['edit'];
        $users->setUser($_POST);
        header("location: ".$GLOBALS['base']."/users.php");
    }
?>
<form method="post">
    <input type="text" name="name" placeholder="Name" value="<?php echo $data->user_name; ?>">
    <input type="password" name="passcode" placeholder="Passcode">
<?php if($_GET['edit'] != $_COOKIE['datas']): ?>
    <select name="type">
        <option value="1"<?php
            if($data->user_type == 1)
                echo " selected";
        ?>>SalesAssociate</option>
        <option value="0"<?php
            if($data->user_type == 0)
                echo " selected";
        ?>>Manager</option>
    </select>
<?php endif; ?>
    <input type="submit" name="save" value="Save">
</form>
<?php
}

function deleteUser(){
    $users = new Users();
    $currentUser = $users->getUser($_COOKIE['datas']);
    $data = $users->getUser($_GET['delete']);
    if($currentUser->user_type == 1
        || $_COOKIE['datas'] == $_GET['delete'])
        reload();
    if(isset($_POST['delete'])) if($_POST['delete'] == "Yes"){
        $users->delete($_GET['delete']);
        reload();
    }
?>
<form method="post">
Delete user id <?php echo $_GET['delete']." ".$data->user_name; ?>.
Are you sure? 
<input type="submit" name="delete" value="Yes">
</form>
<?php
}

function typeName($x){
    switch($x){
        case 0: return "Manager";
        case 1: return "SalesAssociate";
        default: return "Unknown";
    }
}

function reload(){
    header("location: ".$GLOBALS['base']."/users.php");
}

?>
