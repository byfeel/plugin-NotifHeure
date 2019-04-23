<?php
/*
 * This file is part of the NextDom software (https://github.com/NextDom or http://nextdom.github.io).
 * Copyright (c) 2018 Byfeel.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, version 2.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
//require_once dirname(__FILE__) . '/../../3rdparty/websocket_client.php';

class NotifHeure extends eqLogic
{

    /*************** Attributs ***************/

    /************* Static methods ************/

    /**
     * Tâche exécutée toutes les 30 minutes.
     *
     * @param null $_eqLogic_id Identifiant des objets
     */
    public static function cron15($_eqLogic_id = null)
    {
        // Récupère la liste des équipements
        if ($_eqLogic_id == null) {
            $eqLogics = self::byType('NotifHeure', true);
        } else {
            $eqLogics = array(self::byId($_eqLogic_id));
        }
      // Met à jour l'ensemble des équipements via cmd refresh
        foreach ($eqLogics as $notifObj) {
            if ($notifObj->getIsEnable()==1)
            {
            $getDataCmd = $notifObj->getCmd(null, 'refresh');
            if (!is_object($getDataCmd)) {
              continue;
            }
            $getDataCmd->execCmd();
        }
      }
    }

    public static $_widgetPossibility = array ('custom' => array(

       'visibility' => true,
       'displayName' => array('dashboard'=>true,'plan'=>true,'view'=>true,'mobile'=>true),
       //'displayName'=>true,
       'displayObjectName' => true,
       'optionalParameters' => true,
       'background-color'=>true,
       'text-color'=>true,
       'border-radius' => true,
       'border'=>true,

   ));



    /**************** Methods ****************/
    public function preSave() {
      //si interface std
        //log::add('NotifHeure', 'debug', 'presave');
        $this->setDisplay("width","400px");

    }

    public function preUpdate()
    {
      // log::add('NotifHeure', 'debug', 'preupdate');
      // test si adresse ip ok
      if ($this->getConfiguration('IPnotif') == '') {
			throw new Exception(__('L\'adresse IP ne peut être vide', __FILE__));
		}
      //log::add('NotifHeure', 'debug', 'ip :'.$this->getConfiguration('IPnotif'));
      if ($this->getIsEnable()==1)  self::upConfig();

}
public function preInsert()
    {

//log::add('NotifHeure', 'debug', 'preinsert');
    }

    public function postInsert()
    {

//log::add('NotifHeure', 'debug', 'postinsert');
    }


    public function postUpdate()
    {
//log::add('NotifHeure', 'debug', 'postupdate');
    }

    public function preRemove()
    {

    }

    public function postRemove()
    {

    }


    public function postSave() {
// création des commandes

        log::add('NotifHeure', 'debug', 'creations des commandes pour notifheure ip :'.$this->getConfiguration('IPnotif'));
        list($M, $m) = explode(".",$this->getConfiguration('version'));
        log::add('NotifHeure', 'debug', 'detection version notifheure - Version Majeur :'.$M.' Mineur :'.$m);
        $getDataCmd = $this->getCmd(null, 'refresh');
        if (!is_object($getDataCmd)) {
            // Création de la commande
            $cmd = new NotifHeureCmd();
            // Nom affiché
            $cmd->setName('Rafraichir');
            // Identifiant de la commande
            $cmd->setLogicalId('refresh');
            // Identifiant de l'équipement
            $cmd->setEqLogic_id($this->getId());
            // Type de la commande
            $cmd->setType('action');
            // Sous-type de la commande
            $cmd->setSubType('other');
            // Visibilité de la commande
            $cmd->setIsVisible(1);
            // Sauvegarde de la commande
            $cmd->save();
        }


      $getDataCmd = $this->getCmd(null, 'secOn');
      if (!is_object($getDataCmd)) {
          $cmd = new NotifHeureCmd();
          $cmd->setName(__('Afficher Secondes', __FILE__));
          $cmd->setLogicalId('secOn');
          $cmd->setEqLogic_id($this->getId());
          $cmd->setType('action');
          $cmd->setSubType('other');
          $cmd->setIsVisible(1);
          $cmd->save();
      }
      $getDataCmd = $this->getCmd(null, 'secOff');
      if (!is_object($getDataCmd)) {
          $cmd = new NotifHeureCmd();
          $cmd->setName(__('Masquer Secondes', __FILE__));
          $cmd->setLogicalId('secOff');
          $cmd->setEqLogic_id($this->getId());
          $cmd->setType('action');
          $cmd->setSubType('other');
          $cmd->setIsVisible(1);
          $cmd->save();
      }
      $getDataCmd = $this->getCmd(null, 'SEC');
      if (!is_object($getDataCmd)) {
          $cmd = new NotifHeureCmd();
          $cmd->setName(__('Etat Secondes', __FILE__));
          $cmd->setLogicalId('SEC');
          $cmd->setEqLogic_id($this->getId());
          $cmd->setType('info');
          $cmd->setSubType('binary');
          $cmd->setIsVisible(1);
          $cmd->setOrder(1);
          $cmd->save();
      }
      $getDataCmd = $this->getCmd(null, 'horOn');
      if (!is_object($getDataCmd)) {
          $cmd = new NotifHeureCmd();
          $cmd->setName(__('Afficher Horloge', __FILE__));
          $cmd->setLogicalId('horOn');
          $cmd->setEqLogic_id($this->getId());
          $cmd->setType('action');
          $cmd->setSubType('other');
          $cmd->setIsVisible(1);
          $cmd->save();
      }
      $getDataCmd = $this->getCmd(null, 'horOff');
      if (!is_object($getDataCmd)) {
          $cmd = new NotifHeureCmd();
          $cmd->setName(__('Masquer Horloge', __FILE__));
          $cmd->setLogicalId('horOff');
          $cmd->setEqLogic_id($this->getId());
          $cmd->setType('action');
          $cmd->setSubType('other');
          $cmd->setIsVisible(1);
          $cmd->save();
      }
      $getDataCmd = $this->getCmd(null, 'HOR');
      if (!is_object($getDataCmd)) {
          $cmd = new NotifHeureCmd();
          $cmd->setName(__('Etat Horloge', __FILE__));
          $cmd->setLogicalId('HOR');
          $cmd->setEqLogic_id($this->getId());
          $cmd->setType('info');
          $cmd->setSubType('binary');
          $cmd->setIsVisible(1);
          $cmd->save();
      }
      // Si photocell présente
      if ($this->getConfiguration('isphotocell')=="Oui")
      {
      $getDataCmd = $this->getCmd(null, 'lumOn');
      if (!is_object($getDataCmd)) {
          $cmd = new NotifHeureCmd();
          $cmd->setName(__('Activer Mode Auto', __FILE__));
          $cmd->setLogicalId('lumOn');
          $cmd->setEqLogic_id($this->getId());
          $cmd->setType('action');
          $cmd->setSubType('other');
          $cmd->setIsVisible(1);
          $cmd->save();
      }
    }
      $getDataCmd = $this->getCmd(null, 'LUM');
      if (!is_object($getDataCmd)) {
          $cmd = new NotifHeureCmd();
          $cmd->setName(__('Mode Auto', __FILE__));
          $cmd->setLogicalId('LUM');
          $cmd->setEqLogic_id($this->getId());
          $cmd->setType('info');
          $cmd->setSubType('binary');
          $cmd->setIsVisible(1);
          $cmd->save();
      }
      // si led présente
      if ($this->getConfiguration('isLed') == 'Oui') {
      $getDataCmd = $this->getCmd(null, 'ledOn');
      if (!is_object($getDataCmd)) {
          $cmd = new NotifHeureCmd();
          $cmd->setName(__('Led On', __FILE__));
          $cmd->setLogicalId('ledOn');
          $cmd->setEqLogic_id($this->getId());
          $cmd->setType('action');
          $cmd->setSubType('other');
          $cmd->setIsVisible(1);
          $cmd->save();
      }
      $getDataCmd = $this->getCmd(null, 'ledOff');
      if (!is_object($getDataCmd)) {
          $cmd = new NotifHeureCmd();
          $cmd->setName(__('Led Off', __FILE__));
          $cmd->setLogicalId('ledOff');
          $cmd->setEqLogic_id($this->getId());
          $cmd->setType('action');
          $cmd->setSubType('other');
          $cmd->setIsVisible(1);
          $cmd->save();
      }
      $getDataCmd = $this->getCmd(null, 'LED');
      if (!is_object($getDataCmd)) {
          $cmd = new NotifHeureCmd();
          $cmd->setName(__('Etat LED', __FILE__));
          $cmd->setLogicalId('LED');
          $cmd->setEqLogic_id($this->getId());
          $cmd->setType('info');
          $cmd->setTemplate('dashboard','light');
          $cmd->setSubType('binary');
          $cmd->setIsVisible(1);
          $cmd->save();
      }
    } // fin led
      $getDataCmd = $this->getCmd(null, 'INTcmd');
      if (!is_object($getDataCmd)) {
          $cmd = new NotifHeureCmd();
          $cmd->setName(__('Réglage Intensité', __FILE__));
          $cmd->setLogicalId('INTcmd');
          $cmd->setEqLogic_id($this->getId());
          $cmd->setType('action');
          $cmd->setSubType('slider');
          $cmd->setConfiguration('minValue', 0);
          $cmd->setConfiguration('maxValue', 15);
          $cmd->setIsVisible(1);
          $cmd->save();
      }
      $getDataCmd = $this->getCmd(null, 'INT');
      if (!is_object($getDataCmd)) {
          $cmd = new NotifHeureCmd();
          $cmd->setName(__('Intensité', __FILE__));
          $cmd->setLogicalId('INT');
          $cmd->setEqLogic_id($this->getId());
          $cmd->setType('info');
          $cmd->setTemplate('dashboard','line');
          $cmd->setSubType('numeric');
          $cmd->setIsVisible(1);
          $cmd->save();
      }
      // creation commande version sup a 3.3
      if ($M>=3 && $m >=3 ) {
      $getDataCmd = $this->getCmd(null, 'MINcmd');
      if (!is_object($getDataCmd)) {
          $cmd = new NotifHeureCmd();
          $cmd->setName(__('Temps Minuteur', __FILE__));
          $cmd->setLogicalId('MINcmd');
          $cmd->setEqLogic_id($this->getId());
          $cmd->setType('action');
          $cmd->setSubType('slider');
          $cmd->setConfiguration('minValue', 1);
          $cmd->setConfiguration('maxValue', 600);
          $cmd->setTemplate('dashboard','minuteur');
          $cmd->setTemplate('mobile','minuteur');
          $cmd->setIsVisible(1);
          $cmd->save();
      }
      $getDataCmd = $this->getCmd(null, 'CRToggle');
      if (!is_object($getDataCmd)) {
          $cmd = new NotifHeureCmd();
          $cmd->setName(__('Toggle Minuteur', __FILE__));
          $cmd->setLogicalId('CRToggle');
          $cmd->setEqLogic_id($this->getId());
          $cmd->setType('action');
          $cmd->setSubType('other');
          $cmd->setIsVisible(1);
          $cmd->save();
      }
      $getDataCmd = $this->getCmd(null, 'CR');
      if (!is_object($getDataCmd)) {
          $cmd = new NotifHeureCmd();
          $cmd->setName(__('Etat Minuteur', __FILE__));
          $cmd->setLogicalId('CR');
          $cmd->setEqLogic_id($this->getId());
          $cmd->setType('info');
          $cmd->setSubType('binary');
          $cmd->setIsVisible(1);
          $cmd->save();
      }
    }
      if ($this->getConfiguration('isDht') == 'Oui') {
        log::add('NotifHeure', 'debug', 'configuration dht ok');
        $getDataCmd = $this->getCmd(null, 'temp');
        if (!is_object($getDataCmd)) {
            $cmd = new NotifHeureCmd();
            $cmd->setName(__('Température', __FILE__));
            $cmd->setLogicalId('temp');
            $cmd->setEqLogic_id($this->getId());
            $cmd->setType('info');
            $cmd->setTemplate('dashboard','badge');
            $cmd->setSubType('numeric');
            $cmd->setUnite('°C');
            $cmd->setIsVisible(1);
            $cmd->save();
        }
        $getDataCmd = $this->getCmd(null, 'hum');
        if (!is_object($getDataCmd)) {
            $cmd = new NotifHeureCmd();
            $cmd->setName(__('Humidité', __FILE__));
            $cmd->setLogicalId('hum');
            $cmd->setEqLogic_id($this->getId());
            $cmd->setType('info');
            $cmd->setTemplate('dashboard','badge');
            $cmd->setSubType('numeric');
            $cmd->setUnite('%');
            $cmd->setIsVisible(1);
            $cmd->save();
        }
        $getDataCmd = $this->getCmd(null, 'hi');
        if (!is_object($getDataCmd)) {
            $cmd = new NotifHeureCmd();
            $cmd->setName(__('Temp. Ressentis', __FILE__));
            $cmd->setLogicalId('hi');
            $cmd->setEqLogic_id($this->getId());
            $cmd->setType('info');
            $cmd->setTemplate('dashboard','badge');
            $cmd->setSubType('numeric');
            $cmd->setUnite('°C');
            $cmd->setIsVisible(1);
            $cmd->save();
        }
        $getDataCmd = $this->getCmd(null, 'point');
        if (!is_object($getDataCmd)) {
            $cmd = new NotifHeureCmd();
            $cmd->setName(__('P. de Rosée', __FILE__));
            $cmd->setLogicalId('point');
            $cmd->setEqLogic_id($this->getId());
            $cmd->setType('info');
            $cmd->setTemplate('dashboard','badge');
            $cmd->setSubType('numeric');
            $cmd->setUnite('°C');
            $cmd->setIsVisible(1);
            $cmd->save();
        }
      }
      else   log::add('NotifHeure', 'debug', 'configuration no dht');
      $getDataCmd = $this->getCmd(null, 'notif');
      if (!is_object($getDataCmd)) {
          // Création de la commande
          $cmd = new NotifHeureCmd();
          // Nom affiché
          $cmd->setName(__('Envoie Notif.', __FILE__));
          // Identifiant de la commande
          $cmd->setLogicalId('notif');
          // Identifiant de l'équipement
          $cmd->setEqLogic_id($this->getId());
          // Type de la commande
          $cmd->setType('action');
          // Sous-type de la commande
          $cmd->setSubType('message');
          $cmd->setDisplay('title_placeholder', __('Options Notif.', __FILE__));
          $cmd->setDisplay('message_placeholder', __('Notification', __FILE__));
          // Visibilité de la commande
          $cmd->setIsVisible(1);
          // Sauvegarde de la commande
          $cmd->save();
        }
      //lance la tache cron15 en fin de commande pour mise à jour
      self::cron15($this->getId());
      //$getDataCmd = $this->getCmd(null, 'refresh');
      //$getDataCmd->execCmd();
    }



    public function toSocket() {
      $IP=$this->getConfiguration('IPnotif');
      $data="MDNS";
      $port = 81;
      $adresse = $IP;
      //
      $socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
      if($socket === false)
      {
            //  echo "Erreur 1";
      }
      //
      $connect = socket_connect($socket,$adresse,$port);
      if($connect  === false)
      {
              //echo "Erreur 2";
      }
      //
      $buffer = "MDNS";
      socket_write($socket,$buffer,strlen($buffer));
      //
      $reception = socket_read($socket,255,PHP_NORMAL_READ);
      //echo $reception;
      //
      socket_close($socket);
      //  $ws->close();
      //$info= json_decode($result, TRUE);

      // create socket
  //  $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
      // connect to server
  //  $result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");
      // send string to server
  //  socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
      // get server response
  //    $result = socket_read ($socket, 1024) or die("Could not read server response\n");
    log::add('NotifHeure', 'debug', 'socket valeur = '.$reception);
      //close socket

    }

 public function toHtml($_version = 'dashboard') {


   $replace = $this->preToHtml($_version);
if (!is_array($replace)) {
   return $replace;
}
$version = jeedom::versionAlias($_version);
if ($this->getDisplay('hideOn' . $version) == 1) {
   return '';
}

if ($this->getConfiguration('WidgetTemplate' ) == "NotifHeure") {

  $dataCmd = $this->getCmd('info', "HOR");
  $hor=$dataCmd->execCmd();
  $dataCmd = $this->getCmd('info', "SEC");
  $sec=$dataCmd->execCmd();

  $getDataCmd = $this->getCmd(null, 'MINcmd');
  if (is_object($getDataCmd))  {
    $minut=TRUE;
    $dataCmd = $this->getCmd('info', "CR");
    $CR=$dataCmd->execCmd();
    }
    else $minut=FALSE;
  log::add('NotifHeure', 'debug', 'option minuteur = '.$minut);
  if ($hor==FALSE) $statusNotif=0;
  else if ($CR==TRUE && $minut==TRUE ) $statusNotif=5;
  else if ($sec==FALSE) $statusNotif=2;
  else $statusNotif=1;
  $crtime=config::byKey('crtime', 'notifheure');
  if (intval($crtime) >0 ) $crtime =  intval($crtime);
  else $crtime=1;
 //log::add('NotifHeure', 'debug', 'debug html from '.$this->getName().' valeur HOR : '.$hor);

    /* ------------ Ajouter votre code ici ------------*/
    foreach ($this->getCmd('info') as $cmd) {
        $replace['#' . $cmd->getLogicalId() . '_history#'] = '';
        $replace['#' . $cmd->getLogicalId() . '_text#'] = $cmd->execCmd() . " " . $cmd->getUnite();
        $replace['#' . $cmd->getLogicalId() . '_id#'] = $cmd->getId();
        $replace['#' . $cmd->getLogicalId() . '#'] = $cmd->execCmd();
        $replace['#' . $cmd->getLogicalId() . '_collect#'] = $cmd->getCollectDate();
        if ($cmd->getLogicalId() == 'encours') {
            $replace['#thumbnail#'] = $cmd->getDisplay('icon');
        }
        if ($cmd->getIsHistorized() == 1) {
            $replace['#' . $cmd->getLogicalId() . '_history#'] = 'history cursor';
        }
    }
    // Si minuteur
    $replace['#MINUT#'] = $minut;
    if ($minut) {
      $replace['#CRTIME#'] = $crtime;
      //$replace['#increment#'] = 1;
    }
    // si dht
    if ($this->getConfiguration('isDht') != 'Oui') {
        $replace['#temp_text#'] = " --- ";
        $replace['#hum_text#'] = " --- ";
    }
    // si led
    if ($this->getConfiguration('isLed') != 'Oui') {
        $replace['#LED#'] = "no";
    }
    //statut notifheure
    $replace['#statusNotif#'] = $statusNotif;
    // affichage des commandes
    foreach ($this->getCmd('action') as $cmd) {
        $replace['#' . $cmd->getLogicalId() . '_id#'] = $cmd->getId();
    }
    $_templateArray[$version] = getTemplate('core', $version, $this->getConfiguration('WidgetTemplate'),'NotifHeure');
} else {
    $replace['#eqLogic_class#'] = 'eqLogic_layout_default';
    $cmd_html = '';
    $br_before = 0;
    foreach ($this->getCmd(null, null, true) as $cmd) {
        if (isset($replace['#refresh_id#']) && $cmd->getId() == $replace['#refresh_id#']) {
            continue;
        }
        if ($br_before == 0 && $cmd->getDisplay('forceReturnLineBefore', 0) == 1) {
            $cmd_html .= '<br/>';
        }
        $cmd_html .= $cmd->toHtml($_version, '', $replace['#cmd-background-color#']);
        $br_before = 0;
        if ($cmd->getDisplay('forceReturnLineAfter', 0) == 1) {
            $cmd_html .= '<br/>';
            $br_before = 1;
        }
    }
    $replace['#cmd#'] = $cmd_html;
    $_templateArray[$version] = getTemplate('core', $version, 'eqLogic');

}
/* ------------ N'ajouter plus de code apres ici------------ */
log::add('NotifHeure', 'debug', 'template choice :'.$this->getConfiguration('WidgetTemplate' ));

    return $this->postToHtml($_version, template_replace($replace, $_templateArray[$version] ));

        }

    /********** Getters and setters **********/
    public function sendNotif($_options = array()) {
      //log::add('NotifHeure', 'debug', 'Message : ' . $_options['message']);
      log::add('NotifHeure', 'info', 'From '.$this->getName()." le ".date('d/m H:i')." : Message : ".$_options['message']);
      $type=config::byKey('typeNotif', 'notifheure');
      $lum=config::byKey('lumNotif', 'notifheure');
      $pause=config::byKey('pauseNotif', 'notifheure');
      $fio=config::byKey('fioNotif', 'notifheure');
      // options title
      $Options=preg_split("/[\,\;\.\:\-]/", str_replace(' ', '', $_options['title']));
             foreach ( $Options as $Value ){
            list($k, $v) = explode("=",$Value);
            $k = strtolower($k);
            $v = strtoupper($v);
            $result[ $k ] = $v;
          }
          // Affectation des differents index
          if (array_key_exists('type', $result)) $type=$result["type"];
          if (array_key_exists('lum', $result)) $lum=$result["lum"];
           $flash=$result["flash"];
           $txt=$result["txt"];
           // si info txt absente , on récupére info notif page config
           if (empty($txt)) $txt=$this->getConfiguration('txteffect');
           // test si tag important
           if (array_key_exists("important",$result)) $imp="&important=";
           else $imp="";
           // fx , pour type info et fix
           if ( $type == "INFO") {
               if (array_key_exists('pause', $result)) $pause=$result["pause"];
               $fi=$result["fi"];
               $fo=$result["fo"];
               if (array_key_exists('fio', $result)) $fio=$result["fio"];
                  if (!is_numeric($fi)) $fi=8;
                  if (!is_numeric($fo)) $fo=1;
                  if (is_numeric($fio)) {
                     $fi=$fio;
                     $fo=$fio;
                   }
                   if (!is_numeric($pause)) $pause=3;
                   $argtype="&type=".$type."&pause=".$pause."&fi=".$fi."&fo=".$fo;
          }
        else {
        $argtype="&type=".$type;
      }
      $url = 'http://' . $this->getConfiguration('IPnotif').'/Notification?msg=' .urlencode($_options['message']).$argtype."&intnotif=".$lum."&flash=".$flash."&txt=".$txt.$imp;
      // envoie requete
      $request_http = new com_http($url);
      $request_http->exec(30);
      log::add('NotifHeure', 'debug', 'URL : ' . $url);
    }

    public function sendOpt($opt,$val) {
      log::add('NotifHeure', 'debug', 'fonction options : comm ='.$opt.' valeur = '.$val);

      if ($opt=="MIN") $val=$val*60;
      else $this->checkAndUpdateCmd($opt,$val);
      $url = 'http://'.$this->getConfiguration('IPnotif').'/Options';
      $data = array($opt => $val);
      $options = array(
            'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
          ),
      );
      $context  = stream_context_create($options);
      $result = file_get_contents($url, false, $context);

      if ($opt =="INT" ) $this->checkAndUpdateCmd("LUM",FALSE);

      //log::add('NotifHeure', 'debug', $test);
    }

    public function getInfo() {
      $url = 'http://' . $this->getConfiguration('IPnotif').'/getInfo';
      $jsonotif=file_get_contents($url);
      if(!$jsonotif) throw new Exception(__('L\'adresse '.$this->getConfiguration('IPnotif').' ne semble pas joignable - Merci de verifier cette adresse.', __FILE__));
      $info= json_decode($jsonotif, TRUE);
      return $info;
    }

    public function upConfig() {
      $info=self::getInfo();
      if ($info['dht']['Status']=='OK') $this->setConfiguration('isDht',"Oui");
      else $this->setConfiguration('isDht','Non');
      if ($info['system']['Photocell']) $this->setConfiguration('isphotocell','Oui');
      else $this->setConfiguration('isphotocell','Non');
      //$this->setConfiguration('WidgetTemplate',$this->getConfiguration('WidgetTemplate'));
     $this->setConfiguration('nom',$info['system']['lieu']);
     $this->setConfiguration('ip',$info['system']['IP']);
      $this->setConfiguration('version',$info['system']['version']);
      $this->setConfiguration('signal',$info['system']['RSSI']." dBm");
      $this->setConfiguration('mac',$info['system']['MAC']);
      $this->setConfiguration('hostname',$info['system']['hostname']);
      $this->setConfiguration('display',$info['system']['display']);
      if ($info['system']['multizone']) $this->setConfiguration('multizone','Oui');
      else $this->setConfiguration('multizone','Non');
      if ($info['system']['LED']) $this->setConfiguration('isLed','Oui');
      else $this->setConfiguration('isLed','Non');

    }



}

class NotifHeureCmd extends cmd
{

    /*************** Attributs ***************/

    /************* Static methods ************/

    /**************** Methods ****************/

    public function execute($_options = array()) {
        // Recup Equipement
        $NotifEq = $this->getEqLogic();
      //  Recup commande
        $Cmdnotif=$this->getLogicalId();
      /*  if ($this->getLogicalId() == 'refresh') {
            // On récupère l'équipement à partir de l'identifiant fournit par la commande
            $notifObj = NotifHeure::byId($this->getEqlogic_id());
            // On récupère la commande 'data' appartenant à l'équipement
            $dataCmd = $notifObj->getCmd('info', 'data');
            // On lui ajoute un évènement avec pour information 'Données de test'
            $dataCmd->event(date('H:i'));
            // On sauvegarde cet évènement
            $dataCmd->save();
        }
*/
        $getRefreshCmd = $NotifEq->getCmd(null, 'refresh');


        switch ($Cmdnotif) {
          case 'notif' : $NotifEq->sendNotif($_options);
          break;
          case 'secOn' : $NotifEq->sendOpt("SEC",TRUE);
          break;
          case 'secOff': $NotifEq->sendOpt("SEC",FALSE);
          break;
          case 'INTcmd' :
          log::add('NotifHeure', 'debug','test slider : '. $_options['slider']);
          $NotifEq->sendOpt("INT",$_options['slider']);
          break;
          case 'lumOn' : $NotifEq->sendOpt("LUM",TRUE);
          break;
          /*case 'lumOff' : $NotifEq->sendOpt("LUM",FALSE);
          break;*/
          case 'horOn' : $NotifEq->sendOpt("HOR",TRUE);
          break;
          case 'horOff' : $NotifEq->sendOpt("HOR",FALSE);
          break;
          case 'ledOn' : $NotifEq->sendOpt("LED",TRUE);
          break;
          case 'ledOff' : $NotifEq->sendOpt("LED",FALSE);
          break;
          case 'MINcmd' : $NotifEq->sendOpt("MIN",$_options['slider']);
                          $getRefreshCmd->execCmd();
          break;
          case 'CRToggle' :   $dataCmd = $NotifEq->getCmd('info', "CR");
                              $CR=$dataCmd->execCmd();
                              $CR=!$CR;
                              $NotifEq->sendOpt("CR",$CR);
                            $getRefreshCmd->execCmd();
          break;
          case 'refresh' : //$NotifEq->toSocket();
          $info=$NotifEq->getInfo();

            log::add('NotifHeure', 'debug', 'refresh des commandes ');
          $NotifEq->checkAndUpdateCmd('SEC',$info['Options']['SEC']);
          $NotifEq->checkAndUpdateCmd('HOR',$info['Options']['HOR']);
          $NotifEq->checkAndUpdateCmd('LUM',$info['Options']['LUM']);
          $NotifEq->checkAndUpdateCmd('INT',$info['Options']['INT']);
          $NotifEq->checkAndUpdateCmd('CR',$info['system']['CR']);
            if ($NotifEq->getConfiguration('isDht') == 'Oui') {
          log::add('NotifHeure', 'debug', 'info dht T:'.$info['dht']['T']);
          $NotifEq->checkAndUpdateCmd('temp',$info['dht']['T']);
          $NotifEq->checkAndUpdateCmd('hum',$info['dht']['H']);
          $NotifEq->checkAndUpdateCmd('hi',$info['dht']['Hi']);
          $NotifEq->checkAndUpdateCmd('point',$info['dht']['P']);
            }
              if ($NotifEq->getConfiguration('isLed') == 'Oui') {
          $NotifEq->checkAndUpdateCmd('LED',$info['Options']['LEDstate']);
              }
              if ($NotifEq->getConfiguration('isphotocell') == "Non") {
          $NotifEq->checkAndUpdateCmd('LUM',FALSE);
              }
              $NotifEq->refreshWidget();
          break;

        }


    }

    /********** Getters and setters **********/

}
