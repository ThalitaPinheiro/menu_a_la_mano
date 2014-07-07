<html>
 <head>
  <title>Novo Cardápio</title>
 </head>
 <body>


<form  method="POST">
    <p>Tipo do cardapio: 
    <select name="tipo_cardapio">
        <option value="a_la_carte">A la Carte</option>
        <option value="executivo">Executivo</option>
        <option value="executivo_especial">Executivo Especial</option>
        <option value="sugestao_chefe">Sugestão do Chefe</option>
    </select></p>
    <p>Data de entrada (exceto A La Carte): <input type="date" name="data_entrada"></p> 
    <p>Data de saída (exceto A La Carte): <input type="date" name="data_saida"></p> 
    <p>Preço (exceto A La Carte): <input type="number" name="preco" min="0" step="0.01"></p> 
    
    <p>Adicionar Item</p> 
    <p>Nome do prato: <input type="text" name="prato"></p> 
    <p>Categoria:
    <select name="tipo_prato">
        <option value="entradas">Entradas</option>
        <option value="risotos">Risotos</option>
        <option value="massas">Massas</option>
        <option value="etc">Etc</option>
    </select></p>                       
    <p>Descrição: <input type="text" name="descricao"></p> 
    
</form>


 </body>
</html>