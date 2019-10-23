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
    $deletou = deleteProduto($_POST['id']);

    if ($deletou) {
      header('Location: indexProdutos.php');
    }
  }
?>
<main>
  <div class="container my-4">
    <div class="col-md-8 mx-auto">
      <div class="card w-100">
        <img src="<?= $produto['foto'] ?>" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title"><?= $produto['nome'] ?></h5>
          <p class="card-text"><?= $produto['descricao'] ?></p>
          <form action="" method="POST" class="d-flex">
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
            <a href="indexProdutos.php" class="btn btn-secondary w-25">Voltar</a>
            <button type="submit" class="btn btn-danger w-75 ml-4">Excluir</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
<?php include './includes/footer_adm.php'; ?>