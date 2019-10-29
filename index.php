<?php 
  session_start();
  require './functions/usuariosFunctions.php';
  include './includes/header.php'; 

  if ($_POST) {
    $usuario = login($_POST['email'], $_POST['senha']);

    if ($usuario) {
      $_SESSION['usuario'] = $usuario;
      header('Location: indexProdutos.php');
    }

    $erro = true;
  }
?>
<main>
  <div class="container d-flex flex-column justify-content-center align-items-center my-4">
    <?php if(isset($erro) && $erro) : ?>
      <div class="alert alert-danger col-md-6">E-mail ou senha incorretos</div>
    <?php endif; ?>
    <form action="" method="POST" class="col-md-6">
      <div class="form-group">
        <label for="emailInput">E-mail</label>
        <input id="emailInput" type="text" name="email" class="form-control">
      </div>
      <div class="form-group">
        <label for="senhaInput">Senha</label>
        <input id="senhaInput" type="password" name="senha" class="form-control">
      </div>
      <div class="form-group">
        <a href="createUsuario.php"><small>Ainda não tenho cadastro</small></a>
      </div>
      <div class="form-group">
        <button class="btn btn-primary col-12">Logar</button>
      </div>
    </form>
  </div>
</main>
<?php include './includes/footer.php'; ?>
