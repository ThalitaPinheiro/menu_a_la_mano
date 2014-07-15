<html>
 <head>
     <script>
        function menu_type(type) {
            if(type!="a_la_carte") {
                document.getElementById("preco").disabled = false;
                document.getElementById("data_entrada").disabled = false;
                document.getElementById("data_saida").disabled = false;
            } else {
                document.getElementById("preco").disabled = true;
                document.getElementById("data_entrada").disabled = true;
                document.getElementById("data_saida").disabled = true;
            }
        }
     </script>
  <title>Novo Cardápio</title>
 </head>
 <body>


<form  method="POST">

    <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="2"><div align="center"><strong><h2>CARD&Aacute;PIO</h2><br /></strong></div></td>
        </tr>
        <tr>
            <td><strong>Tipo do card&aacute;pio:  </strong></td>
            
            <td>
                <select name="tipo_cardapio" onchange="menu_type(document.forms[0].tipo_cardapio.value)">
                    <option value="a_la_carte">A la Carte</option>
                    <option value="executivo">Executivo</option>
                    <option value="executivo_especial">Executivo Especial</option>
                    <option value="sugestao_chefe">Sugestão do Chefe</option>
                </select>
            </td>
        </tr>

        <tr>
            <td><strong>Data de entrada (exceto A La Carte): </strong></td>
            <td><input type="date" name="data_entrada" id="data_entrada" disabled></td>
        </tr>

        <tr>
            <td><strong> Data de saída (exceto A La Carte): </strong></td>
            <td><input type="date" name="data_saida" id="data_saida" disabled></td>
        </tr>
            
        <tr>
            <td><strong>Preço (exceto A La Carte): </strong></td>
            <td><strong> <input type="number" name="preco"  id="preco" min="0" step="0.01" disabled></td>
        </tr>

        <tr>
            <td><strong>Adicionar Item</strong></td>
        </tr>

        <tr>
            <td><strong>Nome do prato:</strong></td>
            <td><input type="text" name="prato"> </td>
        </tr>

        <tr>
            <td><strong>Categoria:</strong></td>
            <td>
                <select name="tipo_prato">
                    <option value="entradas">Entradas</option>
                    <option value="risotos">Risotos</option>
                    <option value="massas">Massas</option>
                    <option value="etc">Etc</option>
                </select>
            </td>                       
        </tr> 

        <tr>
            <td><strong>Descrição:</strong></td>
            <td><textarea cols="50" name="descricao"   rows="5" ></textarea></td>  
        </tr> 

        <tr> 
            <td colspan="2"><div align="center"><input type="submit" value="Atualizar" name="enviei" /></div></td>
        </tr>
</table>
    
</form>


 </body>
</html>