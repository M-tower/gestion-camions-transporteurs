
<div class="row" id="couleur_entete">
    <!-- Profile Info and Notifications -->
    <div class="col-md-6 col-sm-8 clearfix">
        <ul class="user-info pull-left pull-right-xs pull-none-xsm">
            <!-- Raw Notifications -->
            <div class="btn-group">
                <a href="/?page=clients">
                    <button type="button" class="btn btn-blue btn-icon icon-lef btn-lg">
                        CLIENTS
                        <i class="entypo-reply-all"></i>
                    </button>
                </a>
            </div>
    </div>
    <?php // include('neon/info-bar.php') ?>	
</div>
<style>
  /** contenu de page */
 .page-container .main-content{
  background: #e4e4e4;
 }
  /** titre */
 .form-titre{
  color: #6e7071;; 
  text-align: center;
  text-transform: uppercase;
 }
 /** input */
 .input-lg{
  border: none;
  border-radius: 0px !important;
 }
 .input-lg:focus, .input-lg:active{
  border-left: 2px solid #303641;
 }
 #formClient .form-group{
  border-bottom: 1px solid #efefef;
 }
 .panel-primary{
  box-shadow: 1px 1px 34px #b3ccdc;
 }
 .container{
  margin-top: 15px;
 }
 .panel-title .big-icon{
    position: absolute;
    font-size: 62px;
    margin-left: -58px;
    color: #303641;
    margin-top: -38px;
 }
</style>
<?php
$id = (isset($_GET['id']))? $_GET['id'] : -1;
$soc = '';
if ($id != -1) {
  $soc = getClientById($id);
}
?>
<div class="container" style="margin-top:50px;">
 <div class="col-md-2 col-lg-2"></div>
    <div class="col-md-8 col-lg-8">
        <div class="panel panel-primary" data-collapsed="0">
          <?php
          if(!is_object($soc) && $id != -1){
            echo '<h1>AUCUN CLIENT POUR CET IDENTIFIANT</h1>'
            . '<p>Soit l\'élément que vous recherchez n\'existe pas, soit il a été supprimé</p>';
            die();
          }
        ?>
            <div class="panel-heading" style="background-color:#303641;">
                <div class="panel-title">
                  <h3 style="color: white;"><i class="entypo-pencil big-icon"></i> Ajouter/Editer un client</h3>
                </div>
                <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open" style="color:white;"></i></a>
                        <a href="#" data-rel="reload"><i class="entypo-arrows-ccw" style="color:white;"></i></a>
                        <a href="/?page=clients" ><i class="entypo-cancel" style="color:white;"></i></a>
                </div>
            </div>
            <div class="panel-body" style="margin-top: 16px; margin-bottom: 16px;">   
                <form class="form-horizontal" id="formClient" method="POST" enctype="multipart/form-data">
                <div id="wait"></div>
                <div id="message"></div>
                <!--<div class="col-sm-10 col-sm-offset-1">-->
                    <div id="charge"></div>
                    <div class="form-group">
                        <div class="col-md-8 col-xs-12">
                            <input type="hidden" name="" id="id_client" class="form-control input-lg" value="<?php echo $id ?>"/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-md-4 col-xs-12 control-label" style="text-align:left;">Raison sociale <span style="color: red;">*</span></label>
                            <div class="col-md-8 col-xs-12">
                             <input type="text" name="raison_soc_client" id="raison_soc_client" 
                                    class="form-control input-lg" value="<?php echo $soc != '' ? stripslashes($soc->RAISON_SOC_CLIENT()) : ''; ?>"
                                    placeholder="Nom de l'entité..."/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-md-4 col-xs-12 control-label" style="text-align:left;">Adresse </label>
                            <div class="col-md-8 col-xs-12">
                              <input type="text" name="adresse_client" id="adresse_client" placeholder="Ex : Lomé" class="form-control input-lg" value="<?php echo $soc != '' ? stripslashes($soc->ADRESSE_CLIENT()) : ''; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-md-4 col-xs-12 control-label" style="text-align:left;">Pays </label>
                            <div class="col-md-8 col-xs-12">
                              <select name="pays_client" id="pays_client" class="form-control input-lg">
                                <option value="TOGO" 
                                  <?php echo ($soc != '' && $soc->PAYS_CLIENT() == 'TOGO') ? 'selected' : ''; ?>>TOGO</option>
                                <option value="BURKINA - FASO" 
                                  <?php echo ($soc == '' || $soc->PAYS_CLIENT() == 'BURKINA - FASO') ? 'selected' : ''; ?>>BURKINA - FASO</option>
                                <option value="BENIN" 
                                  <?php echo ($soc != '' && $soc->PAYS_CLIENT() == 'BENIN') ? 'selected' : ''; ?>>BENIN</option>
                                <option value="GHANA" 
                                  <?php echo ($soc != '' && $soc->PAYS_CLIENT() == 'GHANA') ? 'selected' : ''; ?>>GHANA</option>
                              </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-md-4 col-xs-12 control-label" style="text-align:left;">Contacts</label>
                            <div class="col-md-8 col-xs-12">
                              <input type="text" name="contacts_client" id="contacts_client" placeholder="Téléphones..." class="form-control input-lg" value="<?php echo $soc != '' ? stripslashes($soc->CONTACTS_CLIENT()) : ''; ?>"/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6" style="margin-top:16px;">
                        <button type="button" class="btn btn-green btn-icon btn-lg" onclick="edit()">
                            <?php echo ($id != -1) ? 'MODIFIER' : 'AJOUTER'; ?>
                            <i class="entypo-check"></i>
                        </button>
                    </div>
                
                </form>
            </div>
        </div>
    </div>
 <div class="col-md-2">
   <?php if($id == -1){ ?>
    <h4>10 derniers clients Inscrits :</h4>
    <div class="conteneur-client">
    <?php
      $transp = getAllClientsLimite(10);
      foreach($transp as $t){
        echo $t['RAISON_SOC_CLIENT'] . '<br>';
      }
    ?>
    </div>
    <?php } ?>
 </div>
<script src="modules/form-prosses/scripts.js"></script>
<script src="modules/clients/scripts.js"></script>

<script>
//    var limites = '<?php //echo getLimitChampsClient(); ?>';
//    console.log(limites);
    


</script>
