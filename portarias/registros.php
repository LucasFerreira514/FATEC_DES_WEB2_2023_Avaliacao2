<?php
    require_once('header.php');
    require_once('dados_banco.php');

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $placa_id = $_POST['placa_id'];

        try {
            $dsn = "mysql:host=$servername;dbname=$dbname";
            $conn = new PDO($dsn, $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM registro WHERE placa_id = :placa_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':placa_id', $placa_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch(PDOException $e){
            echo $sql . "<br>" . $e->getMessage();
        }

        while ($row = $stmt->fetch()) {
        	echo "<tr>";
    		echo "<td>" . $row['aluno'] . "</td>";
    		echo "<td>" . $row['placa'] . "</td>";
    		echo "</tr>";
}
echo "</table>";
        }

        $conn = NULL;
    } else {
        header("location: registros.php");
    }
?>
 
<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <title>Portaria Fatec</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h2>
            <?php echo $_SESSION["username"]; ?>
            <br>
        </h2>
    </div>
    <p>

    <form action="registros_encontrados.php" method="POST">
        <div class="form-group">
            <label>Selecione o aluno</label>
            <br>
            <select name="placa_id">
                <?php
                    while ($row = $stmt->fetch()) {
                        print "<option value=". $row['id'].">". $row['placa']."</option>";
                    }
                ?>
            </select>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Acessar">
        </div>
    </form>

    <a href="principal.php" class="btn btn-primary">Voltar</a>
    <br><br>

    </p>
</body>
</html>