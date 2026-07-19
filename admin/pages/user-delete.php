<?php
$db = Database::Instance();
$id=$_GET['id'] ?? null;
$role=$_SESSION['user']['role'];
$user = $db->getById('users', $id);

if(!empty($_POST)){
    $id=$_POST['id'] ?? null;
   $result= $db->Delete('users','id', [$id]);
   if($result){
    $_SESSION['success']="User deleted successfully.";
    header('Location: '.admin_url('users'));
    exit();
   }else{
      echo "Error deleting user.";
   }
}

?>
<?php if ($role=='user') : ?>
    <main id="main">
  <div class="col-md-12">
    <div class="alert alert-danger">
        Sorry, you do not have permission to delete this account.
         Only admins can perform this action.
    </div>
    </div>
    </main>
<?php else : ?>
<main id="main">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h1 class="card-title">
            Are you sure you want to delete this 
            <span class="text-danger"><?= $user->name ?></span> account?
           
        </h1>
         <form action="<?= admin_url('user-delete.php?id=' . $user->id) ?>" method="POST" style="display: inline;">
                <input type="hidden" name="id" value="<?= $user->id ?>">
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </form>
      </div>
    </div>
  </div>
</main>
<?php endif; ?>
