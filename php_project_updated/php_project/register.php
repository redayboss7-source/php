<?php
$msg = "";
$msg_type = "";

if (isset($_POST['submit'])) {
    $id       = trim($_POST['id']);
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $pass     = $_POST['password'];
    $repass   = $_POST['repassword'];
    $address  = trim($_POST['address']);
    $contact  = trim($_POST['contact']);
    $username = trim($_POST['username']);

    // Validation
    if (empty($id) || empty($name) || empty($email) || empty($pass) || empty($username)) {
        $msg = "❌ Please fill all required fields.";
        $msg_type = "error";
    } elseif ($pass !== $repass) {
        $msg = "❌ Passwords do not match!";
        $msg_type = "error";
    } elseif (strlen($pass) < 6) {
        $msg = "❌ Password must be at least 6 characters.";
        $msg_type = "error";
    } else {
        // Check duplicate username/id
        $duplicate = false;
        if (file_exists("data.txt")) {
            $rows = file("data.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($rows as $row) {
                $d = explode("|", $row);
                if ($d[0] == $id || $d[6] == $username) {
                    $duplicate = true;
                    break;
                }
            }
        }

        if ($duplicate) {
            $msg = "❌ ID or Username already exists!";
            $msg_type = "error";
        } else {
            // Image upload
            $img_path = "upload/default.png";
            if (!empty($_FILES['image']['name'])) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, $allowed)) {
                    $msg = "❌ Only JPG, PNG, GIF, WEBP images allowed.";
                    $msg_type = "error";
                } elseif ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                    $msg = "❌ Image size must be under 5MB.";
                    $msg_type = "error";
                } else {
                    $filename = time() . '_' . preg_replace('/\s+/', '_', $_FILES['image']['name']);
                    $img_path = "upload/" . $filename;
                    move_uploaded_file($_FILES['image']['tmp_name'], $img_path);
                }
            }

            if (empty($msg)) {
                $hashed = password_hash($pass, PASSWORD_DEFAULT);
                $data = "$id|$name|$email|$hashed|$address|$contact|$username|$img_path\n";
                file_put_contents("data.txt", $data, FILE_APPEND);
                header("Location: index.php?msg=registered");
                exit();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - User Management</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-card register-card">
        <div class="auth-header">
            <div class="auth-icon"><i class="fas fa-user-plus"></i></div>
            <h2>Create Account</h2>
            <p>Fill in your details to register</p>
        </div>

        <?php if ($msg): ?>
            <div class="alert alert-<?= $msg_type ?>"><?= $msg ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="auth-form">
            <div class="form-row">
                <div class="input-group">
                    <i class="fas fa-id-badge"></i>
                    <input type="text" name="id" placeholder="ID *" required value="<?= isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '' ?>">
                </div>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Username *" required value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
                </div>
            </div>

            <div class="input-group">
                <i class="fas fa-signature"></i>
                <input type="text" name="name" placeholder="Full Name *" required value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
            </div>

            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email *" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
            </div>

            <div class="form-row">
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password *" required>
                    <span class="toggle-pass" onclick="togglePass(this)"><i class="fas fa-eye"></i></span>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="repassword" placeholder="Confirm Password *" required>
                    <span class="toggle-pass" onclick="togglePass(this)"><i class="fas fa-eye"></i></span>
                </div>
            </div>

            <div class="input-group">
                <i class="fas fa-map-marker-alt"></i>
                <input type="text" name="address" placeholder="Address" value="<?= isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '' ?>">
            </div>

            <div class="input-group">
                <i class="fas fa-phone"></i>
                <input type="text" name="contact" placeholder="Contact Number" value="<?= isset($_POST['contact']) ? htmlspecialchars($_POST['contact']) : '' ?>">
            </div>

            <div class="file-upload-area" onclick="document.getElementById('imgInput').click()">
                <img id="preview" src="" alt="" style="display:none; max-width:100px; border-radius:50%; margin-bottom:8px;">
                <i class="fas fa-cloud-upload-alt" id="uploadIcon" style="font-size:2rem; color:#667eea;"></i>
                <p id="uploadText">Click to upload profile photo</p>
                <small>JPG, PNG, GIF, WEBP (Max 5MB)</small>
                <input type="file" name="image" id="imgInput" accept="image/*" style="display:none" onchange="previewImage(this)">
            </div>

            <button type="submit" name="submit" class="btn-primary">
                <i class="fas fa-user-plus"></i> Register
            </button>
        </form>

        <div class="auth-footer">
            <p>Already have an account? <a href="index.php">Login</a></p>
        </div>
    </div>
</div>

<script>
function togglePass(el) {
    const input = el.previousElementSibling;
    const icon = el.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('preview').style.display = 'block';
            document.getElementById('uploadIcon').style.display = 'none';
            document.getElementById('uploadText').textContent = input.files[0].name;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>
