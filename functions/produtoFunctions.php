<?php
  define('ARQUIVO', './database/produtos.json');

  function getProdutos() {
    $json_produtos = file_get_contents(ARQUIVO);

    return json_decode($json_produtos, true);
  }

  function storeProduto($produto) {
    $produtos = getProdutos();
    
    if (empty($produtos)) {
      $produto['id'] = 1;
    } else {
      $produto['id'] = ++end($produtos)['id'];    
    }
    
    array_push($produtos, $produto);
    $json_produtos = json_encode($produtos);
    return file_put_contents(ARQUIVO, $json_produtos);
  }

  function searchProduto($id) {
    $produtos = getProdutos();

    foreach($produtos as $produto)
      if ($produto['id'] == $id)
        return $produto;
    
    return false;
  }

  function deleteProduto($id) {
    $produtos = getProdutos();

    foreach($produtos as $index => $produto)
      if ($produto['id'] == $id) {
        array_splice($produtos, $index, 1);

        $json_produtos = json_encode($produtos);
        return file_put_contents(ARQUIVO, $json_produtos);
      }
    
    return false;
  }

  function editProduto($novoProduto) {
    $produtos = getProdutos();

    foreach($produtos as $index => $produto) {
      if ($produto['id'] == $novoProduto['id']) {
        $produtos[$index] = $novoProduto;
    
        $json_produtos = json_encode($produtos);
        return file_put_contents(ARQUIVO, $json_produtos);
      }
    }

    return false;
  }
?>