<?php

session_start();

// var_dump($_SESSION['user']);

$database = new PDO(
    'mysql:host=devkinsta_db;dbname=userauthenticationhomework', 
    'root', 
    'viLXjKTLEziaMJLz'
  );


  $query = $database->prepare('SELECT * FROM users');
  $query->execute();
  
  
  //Global Variables
  // $_GET
  // $_POST
  // $_REQUEST
  // $_SERVER
  // var_dump($_POST['student']);
  $students = $query->fetchAll();
  
  if (
    $_SERVER['REQUEST_METHOD'] == 'POST'
  ) {
    if ($_POST['action'] == 'add') {
  
        $statement = $database->prepare(
            'INSERT INTO users  (name)
            VALUES (:name)'
        );
        $statement->execute([
            'name' => $_POST['email']
        ]);
        header('Location: /');
        exit;
    }
    if ($_POST['action' ] == 'delete'){
      $statement = $database -> prepare(
        'DELETE FROM users WHERE id = :id'
      );
      $statement->execute([
        'id' => $_POST['student_id']
      ]);
      header('Location: /');
      exit;
    }
  
    if ($_POST ['action']=='correct'){
      if ($_POST['student_complete'] == 0) {
        $statement = $database->prepare(
          'UPDATE students SET complete = 1 WHERE id = :id'
        );
        $statement->execute([
          'id' => $_POST['student_id']
        ]);
        header('Location: /');
        exit;
      } if ($_POST['student_complete'] == 1)  {
        $statement = $database -> prepare(
          'UPDATE students SET complete = 0 WHERE id = :id'
        );
  
        $statement->execute([
          'id' => $_POST ['student_id']
        ]);
        header('Location: /');
        exit;
      }
    }
  }
  ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Simple Auth</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
    />
    <style type="text/css">
      body {
        background: #f1f1f1;
      }
    </style>
  </head>
  <body>

    <div class="card rounded shadow-sm mx-auto my-4" style="max-width: 500px;">
      <div class="card-body">
        <div class="d-flex justify-content-center">
            <?php if ( isset( $_SESSION['user'])) : ?>
            <a href="logout.php" class="btn btn-link" id="logout">Logout</a>
            <p>testing</p>
            <?php else : ?>
                <h1 class="pr-2">My Classroom</h1>
            <a href="login.php" class="btn btn-link" id="login">Login</a>
            <a href="signup.php" class="btn btn-link" id="signup">Sign Up</a>
            <?php endif; ?>
        </div>
      </div>
    </div>

<?php foreach ( $students as $key => $student ) : ?>
                <div class="mb-2 d-flex justify-content-between gap-3">
                    <?php echo $key+1 .'.'; ?>
                    <?php echo $student['email']; ?>
                    <form method="POST" 
                    action="<?php echo $_SERVER ['REQUEST_URI'];?>">
                    <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                    <?php if(isset($_SESSION['user'])) : ?>
                    <input type="hidden" name="action" value="delete">
                    <button class="btn btn-danger btn-sm">Remove</button>
                    <?php endif; ?>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

    


  <!-- testing section -->
  

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
      crossorigin="anonymous"
    ></script>
  </body>
</html>