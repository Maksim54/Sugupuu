<?php
$xml=simplexml_load_file("sugupuu.xml");
// väljastab massivist getChildrens
function getPeoples($xml){
    $array=getChildrens($xml);
    return $array;
}
// väljastab  laste andmed
function getChildrens($people){
    $result=array($people);
    $childs=$people -> lapsed -> inimene;

    if(empty($childs))
        return $result;

    foreach ($childs as $child){
        $array=getChildrens($child);
        $result=array_merge($result, $array);

    }
    return $result;
}
function getParent($peoples, $people){
if ($people == null) return null;
    foreach ($peoples as $parent){

        foreach ($parent->lapsed->inimene as $child){
            if($child->nimi == $people->nimi){
                return $parent;
            }
        }

        return null;
    }
}
function hasChilds($peoples){
    return (empty())
}

$peoples=getPeoples($xml);

?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Sugupuu ülesanded</title>
</head>
<body>
<h1>Elizabeth 2 Sugupuu ülesanded</h1>
<h2>*Trüki välja kõikide inimeste sünniaastad / Вывести все года рождения людей /</h2>
<?php
foreach($peoples as $people){
    echo $people->attributes()->synd.', ';
}

?>

<hr></hr>
<h2>Väljastatakse nimed,kel on vähemalt kaks last.</h2>

<?php

    foreach ($peoples as $people){
        $lapsed = $people -> lapsed -> inimene ;
        if (empty($lapsed)) continue;
        if(count($lapsed)>1){
            echo $people -> nimi. ' - '.count($lapsed). 'last<br>';
        }
    }

?>

<h2>3, 4, 5, .:.</h2>
<table border="1">
    <tr>
        <th>Vanema vanem</th>
        <th>Vanem</th>
        <th>Laps</th>
        <th>Synniaasta</th>
        <th>Vanus</th>
    </tr>

    <?php
    foreach ($peoples as $people){
        $parent=getParent($peoples, $people);
        if (empty($parent)) continue;

$parentOfparent=getParent($peoples, $parent);

    echo '<tr>';

    if (empty($parentOfparent)){

        echo '<td bgcolor>';

    }else{

    echo '<td></td>';

    echo '<td>'.$parent -> nimi.'</td>';

    echo '<td>'.$people -> nimi.'</td>';

    echo '<td>'.$people -> attributes() -> synd.'</td>';

    echo '</tr>';
    }
    }
    ?>

</table>

</body>
</html>