
<div class="row" id="couleur_entete">
    <!-- Profile Info and Notifications -->
    <div class="col-md-6 col-sm-8 clearfix">
        <ul class="user-info pull-left pull-right-xs pull-none-xsm">
            <!-- Raw Notifications -->
            <div class="btn-group">
                <a href="/?page=transporteurs">
                    <button type="button" class="btn btn-blue btn-icon icon-lef btn-lg">
                        TRANSPORTEURS
                        <i class="entypo-reply-all"></i>
                    </button>
                </a>
            </div>
    </div>
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
  //echo $id;
  $soc = getTransporteurById($id);
//  $id = $soc->ID_TRANSP();
}
//print_r(getLimitChamps('transporteurs'));
?>
<div class="container" style="margin-top:50px;">
  <div class="col-md-2"></div>
  <div class="col-md-8">
      <div class="panel panel-primary" data-collapsed="0">
        <?php
          if(!is_object($soc) && $id != -1){
            echo '<h1>AUCUN TRANSPORTEUR POUR CET IDENTIFIANT</h1>'
            . '<p>Soit l\'élément que vous recherchez n\'existe pas, soit il a été supprimé</p>';
            die();
          }
        ?>
          <div class="panel-heading" style="background-color:#303641;">
              <div class="panel-title">
                <h3 style="color: white;"><i class="entypo-pencil big-icon"></i> Ajouter/Editer un transporteur</h3>
              </div>
              <div class="panel-options">
                      <a href="#" data-rel="collapse"><i class="entypo-down-open" style="color:white;"></i></a>
                      <a href="#" data-rel="reload"><i class="entypo-arrows-ccw" style="color:white;"></i></a>
                      <a href="/?page=transporteurs" ><i class="entypo-cancel" style="color:white;"></i></a>
              </div>
          </div>
          <div class="panel-body" style="margin-top: 16px; margin-bottom: 16px;">   
              <form class="form-horizontal validate" id="formClient" method="POST" enctype="multipart/form-data">
              <div id="wait"></div>
              <div id="message"><i style="width:100%;">Les champs marqués * sont obligatoires</i></div>
              <!--<div class="col-sm-10 col-sm-offset-1">-->
                  <div id="charge"></div>
                  <div class="form-group">
                      <div class="col-md-8 col-xs-12">
                        <input type="hidden" name="id_transp" id="id_transp" class="form-control input-lg" value="<?php echo $id ?>"/>
                      </div>
                  </div>
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label class="col-md-4 col-xs-12 control-label" style="text-align:left;">Maison du transporteur <span style="color: red;">*</span></label>
                          <div class="col-md-8 col-xs-12">
                           <input type="text" name="maison_transp" id="maison_transp"
                                  class="form-control input-lg" value="<?php echo $soc != '' ? stripslashes($soc->MAISON_TRANSP()) : ''; ?>"
                                   laceholder="Nom de la maison de transport..."/>
                          </div>
                      </div>
                  </div>
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label class="col-md-4 col-xs-12 control-label" style="text-align:left;">Dirigeant <span style="color: red;">*</span></label>
                          <div class="col-md-8 col-xs-12">
                           <input type="text" name="dirigeant_transp" id="dirigeant_transp"
                                  class="form-control input-lg" value="<?php echo $soc != '' ? stripslashes($soc->DIRIGEANT_TRANSP()) : ''; ?>"
                                  placeholder="Nom et prénom du dirigeant..."/>
                          </div>
                      </div>
                  </div>
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label class="col-md-4 col-xs-12 control-label" style="text-align:left;">Adresse </label>
                          <div class="col-md-8 col-xs-12">
                              <input type="text" name="adresse_transp" id="adresse_transp" placeholder="Ex : Lomé" 
                                     class="form-control input-lg" value="<?php echo $soc != '' ? stripslashes($soc->ADRESSE_TRANSP()) : ''; ?>"/>
                          </div>
                      </div>
                  </div>
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label class="col-md-4 col-xs-12 control-label" style="text-align:left;">Email </label>
                          <div class="col-md-8 col-xs-12">
                              <input type="text" name="mail_transp" id="mail_transp" placeholder="Ex : exemple@hotmail.com" 
                                     data-validate="email" 
                                     class="form-control input-lg" value="<?php echo $soc != '' ? stripslashes($soc->MAIL_TRANSP()) : ''; ?>"
                                     />
                          </div>
                      </div>
                  </div>
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label class="col-md-4 col-xs-12 control-label" style="text-align:left;">GPS Latitude </label>
                          <div class="col-md-8 col-xs-12">
                              <input type="text" name="lat_transp" id="lat_transp" placeholder="Coordonnée GPS Latitude" 
                                     data-mask="fdecimal" data-dec="" data-rad="," maxlength="20"
                                     class="form-control input-lg" value="<?php echo $soc != '' ? stripslashes($soc->LAT_TRANSP()) : ''; ?>"/>
                          </div>
                      </div>
                  </div>
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label class="col-md-4 col-xs-12 control-label" style="text-align:left;">GPS Longitude </label>
                          <div class="col-md-8 col-xs-12">
                              <input type="text" name="lng_transp" id="lng_transp" placeholder="Coordonnée GPS Longitude"
                                     data-mask="fdecimal" data-dec="" data-rad="," maxlength="20"
                                     class="form-control input-lg" value="<?php echo $soc != '' ? stripslashes($soc->LNG_TRANSP()) : ''; ?>"/>
                          </div>
                      </div>
                  </div>

                  <div class="col-sm-12">
                      <div class="form-group">
                          <label class="col-md-4 col-xs-12 control-label" style="text-align:left;">Contacts</label>
                          <div class="col-md-8 col-xs-12">
                              <input type="text" name="contacts_transp" id="contacts_transp" placeholder="Téléphones..." 
                                     class="form-control input-lg" value="<?php echo $soc != '' ? stripslashes($soc->CONTACTS_TRANSP()) : ''; ?>"/>
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
    <h4>10 derniers Transporteurs Inscrits :</h4>
    <div class="conteneur-transp">
    <?php
      $transp = getAllTransporteursLimite(10);
      foreach($transp as $t){
        echo $t['MAISON_TRANSP'] . '<br>';
      }
    ?>
    </div>
    <?php } ?>
  </div>

 <script src="neon/assets/js/jquery.validate.min.js"></script>
 <script src="neon/assets/js/jquery.inputmask.bundle.min.js"></script>
 <script src="modules/form-prosses/scripts.js"></script>
 <script src="modules/transporteurs/scripts.js"></script>
<script>
  

</script>
