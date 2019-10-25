<?php 
  require './functions/usuariosFunctions.php';  
  include './includes/header_adm.php';

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
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'senha' => password_hash($_POST['senha'], PASSWORD_DEFAULT),
      ];

      storeUsuario($usuario);
    }
  }

  if ($_GET && $_GET['id']) {
    deleteUsuario($_GET['id']);
  }

  $usuarios = getUsuarios();
?>
  <main>
    <div class="container my-4">
      <div class="row">
        <div class="scroll-column col-md-4 border rounded">
          <h3 class="m-0">Usuários</h3>
          <?php foreach($usuarios as $usuario) : ?>
            <div class="border-top p-1">
              <div class="row">
                <div class="col-md-8">
                  <p class="m-0 my-2"><?= $usuario['nome'] ?></p>
                  <p class="m-0 my-2"><?= $usuario['email'] ?></p>
                </div>
                <div class="col-md-4 row">
                  <a href="editUsuarios.php?id=<?= $usuario['id'] ?>" class="btn btn-info col mt-2">Editar</a>
                  <form class="w-100" action="" method="GET">
                    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                    <button class="btn btn-danger col my-2">Excluir</button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="col-md-8">
          <h3>Adicionar usuários</h3>
          <form action="createUsuario.php" method="POST">
            <div class="form-group">
              <label for="nomeInput">Nome</label>
              <input id="nomeInput" name="nome" type="text" class="form-control <?php if(isset($erros) && !empty($erros['nome'])) echo 'is-invalid' ?>" />
              <?php if(isset($erros) && !empty($erros['nome'])) : ?>
                <div class="invalid-feedback"><?= $erros['nome'] ?></div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="emailInput">E-mail</label>
              <input id="emailInput" name="email" type="email" class="form-control <?php if(isset($erros) && !empty($erros['email'])) echo 'is-invalid' ?>" />
              <?php if(isset($erros) && !empty($erros['email'])) : ?>
                <div class="invalid-feedback"><?= $erros['email'] ?></div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="senhaInput">Senha <br> <small class="text-muted">Mínimo 6 caracteres</small></label>
              <input id="senhaInput" name="senha" type="password" class="form-control <?php if(isset($erros) && !empty($erros['senha'])) echo 'is-invalid' ?>" />
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
              <button class="btn btn-primary col-12">Adicionar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
<?php 
  include './includes/footer_adm.php';
?>