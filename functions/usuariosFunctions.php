<?php 
  define('ARQUIVO', './database/usuarios.json');

  function getUsuarios() {
    $json_usuarios = file_get_contents(ARQUIVO);

    return json_decode($json_usuarios, true);
  }

  function storeUsuario($usuario) {
    $usuarios = getUsuarios();
    
    if (empty($usuarios)) {
      $usuarios = [];
      $usuario['id'] = 1;
    } else {
      $usuario['id'] = ++end($usuarios)['id'];    
    }
    
    array_push($usuarios, $usuario);
    $json_usuarios = json_encode($usuarios);
    return file_put_contents(ARQUIVO, $json_usuarios);
  }

  function searchUsuario($id) {
    $usuarios = getUsuarios();

    foreach($usuarios as $usuario)
      if ($usuario['id'] == $id)
        return $usuario;
    
    return false;
  }

  function deleteUsuario($id) {
    $usuarios = getUsuarios();

    foreach($usuarios as $index => $usuario)
      if ($usuario['id'] == $id) {
        array_splice($usuarios, $index, 1);

        $json_usuarios = json_encode($usuarios);
        return file_put_contents(ARQUIVO, $json_usuarios);
      }
    
    return false;
  }

  function editUsuario($novoUsuario) {
    $usuarios = getUsuarios();

    foreach($usuarios as $index => $usuario) {
      if ($usuario['id'] == $novoUsuario['id']) {
        $usuarios[$index] = $novoUsuario;
    
        $json_usuarios = json_encode($usuarios);
        return file_put_contents(ARQUIVO, $json_usuarios);
      }
    }

    return false;
  }

  function login($email, $senha) {
    $usuarios = getUsuarios();

    foreach ($usuarios as $usuario) {
      if (
        $usuario['email'] == $email && 
        password_verify($senha, $usuario['senha'])
      ) {
        return $usuario;
      }
    }

    return false;
  }
?>