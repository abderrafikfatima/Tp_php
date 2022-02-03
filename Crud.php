<?php 
      $pdo = new PDO(
        "mysql:host=localhost;dbname=ehtp", 
        "root", 
        ""
    );
                                 
    $sql = "SELECT * FROM users";
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $update = false;
    $e = '';
    $p = '';
    $r = '';
    $id = 0;
      if (isset($_POST['add'])){
        $e = $_POST['email'];
        $p = $_POST['pass'];
        $r = $_POST['role'];
        $sql = "INSERT INTO users VALUES ('','$e', '$p', '$r')";
        $pdo->exec($sql);
        header("location: Crud.php");
        exit();

      }

        
        if (isset($_GET['delete'])){
          $id = $_GET['delete'];
          $sql = "DELETE FROM users WHERE id='$id'";
          $pdo->exec($sql);
          header("location: Crud.php");
          exit();
        }

        if (isset($_GET['edit'])){
          $id = $_GET['edit'];
          $update = true;
          $sql = "SELECT * FROM users WHERE id='$id'";
          $stmt = $pdo->query($sql);
          $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
          if(!$user)
          header('location:index.php?msg=enreg supp');
        }
      

        if(isset($_POST['update'])){
          $id = $_POST['id'];
          $e = $_POST['email'];
          $p = $_POST['pass'];
          $r = $_POST['role'];
          $sql = "UPDATE users SET email='$e', pass='$p', role='$r' WHERE id='$id'";
          $pdo->exec($sql);
          header("location: Crud.php");
          exit();
        }
      
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Exemple</title>
    <!-- CSS only -->
<link rel="stylesheet" href="https://bootswatch.com/3/cerulean/bootstrap.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
<div class="container">
    <h1>Users List</h1>
    <?php if(isset($_GET['msg'])) : ?>
        <div class="alert alert-warning">
            Enregistrement déjà supprimé par quelcun d'autre
        </div>
    <?php endif ?>
    <form action="" method ="POST">
      <input type="hidden" name = "id" value = <?php echo $id; ?>>
        <input type="text" name="email" class="form-control" value="<?php echo $e;?>"placeholder="Put Your Email">
        <input type="password" name="pass" class="form-control" value="<?php echo $p;?>" placeholder="Put Your PassWord">
        <select name="role" class="form-control">
            <option value="admin"<?= $r == 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="guest"<?= $r == 'guest' ? 'selected' : '' ?>>guest</option>
        </select>
        <div class="form-group">
          <?php 
            if($update == true):
              ?>
              <button type="update" name="update" class="btn btn-info">Update</button>
          <?php
            else:
              ?>
              <button type="add" name="add" class="btn btn-primary">Add</button>
          
          <?php endif; ?>

        
      </div> 
    </form>
        <table class="table table-striped">
        <thead>
            <tr>
                <th>EMAIL</th>
                <th>PASSWORD</th>
                <th>ROLE</th>
                <th collspan = "2">ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($users as $user) :
            ?>
                <tr>
                    <td><?php echo $user['email'] ?></td>
                    <td><?php echo $user['pass'] ?></td>
                    <td><?php echo $user['role'] ?></td>
                    <td><a onclick="confirmer(event)" class="btn btn-danger" href="Crud.php?delete=<?php echo $user['id']; ?>"data-toggle="tooltip"><i class="bi bi-trash"></i></a></td>
                    <td><a class="btn btn-warning" href="Crud.php?edit=<?php echo $user['id']; ?>"data-toggle="tooltip"><i class="bi bi-pencil-square"></i></a></td>
                </tr>
            <?php
            endforeach; ?>
        </tbody>
    </table>
</div>
<script>
        function confirmer(evt) {
            if(!confirm('Etes vous sur de vouloir supprimer'))
                evt.preventDefault()
        }
    </script>
</body>
</html>