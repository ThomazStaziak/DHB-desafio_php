<?php 
  require './functions/produtoFunctions.php';
  include './includes/header_adm.php';

  $produtos = getProdutos();
?>
<main>
  <div class="container my-4">
    <h1>Lista de produtos</h1>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">id</th>
          <th scope="col">Nome</th>
          <th scope="col">Descrição</th>
          <th scope="col">Preço</th>
          <th scope="col">Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($produtos as $produto) : ?>    
          <tr>
            <th scope="row"><?= $produto['id'] ?></th>
            <td><?= $produto['nome'] ?></td>
            <td><?= $produto['descricao'] ?></td>
            <td>R$ <?= $produto['preco'] ?></td>
            <td>
              <a href="editProduto.php?id=<?= $produto['id'] ?>" class="btn btn-info w-25">Editar</a>
              <a href="showProduto.php?id=<?= $produto['id'] ?>" class="btn btn-danger w-25">Excluir</a>
            </td>
          </tr>
        <?php endforeach; ?>    
      </tbody>
    </table>
  </div>
</main>
<?php include './includes/footer.php' ?>