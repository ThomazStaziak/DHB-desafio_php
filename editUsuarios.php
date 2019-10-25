<?php 
  require './functions/usuariosFunctions.php';  
  include './includes/header_adm.php';

  if ($_GET && $_GET['id']) {
    $usuario = searchUsuario($_GET['id']);
  }

  if ($_POST) {
    $erros = [
      'nome' => '',
      'email' => '',
      'senha' => ''
    ];

    if (empty($_POST['nome'])) {
      $erros['nome'] = 'O campo nome é obrigatório';
    }

    if (empty($_POST['email'])) {
      $erros['email'] = 'O campo email é obrigatório';
    }

    if (strlen($_POST['senha']) < 6) {
      $erros['senha'] = 'A senha deve conter no mínimo 6 caracteres';
    }

    if ($_POST['senha'] != $_POST['confirmarSenha']) {
      $erros['senha'] = 'Senhas não coincidem';
    }

    if (
      empty($erros['nome']) &&
      empty($erros['email']) &&
      empty($erros['senha'])
    ) {
      $usuario = [
        'id' => $_POST['id'],
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'senha' => password_hash($_POST['senha'], PASSWORD_DEFAULT),
      ];

      $editou = editUsuario($usuario);

      if ($editou) header('Location: createUsuario.php');
    }
  }
?>
  <div class="container my-4">
     <div class="col">
          <h3>Editar usuário</h3>
          <form action="" method="POST">
            <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
            <div class="form-group">
              <label for="nomeInput">Nome</label>
              <input id="nomeInput" name="nome" type="text" class="form-control <?php if(isset($erros) && !empty($erros['nome'])) echo 'is-invalid' ?>" value="<?= $usuario['nome'] ?>" />
              <?php if(isset($erros) && !empty($erros['nome'])) : ?>
                <div class="invalid-feedback"><?= $erros['nome'] ?></div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="emailInput">E-mail</label>
              <input id="emailInput" name="email" type="email" class="form-control <?php if(isset($erros) && !empty($erros['email'])) echo 'is-invalid' ?>" value="<?= $usuario['email'] ?>" />
              <?php if(isset($erros) && !empty($erros['email'])) : ?>
                <div class="invalid-feedback"><?= $erros['email'] ?></div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="senhaInput">Senha <br> <small class="text-muted">Mínimo 6 caracteres</small></label>
              <input id="senhaInput" name="senha" type="password" class="form-control <?php if(isset($erros) && !empty($erros['senha'])) echo 'is-invalid' ?>"  />
              <?php if(isset($erros) && !empty($erros['senha'])) : ?>
                <div class="invalid-feedback"><?= $erros['senha'] ?></div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="confirmarSenhaInput">Confirmar Senha</label>
              <input id="confirmarSenhaInput" name="confirmarSenha" type="password" class="form-control <?php if(isset($erros) && !empty($erros['confirmarSenha'])) echo 'is-invalid' ?>" />
              <?php if(isset($erros) && !empty($erros['confirmarSenha'])) : ?>
                <div class="invalid-feedback"><?= $erros['confirmarSenha'] ?></div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <button class="btn btn-warning col-12">Editar</button>
            </div>
          </form>
        </div>
  </div>
<?php
  include './includes/footer.php';
?>