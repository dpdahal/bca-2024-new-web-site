<?php 
require_once 'config/config.php';
require_once 'config/database.php';

$errors=[
    'name'=>'',
    'email'=>'',
    'password'=>'',
    'confirm_password'=>'',
    'gender'=>'',
];
$old=[
   'name'=>'',
    'email'=>'',
    'password'=>'',
    'confirm_password'=>'',
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

    $email = $_POST['email'] ?? '';
    if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'Invalid email format.';
    }

    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    if(!empty($password) && !empty($confirmPassword) && $password !==$confirmPassword){
        $errors['confirm_password'] = 'Passwords do not match.';
    }


    if(!array_filter($errors)){
        $dInstance = Database::Instance();
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'gender' => $_POST['gender'],
            'password' => md5($_POST['password']),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        $response=$dInstance->Insert('users', $data);
        if($response){
            $_SESSION['success'] = 'Registration successful! You can now log in.';
            redirect_back();
        }else{
            $errors['general'] = 'An error occurred while registering. Please try again.';
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
            <h2 class="text-center mb-4">Create Account:

            </h2>
            <div class="row">
                <div class="col-md-12">
                     <?=message();?>
                </div>
            </div>
            <form action=""  method="POST">
                <div class="mb-3">
                    <label for="fullName" class="form-label">Full Name:
                        <span class="text-danger">
                            <?php echo $errors['name'] ?? ''; ?>
                        </span>
                    </label>
                    <input type="text" class="form-control" id="fullName" name="name"
                           value="<?php echo $old['name'] ?? ''; ?>" placeholder="Enter your full name">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address:
                        <span class="text-danger">
                            <?php echo $errors['email'] ?? ''; ?>
                        </span>
                    </label>
                    <input type="text" class="form-control" id="email" name="email"
                           value="<?php echo $old['email'] ?? ''; ?>" placeholder="Enter your email">
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label">Gender:
                        <span class="text-danger">
                            <?php echo $errors['gender'] ?? ''; ?>
                        </span>
                    </label>
                    <select class="form-control" id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="male" <?php echo ($old['gender'] ?? '') === 'male' ? 'selected' : ''; ?>>Male</option>
                        <option value="female" <?php echo ($old['gender'] ?? '') === 'female' ? 'selected' : ''; ?>>Female</option>
                        <option value="other" <?php echo ($old['gender'] ?? '') === 'other' ? 'selected' : ''; ?>>Other</option>
                    </select>
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

                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password:
                        <span class="text-danger">
                            <?php echo $errors['confirm_password'] ?? ''; ?>
                        </span>
                    </label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirm_password" 
                           value="<?php echo $old['confirm_password'] ?? ''; ?>" placeholder="Confirm your password">
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    Create Account 
                </button>
            </form>
            <hr>
            <a href="login.php">Already have an account? Log in here.</a>
        </div>
    </div>
</body>
</html>