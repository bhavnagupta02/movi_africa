<?php
require_once 'db.php';
session_start();

if($_POST['f_name']!=""){
    $filter['f_name'] = $_POST['f_name'];
}else{
    $filter['f_name'] = "";
}

if($_POST['f_cnty']!=""){
    $f_cnty = $_POST['f_cnty'];
    $filter['f_cnty'] = implode(",",$f_cnty);
}else{
    $filter['f_cnty'] = "";
}

if($_POST['f_lng']!=""){
    $f_lng = $_POST['f_lng'];
    $filter['f_lng'] = implode(",",$f_lng);
}else{
    $filter['f_lng'] = "";
}

if($_POST['f_stg']!=""){
    $f_stg = $_POST['f_stg'];
    $filter['f_stg'] = implode(",",$f_stg);
}else{
    $filter['f_stg'] = "";
}

if($_POST['f_genre']!=""){
    $f_genre = $_POST['f_genre'];
    $filter['f_genre'] = implode(",",$f_genre);
}else{
    $filter['f_genre'] = "";
}

$WHERE = "WHERE `del` = 0 AND";


foreach($filter as $k => $v){

    if($v != ''){
        if($k=="f_lng"){
            $WHERE.= " `f_lng` LIKE '%".$v."%' AND";
        }
        if($k=="f_genre"){
            $WHERE.= " `f_genre` LIKE '%".$v."%' AND";
        }
        if($k=="f_name" OR $k=="f_cnty" OR $k=="f_stg"){
            $r = str_replace(",","|",$v);;
            $WHERE.= " $k REGEXP \"($r)\" AND";
        }
      
    }
 
}
$WHERE   =  rtrim($WHERE,"AND");

$sql .= 'SELECT * FROM `films` '.$WHERE. ' ';  

$sql .= 'ORDER BY id DESC';  

$run_query = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($run_query)) {
    $userRow[] = $row;
} 




$html = ''; 

if (count($userRow) >0) {
  
    foreach ($userRow as $value) { 

        if($value['film_cover'] == ''){ $film_cover = '/film_logo/defualt.jpg'; } else{ $film_cover = '/film_logo/'.$value['film_cover']; }
            
        $edit_link = "";
        if($_SESSION['IdSer'] == $value['created_by']){ 
            $edit_link = '<a style="float: right;font-size: 13px;font-weight: 600;" href="/manage-film?id='.$value["url"].' "><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>'; 
        }

        $html.= '<div class="col-sm-12 BxDvr mypagi" style="padding:0;">
                    <div class="BxDvrIn">
                        <a class="ABack" href="view-film.php?id='.$value["url"].'">
                            <div class="relative" style="height:180px;position: relative;background-size:cover;background-position:center;background-image:url('.$film_cover.');">
                    
                            </div>
                        </a>
                        <div class="DvrBx">
                            <div class="DvrBxT">
                                <a href="'.$value["url"].'">'.$value["f_name"].'</a>'.$edit_link.'</div>
                            <div class="DvrBxR">
                                <div class="DvrBxRB">
                                    <div class="V-bottom-C">
                                        <b>Country : </b>
                                            <a href="javascript:void(0)">'.$value["f_cnty"].'</a>                                               
                                    </div>
                                    <div class="V-bottom-C Language">
                                        <b>Language : </b> &nbsp;';

                                   /* foreach(explode(',',$value['f_lng']) as $ay){
                                        $html.= '<p>'.$ay.'</p>';   
                                    } 
                                    */
                                    	$f_lng = str_replace(',', ", ", $value['f_lng']);
                                        //echo $f_lng;  
                                    $html.= ''.$f_lng.'';    
                            $html.='</div>

                                    <div  class="V-bottom-C">
                                        <b>Length : &nbsp;</b>'
                                            . $value['f_run']. 'min 
                                    </div>



                                </div>
                           </div>   
                           <div class="DvrBxL">
                                <div class="DvrBxC">
                                   ';

                                    foreach(explode(',',$value['f_genre']) as $ay){
                                        $html.=  '<a href="javascript:void(0);">'.$ay.'</a>';   
                                    }



                                                                       
                           $html.=  '</div>
                                <div class="DvrBxB"><p>'.$value["f_plot"].'</p> 
                                </div>
                           </div> 
                        </div>
                    </div>
                </div>';

        

        
    } 

    $all_data = array('html'=>$html,'status'=>1);


    
    echo json_encode($all_data);
}else{
    $html = '<div >No Film Found</div>';
    $all_data = array('html'=>$html,'status'=>0);
    echo json_encode($all_data); 
} 
  

?>