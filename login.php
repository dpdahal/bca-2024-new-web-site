<?php 
require_once 'config/config.php';
require_once 'config/database.php';

$db= Database::Instance();


$errors=[
    'email'=>'',
    'password'=>'',

];

$old=[
    'email'=>'',
    'password'=>'',
  
];


if(!empty($_POST)){
   foreach($_POST as $key=>$value){
        if(empty($value)){
            $errors[$key] = ucfirst($key) . ' is required.';
        }else{
            $old[$key] = $value;
        }
    }

    if(!array_filter($errors)){
        $dInstance = Database::Instance();
        $email=$_POST['email'];
        $password=md5($_POST['password']);

    $findData = $db->CustomQuery("SELECT * FROM users WHERE email='$email' AND password ='$password'");
    if (count((array)$findData) === 0) {
            $_SESSION['error'] = 'Invalid email or password.';
            redirect_back();
    }else{
        $users =$findData[0];
        $_SESSION['user'] = [
            'id' => $users->id,
            'name' => $users->name,
            'email' => $users->email,
            'gender' => $users->gender,
            'role' => $users->role,
        ];
        $_SESSION['success'] = 'Login successful! Welcome, ' . $users->name;
        header('Location: admin/index.php');
    
    }
}
    

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Register - BBC
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<style>
    :root {
            --primary-color: #0d6efd;
            --error-color: #dc3545;
            --success-color: #198754;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .form-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            background-color: #ffffff;
            transition: transform 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-5px);
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #344767;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(13,110,253,.15);
        }

        .password-wrapper {
            position: relative;
        }



        .password-strength {
            height: 5px;
            margin-top: 5px;
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .success-message {
            display: none;
            margin-top: 1rem;
            animation: slideIn 0.5s ease;
        }

        .btn-primary {
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13,110,253,.2);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .loading {
            display: none;
            margin-left: 8px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .input-group-text {
            background-color: #f8f9fa;
            border: 2px solid #e9ecef;
            border-right: none;
        }

        .form-control.is-invalid {
            border-color: var(--error-color);
            background-image: none;
        }

        .form-control.is-valid {
            border-color: var(--success-color);
            background-image: none;
        }

        .progress {
            height: 4px;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4">Log In:

            </h2>
            <div class="row">
                <div class="col-md-12">
                     <?=message();?>
                </div>
            </div>
            <form action=""  method="POST">
                

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address:
                        <span class="text-danger">
                            <?php echo $errors['email'] ?? ''; ?>
                        </span>
                    </label>
                    <input type="email" class="form-control" id="email" name="email"
                           value="<?php echo $old['email'] ?? ''; ?>" placeholder="Enter your email">
                </div>

               

                <div class="mb-3">
                    <label for="password" class="form-label">Password:
                        <span class="text-danger">
                            <?php echo $errors['password'] ?? ''; ?>
                        </span>
                    </label>
                    <input type="password" class="form-control" id="password" name="password" 
                           value="<?php echo $old['password'] ?? ''; ?>" placeholder="Create a strong password">
                   
                </div>

               
                <button type="submit" class="btn btn-primary w-100">
                    Log In 
                </button>
            </form>
             <a href="register.php">
                <p class="text-center mt-3">Don't have an account? Register here.</p>
             </a>
        </div>
    </div>
</body>
</html>