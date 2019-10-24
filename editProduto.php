<?php 
  require './functions/produtoFunctions.php';
  include './includes/header_adm.php';

  if (!$_GET)
    header('Location: indexProdutos.php');

  if ($_GET) {
    $produto = searchProduto($_GET['id']);

    if (!$produto)
      header('Location: indexProdutos.php');
  }

  if ($_POST) {
    $erros = [
      'nome' => '',
      'preco' => '',
      'descricao' => '',
      'foto' => '',
    ];

    if (empty($_FILES['foto']['name'])) {
      $erros['foto'] = 'O campo foto é obrigatório';
    } else if ($_FILES['foto']['error'] === 0) {
      $nome_foto = $_FILES['foto']['name'];
      $nome_temp = $_FILES['foto']['tmp_name'];
      $url_imagem = 'assets/img/uploads/' . $nome_foto;
      move_uploaded_file($nome_temp, './' . $url_imagem);
    }

    if (empty($_POST['nome'])) 
      $erros['nome'] = 'O campo nome é obrigatório';

    if (!is_numeric($_POST['preco']))
      $erros['preco'] = 'O campo preço deve ser um número';

    if (
      empty($erros['nome']) &&
      empty($erros['preco']) &&
      empty($erros['descricao']) &&
      empty($erros['foto'])
    ) {
      $novoProduto = [
        'id' => $_POST['id'],
        'nome' => $_POST['nome'],
        'preco' => $_POST['preco'],
        'descricao' => $_POST['descricao'],
        'foto' => $url_imagem
      ];

      $editou = editProduto($novoProduto);

      if ($editou)
        header('Location: indexProdutos.php');
      }
  }
?>
<main>

<div class="container my-4">
  <h1>Editar Produto</h1>
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-row">
      <div class="col">
        <label for="nomeInput">Nome</label>
        <input id="nomeInput" name="nome" type="text" class="form-control <?php if(isset($erros) && !empty($erros['nome'])) echo 'is-invalid' ?>" value="<?= $produto['nome'] ?>" />
        <?php if(isset($erros) && !empty($erros['nome'])) : ?>
          <div class="invalid-feedback"><?= $erros['nome'] ?></div>
        <?php endif; ?>
      </div>
      <div class="col">
        <label for="precoInput">Preço</label>
        <input id="precoInput" name="preco" type="text" class="form-control <?php if(isset($erros) && !empty($erros['preco'])) echo 'is-invalid' ?>" value="<?= $produto['preco'] ?>" />
        <?php if(isset($erros) && !empty($erros['preco'])) : ?>
          <div class="invalid-feedback"><?= $erros['preco'] ?></div>
        <?php endif; ?>
      </div>
    </div>
    <div class="form-group mt-2">
      <label for="descricaoInput">Descrição</label>
      <textarea
        name="descricao"
        id="descricaoInput"
        cols="30"
        rows="10"
        class="form-control"
      ><?= $produto['descricao'] ?></textarea>
    </div>
    <div class="form-group">
      <img src="<?= $produto['foto'] ?>" class="w-100 rounded" height="400" alt="">
    </div>
    <div class="form-group">
      <div class="custom-file">
        <input type="file" class="custom-file-input <?php if(isset($erros) && !empty($erros['foto'])) echo 'is-invalid' ?>" name="foto" id="fotoInput">
        <label class="custom-file-label" for="fotoInput">Selecione a foto</label>
        <?php if(isset($erros) && !empty($erros['foto'])) : ?>
          <div class="invalid-feedback"><?= $erros['foto'] ?></div>
        <?php endif; ?>
      </div>
    </div>
    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
    <div class="form-group">
      <button class="btn btn-warning col-12">Editar</button>
    </div>
  </form>
</div>

</main>
<?php 
  include './includes/footer_adm.php';
?>