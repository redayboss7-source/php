<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$msg = "";
$msg_type = "";

// ── DELETE ──────────────────────────────────────────────
if (isset($_GET['delete'])) {
    $del_id = $_GET['delete'];
    if (file_exists("data.txt")) {
        $rows = file("data.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $new_rows = [];
        foreach ($rows as $row) {
            $d = explode("|", $row);
            if ($d[0] !== $del_id) {
                $new_rows[] = $row;
            } else {
                // Delete image if not default
                if (!empty($d[7]) && $d[7] !== 'upload/default.png' && file_exists($d[7])) {
                    @unlink($d[7]);
                }
            }
        }
        file_put_contents("data.txt", implode("\n", $new_rows) . (count($new_rows) ? "\n" : ""));
    }
    header("Location: admin.php?msg=deleted");
    exit();
}

if (isset($_GET['msg']) && $_GET['msg'] == 'deleted') {
    $msg = "✅ User deleted successfully.";
    $msg_type = "success";
}
if (isset($_GET['msg']) && $_GET['msg'] == 'updated') {
    $msg = "✅ User updated successfully.";
    $msg_type = "success";
}

// ── EDIT SAVE ────────────────────────────────────────────
if (isset($_POST['save_edit'])) {
    $edit_id  = $_POST['edit_id'];
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $address  = trim($_POST['address']);
    $contact  = trim($_POST['contact']);
    $username = trim($_POST['username']);
    $new_pass = $_POST['new_password'];

    if (file_exists("data.txt")) {
        $rows = file("data.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $updated = [];
        foreach ($rows as $row) {
            $d = explode("|", $row);
            if ($d[0] === $edit_id) {
                // Handle new image upload
                if (!empty($_FILES['image']['name'])) {
                    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, $allowed) && $_FILES['image']['size'] <= 5 * 1024 * 1024) {
                        if (!empty($d[7]) && $d[7] !== 'upload/default.png' && file_exists($d[7])) {
                            @unlink($d[7]);
                        }
                        $filename = time() . '_' . preg_replace('/\s+/', '_', $_FILES['image']['name']);
                        $img_path = "upload/" . $filename;
                        move_uploaded_file($_FILES['image']['tmp_name'], $img_path);
                        $d[7] = $img_path;
                    }
                }
                $d[1] = $name;
                $d[2] = $email;
                if (!empty($new_pass)) {
                    $d[3] = password_hash($new_pass, PASSWORD_DEFAULT);
                }
                $d[4] = $address;
                $d[5] = $contact;
                $d[6] = $username;
                $updated[] = implode("|", $d);
            } else {
                $updated[] = $row;
            }
        }
        file_put_contents("data.txt", implode("\n", $updated) . "\n");
    }
    header("Location: admin.php?msg=updated");
    exit();
}

// ── LOAD USERS ──────────────────────────────────────────
$users = [];
if (file_exists("data.txt")) {
    $rows = file("data.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($rows as $row) {
        $d = explode("|", $row);
        if (count($d) >= 8) $users[] = $d;
    }
}

// ── EDIT MODE ────────────────────────────────────────────
$edit_user = null;
if (isset($_GET['edit'])) {
    foreach ($users as $u) {
        if ($u[0] === $_GET['edit']) {
            $edit_user = $u;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - User Management</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="admin-body">

<!-- NAVBAR -->
<nav class="navbar">
    <div class="navbar-brand">
        <i class="fas fa-users-cog"></i> User Management
    </div>
    <div class="navbar-right">
        <span><i class="fas fa-user-circle"></i> <?= htmlspecialchars($_SESSION['user']) ?></span>
        <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</nav>

<div class="admin-container">
    <?php if ($msg): ?>
        <div class="alert alert-<?= $msg_type ?>"><?= $msg ?></div>
    <?php endif; ?>

    <!-- EDIT MODAL (inline) -->
    <?php if ($edit_user): ?>
    <div class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3><i class="fas fa-user-edit"></i> Edit User</h3>
                <a href="admin.php" class="modal-close"><i class="fas fa-times"></i></a>
            </div>
            <form method="POST" enctype="multipart/form-data" class="auth-form">
                <input type="hidden" name="edit_id" value="<?= htmlspecialchars($edit_user[0]) ?>">

                <div class="edit-avatar">
                    <?php if (!empty($edit_user[7]) && file_exists($edit_user[7])): ?>
                        <img src="<?= htmlspecialchars($edit_user[7]) ?>" id="editPreview">
                    <?php else: ?>
                        <div class="avatar-placeholder"><i class="fas fa-user"></i></div>
                    <?php endif; ?>
                </div>

                <div class="form-row">
                    <div class="input-group">
                        <i class="fas fa-id-badge"></i>
                        <input type="text" value="<?= htmlspecialchars($edit_user[0]) ?>" disabled>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Username" required value="<?= htmlspecialchars($edit_user[6]) ?>">
                    </div>
                </div>
                <div class="input-group">
                    <i class="fas fa-signature"></i>
                    <input type="text" name="name" placeholder="Full Name" required value="<?= htmlspecialchars($edit_user[1]) ?>">
                </div>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" required value="<?= htmlspecialchars($edit_user[2]) ?>">
                </div>
                <div class="form-row">
                    <div class="input-group">
                        <i class="fas fa-map-marker-alt"></i>
                        <input type="text" name="address" placeholder="Address" value="<?= htmlspecialchars($edit_user[4]) ?>">
                    </div>
                    <div class="input-group">
                        <i class="fas fa-phone"></i>
                        <input type="text" name="contact" placeholder="Contact" value="<?= htmlspecialchars($edit_user[5]) ?>">
                    </div>
                </div>
                <div class="input-group">
                    <i class="fas fa-key"></i>
                    <input type="password" name="new_password" placeholder="New Password (leave blank to keep)">
                    <span class="toggle-pass" onclick="togglePass(this)"><i class="fas fa-eye"></i></span>
                </div>
                <div class="file-upload-area" onclick="document.getElementById('editImg').click()" style="padding:12px;">
                    <i class="fas fa-image"></i> <span>Change Profile Photo</span>
                    <input type="file" name="image" id="editImg" accept="image/*" style="display:none" onchange="previewEdit(this)">
                </div>
                <div style="display:flex;gap:10px;">
                    <button type="submit" name="save_edit" class="btn-primary" style="flex:1;">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <a href="admin.php" class="btn-cancel" style="flex:1;">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- STATS CARDS -->
    <div class="stats-row">
        <div class="stat-card">
            <i class="fas fa-users"></i>
            <div>
                <div class="stat-num"><?= count($users) ?></div>
                <div class="stat-label">Total Users</div>
            </div>
        </div>
        <div class="stat-card">
            <i class="fas fa-user-check"></i>
            <div>
                <div class="stat-num"><?= count(array_filter($users, fn($u) => !empty($u[7]) && $u[7] !== 'upload/default.png')) ?></div>
                <div class="stat-label">With Photos</div>
            </div>
        </div>
        <div class="stat-card">
            <i class="fas fa-shield-alt"></i>
            <div>
                <div class="stat-num"><?= count(array_filter($users, fn($u) => !empty($u[3]) && str_starts_with($u[3], '$2'))) ?></div>
                <div class="stat-label">Secure Passwords</div>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-card">
        <div class="table-header">
            <h3><i class="fas fa-list"></i> All Users</h3>
            <a href="register.php" class="btn-add"><i class="fas fa-user-plus"></i> Add User</a>
        </div>

        <?php if (empty($users)): ?>
            <div class="empty-state">
                <i class="fas fa-users-slash"></i>
                <p>No users found. <a href="register.php">Register one now!</a></p>
            </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Password</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $i => $d): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <?php
                            $imgSrc = (!empty($d[7]) && file_exists(trim($d[7])))
                                ? htmlspecialchars(trim($d[7]))
                                : '';
                            ?>
                            <?php if ($imgSrc): ?>
                                <img src="<?= $imgSrc ?>" class="user-thumb" onclick="showImg('<?= $imgSrc ?>')" title="Click to enlarge">
                            <?php else: ?>
                                <div class="no-photo"><i class="fas fa-user"></i></div>
                            <?php endif; ?>
                        </td>
                        <td><span class="badge"><?= htmlspecialchars($d[0]) ?></span></td>
                        <td><?= htmlspecialchars($d[1]) ?></td>
                        <td><?= htmlspecialchars($d[2]) ?></td>
                        <td><strong><?= htmlspecialchars($d[6]) ?></strong></td>
                        <td><?= htmlspecialchars($d[5]) ?></td>
                        <td><?= htmlspecialchars($d[4]) ?></td>
                        <td>
                            <?php if (str_starts_with($d[3], '$2')): ?>
                                <span class="status-badge success"><i class="fas fa-lock"></i> Hashed</span>
                            <?php else: ?>
                                <span class="status-badge danger"><i class="fas fa-unlock"></i> Plain</span>
                            <?php endif; ?>
                        </td>
                        <td class="action-btns">
                            <a href="admin.php?edit=<?= urlencode($d[0]) ?>" class="btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="admin.php?delete=<?= urlencode($d[0]) ?>"
                               class="btn-delete" title="Delete"
                               onclick="return confirm('Delete user <?= htmlspecialchars($d[1]) ?>?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Image Lightbox -->
<div id="lightbox" onclick="this.style.display='none'" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.85);z-index:9999;display:none;align-items:center;justify-content:center;">
    <img id="lightbox-img" src="" style="max-width:90%;max-height:90%;border-radius:12px;box-shadow:0 20px 60px rgba(0,0,0,.5);">
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
function showImg(src) {
    const lb = document.getElementById('lightbox');
    document.getElementById('lightbox-img').src = src;
    lb.style.display = 'flex';
}
function previewEdit(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            let img = document.getElementById('editPreview');
            if (!img) {
                img = document.createElement('img');
                img.id = 'editPreview';
                document.querySelector('.edit-avatar').appendChild(img);
            }
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>
