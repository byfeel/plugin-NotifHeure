
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
include_file('core', 'authentification', 'php');

if (!isConnect('admin')) {
    throw new Exception('{{401 - Refused access}}');
}
// Inclure la feuille de style de la page
//include_file('desktop', 'tutoriel', 'css', 'tutoriel');
// Obtenir l'identifiant du plugin
$plugin = plugin::byId('NotifHeure');
// Charger le javascript
sendVarToJS('eqType', $plugin->getId());
// Accéder aux données du plugin
$eqLogics = eqLogic::byType($plugin->getId());
?>
<div class="row row-overflow">
    <div class="col-lg-2 col-md-3 col-sm-4">
        <div class="bs-sidebar">
            <!-- Menu latéral -->
            <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
                <!-- Bouton d'ajout -->
                <a class="btn btn-default eqLogicAction" data-action="add" style="margin-bottom: 5px;width: 100%">
                    <i class="fa fa-plus-circle"></i> {{Ajouter un object}}
                </a>
                <!-- Filtre des objets -->
                <li class="filter" style="margin-bottom: 5px; width: 100%"><input class="filter form-control input-sm" placeholder="{{Rechercher}}"/></li>
                <!-- Liste des objets -->
                <?php foreach ($eqLogics as $eqLogic) : ?>
                    <li class="cursor li_eqLogic" data-eqLogic_id="<?php echo $eqLogic->getId(); ?>">
                        <a><?php echo $eqLogic->getHumanName(true); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <!-- Container des listes de commandes / éléments -->
    <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay"
         style="border-left: solid 1px #EEE; padding-left: 25px;">
        <legend>{{Mes Objets}}</legend>
        <legend><i class="fa fa-cog"></i> {{Gestion}}</legend>
        <div class="eqLogicThumbnailContainer">
            <div class="cursor eqLogicAction" data-action="add"
                 style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
                <i class="fa fa-plus-circle" style="font-size : 6em;color:#0970b9;"></i>
                <br>
                <span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#0970b9">{{Ajouter}}</span>
            </div>
            <div class="cursor eqLogicAction" data-action="gotoPluginConf"
                 style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
                <i class="fa fa-wrench" style="font-size : 6em;color:#767676;"></i>
                <br>
                <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676">{{Configuration}}</span>
            </div>
        </div>
        <!-- Début de la liste des objets -->
        <legend><i class="fa fa-clock-o"></i> {{Mes Notif'heure}}</legend>
        <!-- Container de la liste -->
        <div class="eqLogicThumbnailContainer">
            <!-- Boucle sur les objects -->
            <?php
            foreach ($eqLogics as $eqLogic) {
                $opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
                echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
                echo '<img src="' . $plugin->getPathImgIcon() . '" height="105" width="95" />';
                echo "<br>";
                echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;">' . $eqLogic->getHumanName(true, true) . '</span>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <!-- Container du panneau de contrôle -->
    <div class="col-lg-10 col-md-9 col-sm-8 eqLogic"
         style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
        <!-- Bouton sauvegarder -->
        <a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i>
            {{Sauvegarder}}</a>
        <!-- Bouton Supprimer -->
        <a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i>
            {{Supprimer}}</a>
        <!-- Bouton configuration avancée -->
        <a class="btn btn-default eqLogicAction pull-right" data-action="configure"><i class="fa fa-cogs"></i>
            {{Configuration avancée}}</a>
        <!-- Liste des onglets -->
        <ul class="nav nav-tabs" role="tablist">
            <!-- Bouton de retour -->
            <li role="presentation"><a class="eqLogicAction cursor" aria-controls="home" role="tab"
                                       data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a>
            </li>
            <!-- Onglet "Equipement" -->
            <li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab"
                                                      data-toggle="tab"><i
                            class="fa fa-tachometer"></i> {{Equipement}}</a></li>
            <!-- Onglet "Commandes" -->
            <li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i
                            class="fa fa-list-alt"></i> {{Commandes}}</a></li>
        </ul>
        <!-- Container du contenu des onglets -->
        <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
            <!-- Panneau de modification de l'objet -->
            <div role="tabpanel" class="tab-pane active" id="eqlogictab">
                <!-- Car le CSS, c'est pour les faibles -->
                <br/>
                <!-- Ligne de contenu -->
                <div class="row">
                    <!-- Division en colonne -->
                    <div class="col-sm-8">
                        <!-- Début du formulaire -->
                        <form class="form-horizontal">
                            <!-- Bloc de champs -->
                            <fieldset>
                                <!-- Container global d'un champ du formulaire -->
                                <div class="form-group">
                                    <!-- Label du champ -->
                                    <label class="col-sm-4 control-label">{{Nom de l'équipement}}</label>
                                    <!-- Container du champ -->
                                    <div class="col-sm-8">
                                        <!-- Iidentifiant caché. -->
                                        <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;"/>
                                        <!-- Nom de l'objet-->
                                        <input type="text" class="eqLogicAttr form-control" data-l1key="name"
                                               placeholder="{{Nom de l'équipement}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{Objet parent}}</label>
                                    <div class="col-sm-8">
                                        <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
                                            <option value="">{{Aucun}}</option>
                                            <?php
                                            foreach (jeeObject::all() as $object) {
                                                echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{Catégorie}}</label>
                                    <div class="col-sm-8">
                                        <?php
                                        foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
                                            echo '<label class="checkbox-inline">';
                                            echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
                                            echo '</label>';
                                        }
                                        ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{Etat}}</label>
                                    <div class="col-sm-8">
                                        <!-- Case à cocher activant l'équipement -->
                                        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
                                        <!-- Case à cocher pour rendre l'élément visible -->
                                        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{Adresse IP}}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="IPnotif" placeholder="Adresse Ip du notif'heure"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class=" col-sm-4 control-label">{{Widget}}</label>
                                    <div class="col-sm-8">
                                        <select class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="WidgetTemplate">
                                            <option value="">Widget par Défaut</option>
                                            <option value="NotifHeure">Widget NotifHeure</option>
                                        </select>
                                    </div>
                                </div>
                                <h4>{{Info Notif'heure}}</h4>
                                <hr class='my-1'>


                                <span id="IP" class="eqLogicAttr" data-l1key="configuration" data-l2key="ip" style="display:none;"></span>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{Version}}</label>
                                    <div class="col-sm-3">
                                        <span class="eqLogicAttr" data-l1key="configuration" data-l2key="version"></span>
                                    </div>

                                    <label class="col-sm-2 control-label">{{Signal}}</label>
                                    <div class="col-sm-3">
                                        <span class="eqLogicAttr" data-l1key="configuration" data-l2key="signal"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{Adresse MAC}}</label>
                                    <div class="col-sm-3">
                                        <span class="eqLogicAttr" data-l1key="configuration" data-l2key="mac"></span>
                                    </div>
                                    <label class="col-sm-2 control-label">{{Nom reseau}}</label>
                                    <div class="col-sm-3">
                                        <span class="eqLogicAttr" data-l1key="configuration" data-l2key="hostname"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{Nombre Matrice}}</label>
                                    <div class="col-sm-3">
                                        <span class="eqLogicAttr" data-l1key="configuration" data-l2key="display"></span>
                                    </div>
                                    <label class="col-sm-2 control-label">{{Multizone}}</label>
                                    <div class="col-sm-3">
                                        <span class="eqLogicAttr" data-l1key="configuration" data-l2key="multizone"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{Presence DHT}}</label>
                                    <div class="col-sm-3">
                                        <span class="eqLogicAttr" data-l1key="configuration" data-l2key="isDht"></span>
                                    </div>
                                    <label class="col-sm-2 control-label">{{Photocell}}</label>
                                    <div class="col-sm-3">
                                        <span class="eqLogicAttr" data-l1key="configuration" data-l2key="isphotocell"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{Presence LED}}</label>
                                    <div class="col-sm-8">
                                        <span class="eqLogicAttr" data-l1key="configuration" data-l2key="isLed"></span>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{Texte avant effet}}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="txteffect" placeholder="texte affiché avant effet ."/>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <button  class="btn btn-info " onclick="goConfig();return false;" >{{Page configuration Notif'Heure}} <span class="eqLogicAttr" data-l1key="configuration" data-l2key="nom"></span></button>
                    </div>
                </div>
            </div>
            <!-- Panneau des commandes de l'objet -->
            <div role="tabpanel" class="tab-pane" id="commandtab">
                <!-- Bouton d'ajout d'une commande -->
                <a class="btn btn-success btn-sm cmdAction pull-right" data-action="add" style="margin-top:5px;"> <i
                            class="fa fa-plus-circle"></i> {{Commandes}}</a>
                <br/><br/>
                <!-- Tableau des commandes -->
                <table id="table_cmd" class="table table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th>{{id}}</th>
                        <th style="width: 300px;">{{Nom}}</th>
                        <th>{{Type}}</th>
                        <th>{{Historique}}</th>
                        <th>{{Actions}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
include_file('core', 'plugin.template', 'js');
// Inclure le fichier javascript du tutoriel
include_file('desktop', 'NotifHeure', 'js', 'NotifHeure');
