<?php
print_r($_SESSION['user']);
$db = Database::Instance();
$id=$_GET['id'] ?? null;
$role=$_SESSION['user']['role'];
$user = $db->getById('users', $id);

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
      </div>
    </div>
  </div>
</main>
<?php endif; ?>
