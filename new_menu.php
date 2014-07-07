<html>
 <head>
  <title>Novo Cardápio</title>
 </head>
 <body>


<form  method="POST">
    Tipo do cardapio: 
    <select name="tipo_cardapio">
        <option value="a_la_carte">A la Carte</option>
        <option value="executivo">Executivo</option>
        <option value="executivo_especial">Executivo Especial</option>
        <option value="sugestao_chefe">Sugestão do Chefe</option>
    </select>
    Data de entrada (exceto A La Carte): <input type="date" name="data_entrada">
    Data de saída (exceto A La Carte): <input type="date" name="data_saida">
    Preço (exceto A La Carte): <input type="number" name="preco" min="0" step="0.01">
    
    Adicionar Item
    Nome do prato: <input type="text" name="prato">
    Categoria:
    <select name="tipo_prato">
        <option value="entradas">Entradas</option>
        <option value="risotos">Risotos</option>
        <option value="massas">Massas</option>
        <option value="etc">Etc</option>
    </select>                      
    Descrição: <input type="text" name="descricao">
    
</form>


 </body>
</html>