<?php
require '/config/config.php';

$sql1 = "SELECT p.id, p.name, p.surname, g.type, g.year, g.city, pl.discipline FROM Placements pl
JOIN People p ON pl.person_id=p.id
JOIN Olympic_games g ON pl.game_id=g.id 
WHERE pl.placement = 1";


$sql2 = "SELECT p.id,p.name, p.surname, COUNT(*) as times_won
FROM Placements pl
JOIN People p ON pl.person_id = p.id
WHERE pl.placement = 1
GROUP BY pl.person_id
LIMIT 10";
$top10 = mysqli_query($con, $sql2);

$results = mysqli_query($con, $sql1);


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="node_modules/datatables.net-dt/css/jquery.dataTables.css">   
    <link rel="stylesheet" href="styles/index.css">
    <title>Olympíjskí víťazi</title>
</head>
<body>
    
    <div class="container-md">
        <h1>Zadanie 1</h1>
        <table id="myTable" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed">
            <thead>
                <tr>
                    <th>Meno</th>
                    <th>Priezvisko</th>
                    <th id="typ">Typ</th>
                    <th>Rok</th>
                    <th>Mesto</th>
                    <th>Disciplína</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $item) { ?>
                    <tr id="<?php echo $item['id']; ?>">
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['surname']; ?></td>
                        <td><?php echo $item['type']; ?></td>
                        <td><?php echo $item['year']; ?></td>
                        <td><?php echo $item['city']; ?></td>
                        <td><?php echo $item['discipline']; ?></td>
                        <td><a href="editPerson.php" class="btn btn-info"></a></td>
                        <td><a href="removePerson.php" class="btn btn-info"></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <table id="top10_table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Meno</th>
                        <th>Priezvisko</th>
                        <th>Počet výhier</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($top10 as $item) { ?>
                        <tr id="<?php echo $item['id']; ?>">
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['surname']; ?></td>
                            <td><?php echo $item['times_won']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
            
        <script src="node_modules/jquery/dist/jquery.js"></script> 
        <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
        <script src="node_modules/datatables.net-dt/js/dataTables.dataTables.js"></script>
        <script src="scripts/index.js"></script>
    </body>        
</html>