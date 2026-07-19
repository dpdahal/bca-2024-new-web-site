<?php
$db = Database::Instance();
$id=$_GET['id'] ?? null;
$user = $db->CustomQuery("SELECT * FROM users WHERE id= $id");
$user = $user[0] ?? null;
$errors=[
    'name'=>'',
    'email'=>'',
    'gender'=>'',
];

if(!empty($_POST)){
   foreach($_POST as $key=>$value){
        if(empty($value)){
            $errors[$key] = ucfirst($key) . ' is required.';
        }else{
            $old[$key] = $value;
        }
    }

    $nameRegex = '/^[a-zA-Z\s]+$/';
    if(!empty($_POST['name']) && !preg_match($nameRegex, $_POST['name'])){
        $errors['name'] = 'Name can only contain letters and spaces.';
    }



    if(!array_filter($errors)){
        $dInstance = Database::Instance();
        $data = [
            'name' => $_POST['name'],
            'gender' => $_POST['gender'],
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        $response=$dInstance->Update('users', $data, "id",[$id]);
        if($response){
            $_SESSION['success'] = 'User updated successfully.';
            redirect_back();
        }else{
            $errors['error'] = 'An error occurred while updating the user. Please try again.';
 redirect_back();
        }
    }
}


?>


<main id="main">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Update User</h5>
        <?=message();?>
          <form action=""  method="POST">
                <div class="mb-3">
                    <label for="fullName" class="form-label">Full Name:
                        <span class="text-danger">
                            <?php echo $errors['name'] ?? ''; ?>
                        </span>
                    </label>
                    <input type="text" class="form-control" id="fullName" name="name"
                           value="<?=$user->name ?>" placeholder="Enter your full name">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address:
                        <span class="text-danger">
                            <?php echo $errors['email'] ?? ''; ?>
                        </span>
                    </label>
                    <input type="text" class="form-control" id="email" name="email"
                          readonly value="<?=$user->email ?>" placeholder="Enter your email">
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label">Gender:
                        <span class="text-danger">
                            <?php echo $errors['gender'] ?? ''; ?>
                        </span>
                    </label>
                    <select class="form-control" id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="male" <?php echo ($user->gender ?? '') === 'male' ? 'selected' : ''; ?>>Male</option>
                        <option value="female" <?php echo ($user->gender ?? '') === 'female' ? 'selected' : ''; ?>>Female</option>
                        <option value="other" <?php echo ($user->gender ?? '') === 'other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>

                

                
                <button type="submit" class="btn btn-primary w-100">
                    Update User
                </button>
            </form>
        </div>
    </div>
  </div>
</main>
