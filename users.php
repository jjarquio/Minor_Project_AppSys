<?php 
require_once("includes/header.php");
require_once("includes/navigation.php");
require_once("includes/usersFunctions.php"); ?>


<h1 id="Users_a">Users</h1>

<?php if(count($_GET) == 0):
    usersMain();
elseif(count($_GET) == 1): ?>
<a href="<?php echo "$base/users.php"; ?>">Back</a>
<?php
    if(isset($_GET['add'])){
        addUser();
    }else if(isset($_GET['edit'])){
        editUser();
    }else if(isset($_GET['delete'])){
        deleteUser();
    }else reload();
else:
    reload();
endif;
?>
</div>
<?php require_once("includes/footer.php"); ?>
