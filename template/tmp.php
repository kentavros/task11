<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Task 11 AR</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
    <!--[endif]-->
</head>
<body>
<nav class="navbar navbar-inverse " style="margin-bottom: 50px">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand " href="#">Task 11 -- ActiveRecord</a>
        </div>
    </div>
</nav>
<?=$msg? '<p class="alert-danger">'.$msg : '</p>'?>


<table class="table container" style="width: 800px">
    <tr>
        <th class="text-center alert-info " >MyTest extends ActiveRecord </th>
    </tr>
</table>
<table class="table container text-center table-hover table-bordered" style="width: 800px">
    <tr>
        <td style="width: 400px">
            Create: $myTest = new MyTest();
        </td>
        <td>Column name: <?=$colName? $colName : ''?></td>
    </tr>
    <tr>
        <td>
            Create row:<br />
            $myTest->key='user6';<br />
            $myTest->data='test6';<br />
            $myTest->save();
            and get
        </td>
        <td>
            $myTest->key :<?=$getKey? $getKey : ''?><br>
            $myTest->data :<?=$getData? $getData : ''?>
        </td>

    </tr>
    <tr>
        <td>Find by key = user6</td>
        <td><?php if (isset($find)){foreach($find as $v){echo $v.' ';}} ?></td>
    </tr>
    <tr>
        <td>
            Update data by key = user6<br>
            $myTest->key='user6';
            $myTest->data='test12';
            $myTest->save();
        </td>
        <td><?php if (is_array($find2)){foreach($find2 as $v){echo $v.' ';}} ?></td>
    </tr>
    <tr>
        <td>
            Show data in table:
        </td>
        <td>
            <?php
            if (is_array($showData))
            {
                foreach ($showData as $key=>$val)
                {
                    echo $showData[$key]['key']. ' => ';
                    echo $showData[$key]['data']. '<br />';
                }
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>
            Delete: <br />
            $myTest->deleteRow('user6');
        </td>
        <td><?php if (is_array($find3)){foreach($find3 as $v){echo $v.' ';}} else{ echo NO_KEY;} ?></td>
    </tr>
</table>




<footer class="modal-footer navbar-inverse navbar-fixed-bottom" style="padding: 3px;">
    <div class="container">
        <a class="navbar-brand" style="float: right" href="#">Task 11</a>
    </div>
</footer>
<script src="js/bootstrap.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<!-- ðÏÓÌÅÄÎÑÑ ËÏÍÐÉÌÑÃÉÑ É ÓÖÁÔÙÊ JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
