# credito_cf
Sistema de Calculo de Crédito de Cupom Fiscal NF

Seu método de uso serve para calcular quanto cada CPF gerou de crédito com base em seus cupons inseridos
Foi adicionado alguns métodos de calculo, onde, pode ser visto quantos cupons foram gerados no mês,
e quais cupons foram gerados individualmente por tal CPF.

Método:

O arquivo Pedidos.csv deve ser o primeiro enviado exclusivamente pelo input radio "Cadastro"
pois, nele contem todos os cupons gerados refente ao periodo.

O arquivo ConsultaNFP.csv deve ser enviado pelo input radio "Cadastro" e "Atualização".

O arquivo ConsultaNFP.csv ao ser enviado pelo input radio "Cadastro" busca na base de dados
o Numero do Cupom Fiscal e o CNPJ. Caso encontre atualiza a coluna creditos, caso não encontre
insere em outra tabela os dados não encontrados para controle.

O arquivo ConsultaNFP.csv ao ser enviado pelo input radio "Atualização" insere o numero do CNPJ e
o Nome da empresa para amortecer o uso da base de dados

Para validar a funcionalidade do Sistema, abra a planilha ConsultaNFP.csv no Microsoft Excel ou LibreOffice Calc e realize a soma da coluna créditos.

Com a página montada, clique no botão crédito e aguarde o carregamento, no final da página o valor deverá ser o mesmo da planilha (R$ 1646,25)
