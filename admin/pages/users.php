<?php
$db = Database::Instance();
$role=$_SESSION['user']['role'];
 $id=$_SESSION['user']['id'];
if($role=='admin'){
     $users = $db->CustomQuery("SELECT * FROM users WHERE id!=$id");
}else{
    $users = $db->CustomQuery("SELECT * FROM users WHERE id= $id");
}

?>


<main id="main">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Users List</h5>
        <?=message();?>
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Sn</th>
              <th>Name</th>
              <th>Email</th>
              <th>Gender</th>
              <th>Role</th>
              <th>Profile</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $key=>$user) : ?>
              <tr>
                <th><?= $key + 1 ?></th>
                <td><?= $user->name ?></td>
                <td><?= $user->email ?></td>
                <td><?= $user->gender ?></td>
                <td><?= $user->role ?></td>
                <td>
                  <?php if ($user->profile) : ?>
                    <img src="<?= base_url('public/uploads/' . $user->profile) ?>" alt="Profile" width="50">
                  <?php else : ?>
                    N/A
                  <?php endif; ?>
                
                <td>
                  <a href="<?= admin_url('user-edit.php?id=' . $user->id) ?>" class="btn btn-sm btn-primary">Edit</a>
                  <?php if($role=='admin'): ?>
                  <a href="<?= admin_url('user-delete.php?id=' . $user->id) ?>" class="btn btn-sm btn-danger">Delete</a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
      </div>
    </div>
  </div>
</main>
