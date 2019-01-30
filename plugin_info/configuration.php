<?php

/*
 * This file is part of the NextDom software (https://github.com/NextDom or http://nextdom.github.io).
 * Copyright (c) 2019 Byfeel.
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

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';

include_file('core', 'authentification', 'php');

if (!isConnect()) {
    include_file('desktop', '404', 'php');
    die();
}
$string = file_get_contents("./plugins/NotifHeure/plugin_info/info.json");
$info= json_decode($string, TRUE);
$v=$info['version'];

?>
<form class="form-horizontal">
    <fieldset>
      <H4>Valeur par défaut pour envoie notification ( Options )</H4>
        <div class="form-group">
            <label class="col-lg-4 control-label">{{Luminosité }}</label>
            <div class="col-lg-2">
                <input type="number" class="configKey form-control" data-l1key="lumNotif" value="10" min="0" max="15"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label">{{Type}}</label>
            <div class="col-lg-2">
              <select class="configKey form-control" data-l1key="typeNotif">
                  <option value="">Scrolling</option>
                  <option value="INFO">Info</option>
                  <option value="FIX">Fix</option>
                  <option value="PAC">PAC Man</option>
              </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label">{{Temps de pause - Info - }}</label>
            <div class="col-lg-2">
                <input type="number" class="configKey form-control" data-l1key="pauseNotif" value="3" min="0" max="60"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label">{{Effet entrée-Sortie  - Info - }}</label>
            <div class="col-lg-2">
                <input type="number" class="configKey form-control" data-l1key="fioNotif" value="8" min="0" max="28"/>
            </div>
        </div>
        <H4>Valeur par défaut pour Minuteur</H4>
        <div class="form-group">
            <label class="col-lg-4 control-label">{{Temps par défaut pour le minuteur}}</label>
            <div class="col-lg-2">
                <input type="number" class="configKey form-control" data-l1key="crtime" value="5" min="1" max="600"/>
            </div>
        </div>
        <div>
          <H4>{{Info Plugin}}</H4>
          <p>Version plugin : <?php echo $v;?></p>
          <a href="https://paypal.me/byfeel?locale.x=fr_FR">Don au développeur - Byfeel -</a>
        </div>
    </fieldset>
</form>
