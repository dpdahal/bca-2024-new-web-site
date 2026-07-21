<?php
$db = Database::Instance();
$role=$_SESSION['user']['role'];

$errors=[
    'name'=>'',
];

$old=[
   'name'=>'',

];

if(!empty($_POST)){
   
    foreach($_POST as $key=>$value){
        if(empty($value)){
            $errors[$key] = ucfirst($key) . ' is required.';
        }else{
            $old[$key] = $value;
        }
    }

    $name=$_POST['name'] ?? '';

    $findCategory = $db->CustomQuery("SELECT * FROM category WHERE name ='$name'");
    if(!empty($findCategory)){
        $errors['name'] = 'Category already exists.';
    }

    if(!array_filter($errors)){
        $data = [
            'name' => $_POST['name'],
            'slug' => strtolower(str_replace(' ', '-', $_POST['name'])),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        $response=$db->Insert('category', $data);
        if($response){
            $_SESSION['success'] = 'Category added successfully!';
            redirect_back();
        }else{
            $_SESSION['error'] = 'Failed to add category. Please try again.';
            redirect_back();
        }

    }
}


$categoryData=$db->SelectAll('category');

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
        <h1 class="card-title">Manage Category</h1>
      <h1>  <?=message()?></h1>
          <form action=""  method="POST">
                <div class="mb-3">
                    <label for="category" class="form-label">Category Name:
                        <span class="text-danger">
                            <?php echo $errors['name'] ?? ''; ?>
                        </span>
                    </label>
                    <input type="text" class="form-control" id="category" name="name"
                           value="<?php echo $old['name'] ?? ''; ?>" placeholder="Enter category name">
                </div>

                
                <button type="submit" class="btn btn-primary w-100">
                    Add Category 
                </button>
            </form>
            <div class="mt-3">
                <h2>Category List</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categoryData as $key=>$category) : ?>
                            <tr>
                                <td><?=$key+1?></td>
                                <td><?=$category->name ?></td>
                                <td><?php echo $category->created_at; ?></td>
                                <td><?php echo $category->updated_at; ?></td>
                                <td>
                                    <a href="edit_category.php?id=<?php echo $category->id; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="delete_category.php?id=<?php echo $category->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
         
      </div>
    </div>
  </div>
</main>
<?php endif; ?>
