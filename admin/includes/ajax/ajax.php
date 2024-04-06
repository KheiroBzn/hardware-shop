<?php  if(!isset($_SESSION)){
    session_start();
}

    
if ( (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ) {

    

    include '../../connect.php';
    $bdd =  $connect;
    function getFiltreXmlSousCategorie($bdd,$id_sous_categroie){
        //$bdd =  $connect;
        $req = $bdd->prepare('SELECT  filtre_sous_categorie  FROM `sous_categorie` where id_sous_categorie=:id_sous_categorie ;');
        $req->execute( array( 'id_sous_categorie' => $id_sous_categroie ) );
        $file=$req->fetch(PDO::FETCH_ASSOC)['filtre_sous_categorie'];
        if($file!=NULL){
            if (file_exists( $_SERVER['DOCUMENT_ROOT'] . '/public/filtre/sousCategorie/'.$file .'.xml')) {
                $xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/public/filtre/sousCategorie/'.$file .'.xml');
                return $xml;
            } else 
                return NULL;
        }
        else
            return NULL;

    }

    /*recupere dynmiquement les filtre de sous categorie selon la sous categorie selectionner*/ 
    if( isset($_POST['idScategorie']) ){

        $codeSelectFilter='';
        $i=1;
        foreach( getFiltreXmlSousCategorie( $bdd ,$_POST['idScategorie'])->children() as $element ) {

            $codeSelectFilter.='<div class="form-row mt-4 mb-4"  >
                <input style="display: inline-block; width: 50%;"  class="form-control" type="text" name="' .$element->Filtre .'" value="'.$element->Filtre.'" readonly>
                <select style="display: inline-block; width: 50%;" class="form-control"  name="filtre'.$i.'" id="'.$element->Filtre.'">';

                foreach( $element->AllValues->children() as $elementChild ) {
                    $codeSelectFilter.='<option  value="'.$element->Filtre['for'].'+'.$elementChild['value'] .'">'.$elementChild.'</option> ';
                }
            
                $codeSelectFilter.='</select> </div>';

        
        
            $i++;
        }
       
        header('Content-type: application/json');
        echo json_encode(array("codeSelectFilter"=>$codeSelectFilter));

    
    }

    /* code pour creer la fiche technique de article*/
    if( isset($_POST['champ']) and  isset($_POST['valeur']) and  isset($_POST['nomFichier'])  ){
        
    
        $nom=$_POST['nomFichier'] . ".xml";
        $monfichier = fopen($nom, 'a+');

        $code='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<data-set xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">';
        

        $size=count($_POST['champ']);
        
        for ($i=0; $i < $size ; $i++) { 
            $code .= '
    <record>
        <Attribut>' .$_POST['champ'][$i] . "</Attribut>
        <Valeur>" . $_POST['valeur'][$i] . "</Valeur>
    </record>" ;
        }

        $code.='
</data-set>';

        // 2 : on fera ici nos opérations sur le fichier...
        fputs($monfichier, $code); 
        // 3 : quand on a fini de l'utiliser, on ferme le fichier
        fclose($monfichier);

        //$connect->exec("UPDATE  article SET fiche_technique_article='".  $_POST['nomFichier']. "' WHERE id_article=". $id .";");
       

        header('Content-type: application/json');
        echo json_encode(array("array"=>$code ));
    }

    /* code pour creer le filtre de sous categorie*/ 
    if( isset($_POST['arraychamp']) ){

      
        $result_decode=json_decode( $_POST["arraychamp"],true  );
        

        $code='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<data-set xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">';
    foreach ($result_decode as $filterName=>$filterTab) {

        $code .= '
        <record>
            <Filtre for="' .  str_replace('-','_' ,str_replace(' ','_',strtolower($filterName)))  .'" >'.$filterName.' :</Filtre>
            <AllValues>';
        

        foreach ($filterTab as  $value) {
            $code.='
                <Valeur value="'.$value.'">'.$value.'</Valeur>' ;
        }

        $code .="
            </AllValues>
        </record>" ;

    }
           
        $code.='
</data-set>';


        $nom=$_POST['nomFiltre'] . "-filtre" . ".xml";
        $monfichier = fopen($nom, 'a+');
        // 2 : on fera ici nos opérations sur le fichier...
        fputs($monfichier, $code); 
        // 3 : quand on a fini de l'utiliser, on ferme le fichier
        fclose($monfichier);
        

        header('Content-type: application/json');
        echo json_encode(array("null"=>null));
    }
}