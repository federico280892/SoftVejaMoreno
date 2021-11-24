<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT * FROM horarios_semanales WHERE id_medico = '".$_POST['idMedico']."' ORDER BY turno ASC");
    if(mysqli_num_rows($peticion) == 0){
        echo '<tr>
        <td class="text-center align-middle" rowspan=2><small>1° turno</small></td>
        <td><input id="apSemanaLun1" type="time" class="form-control text-center"></td>
        <td><input id="apSemanaMar1" type="time" class="form-control text-center"></td>
        <td><input id="apSemanaMie1" type="time" class="form-control text-center"></td>
        <td><input id="apSemanaJue1" type="time" class="form-control text-center"></td>
        <td><input id="apSemanaVie1" type="time" class="form-control text-center"></td>
        <td><input id="apSemanaSab1" type="time" class="form-control text-center"></td>
        <td><input id="apSemanaDom1" type="time" class="form-control text-center"></td>
    </tr>
    <tr>
        <td><input id="ciSemanaLun1" type="time" class="form-control text-center"</td>
        <td><input id="ciSemanaMar1" type="time" class="form-control text-center"</td>
        <td><input id="ciSemanaMie1" type="time" class="form-control text-center"</td>
        <td><input id="ciSemanaJue1" type="time" class="form-control text-center"</td>
        <td><input id="ciSemanaVie1" type="time" class="form-control text-center"</td>
        <td><input id="ciSemanaSab1" type="time" class="form-control text-center"</td>
        <td><input id="ciSemanaDom1" type="time" class="form-control text-center"</td>
    </tr>
    <tr>
        <td class="text-center align-middle" rowspan=2><small>2° turno</small></td>
        <td><input id="apSemanaLun2" type="time" class="form-control text-center"></td>
        <td><input id="apSemanaMar2" type="time" class="form-control text-center"></td>
        <td><input id="apSemanaMie2" type="time" class="form-control text-center"></td>
        <td><input id="apSemanaJue2" type="time" class="form-control text-center"></td>
        <td><input id="apSemanaVie2" type="time" class="form-control text-center"></td>
        <td><input id="apSemanaSab2" type="time" class="form-control text-center"></td>
        <td><input id="apSemanaDom2" type="time" class="form-control text-center"></td>
    </tr>
    <tr>
        <td><input id="ciSemanaLun2" type="time" class="form-control text-center"</td>
        <td><input id="ciSemanaMar2" type="time" class="form-control text-center"</td>
        <td><input id="ciSemanaMie2" type="time" class="form-control text-center"</td>
        <td><input id="ciSemanaJue2" type="time" class="form-control text-center"</td>
        <td><input id="ciSemanaVie2" type="time" class="form-control text-center"</td>
        <td><input id="ciSemanaSab2" type="time" class="form-control text-center"</td>
        <td><input id="ciSemanaDom2" type="time" class="form-control text-center"</td>
    </tr>';
    }else{
        while($h = mysqli_fetch_assoc($peticion)){
            if($h['apDom'] != "-"){
                $readOnlyAp = "";
                $valueAp = 'value="'.date("H:i", strtotime($h['apDom'])).'"';
            }else{
                $readOnlyAp = "readonly";
                $valueAp = "";
            }

            if($h['ciDom'] != "-"){
                $readOnlyCi = "";
                $valueCi = 'value="'.date("H:i", strtotime($h['apDom'])).'"';
            }else{
                $readOnlyCi = "readonly";
                $valueCi = "";
            }

            echo '<tr>
                <td class="text-center align-middle" rowspan=2>';
                if($h['turno'] == "1"){
                    echo "<small>1° turno</small>";
                }else{
                    echo "<small>2° turno</small>";
                }
                echo'</td>
                <td><input id="apSemanaLun'.$h['turno'].'" type="time" value="'.date("H:i", strtotime($h['apLun'])).'" class="form-control text-center"></td>
                <td><input id="apSemanaMar'.$h['turno'].'" type="time" value="'.date("H:i", strtotime($h['apMar'])).'" class="form-control text-center"></td>
                <td><input id="apSemanaMie'.$h['turno'].'" type="time" value="'.date("H:i", strtotime($h['apMie'])).'" class="form-control text-center"></td>
                <td><input id="apSemanaJue'.$h['turno'].'" type="time" value="'.date("H:i", strtotime($h['apJue'])).'" class="form-control text-center"></td>
                <td><input id="apSemanaVie'.$h['turno'].'" type="time" value="'.date("H:i", strtotime($h['apVie'])).'" class="form-control text-center"></td>
                <td><input id="apSemanaSab'.$h['turno'].'" type="time" value="'.date("H:i", strtotime($h['apSab'])).'" class="form-control text-center"></td>
                <td><input id="apSemanaDom'.$h['turno'].'" type="time" '.$valueAp.' class="form-control text-center" '.$readOnlyAp.'></td>
            </tr>
            <tr>
                <td><input id="ciSemanaLun'.$h['turno'].'" type="time" value="'.date("H:i", strtotime($h['ciLun'])).'" class="form-control text-center"></td>
                <td><input id="ciSemanaMar'.$h['turno'].'" type="time" value="'.date("H:i", strtotime($h['ciMar'])).'" class="form-control text-center"></td>
                <td><input id="ciSemanaMie'.$h['turno'].'" type="time" value="'.date("H:i", strtotime($h['ciMie'])).'" class="form-control text-center"></td>
                <td><input id="ciSemanaJue'.$h['turno'].'" type="time" value="'.date("H:i", strtotime($h['ciJue'])).'" class="form-control text-center"></td>
                <td><input id="ciSemanaVie'.$h['turno'].'" type="time" value="'.date("H:i", strtotime($h['ciVie'])).'" class="form-control text-center"></td>
                <td><input id="ciSemanaSab'.$h['turno'].'" type="time" value="'.date("H:i", strtotime($h['ciSab'])).'" class="form-control text-center"></td>
                <td><input id="ciSemanaDom'.$h['turno'].'" type="time" '.$valueCi.' class="form-control text-center" '.$readOnlyCi.'></td>
            </tr>';
        }
    }

    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>