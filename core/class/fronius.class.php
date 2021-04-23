<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once __DIR__  . '/../../../../core/php/core.inc.php';

class fronius extends eqLogic {
    /*     * *************************Attributs****************************** */

    /*     * ***********************Methode static*************************** */

    //Fonction exécutée automatiquement toutes les minutes par Jeedom
    public static function cron() {
		foreach (self::byType('fronius') as $fronius) {//parcours tous les équipements du plugin fronius
			if ($fronius->getIsEnable() == 1) {//vérifie que l'équipement est actif
				$cmd = $fronius->getCmd(null, 'refresh');//retourne la commande "refresh si elle existe
				if (!is_object($cmd)) {//Si la commande n'existe pas
					continue; //continue la boucle
				}
				$cmd->execCmd(); // la commande existe on la lance
			}
		}
    }

	/*
     * Fonction exécutée automatiquement toutes les heures par Jeedom
      public static function cronHourly() {

      }
     */

    /*
     * Fonction exécutée automatiquement tous les jours par Jeedom
      public static function cronDaily() {

      }
     */



    /*     * *********************Méthodes d'instance************************* */

    public function preInsert() {

    }

    public function postInsert() {

    }

    public function preSave() {
		$this->setDisplay("width","400px");
		$this->setDisplay("height","350px");
    }

    public function postSave() {
		$info = $this->getCmd(null, 'pv_power');
		if (!is_object($info)) {
			$info = new froniusCmd();
			$info->setName(__('PV Production', __FILE__));
		}
		$info->setLogicalId('pv_power');
		$info->setEqLogic_id($this->getId());
		$info->setType('info');
		$info->setSubType('numeric');
		$info->setConfiguration('minValue', 0);
		$info->setConfiguration('maxValue', $this->getConfiguration("Power"));
		$info->setIsHistorized(1);
		$info->setUnite('W');
		$info->setOrder(1);
		$info->save();

		$info = $this->getCmd(null, 'pv_total');
		if (!is_object($info)) {
			$info = new froniusCmd();
			$info->setName(__('PV Total', __FILE__));
		}
		$info->setLogicalId('pv_total');
		$info->setEqLogic_id($this->getId());
		$info->setType('info');
		$info->setSubType('numeric');
		$info->setIsHistorized(1);
		$info->setUnite('Wh');
		$info->setOrder(2);
		$info->save();

		$info = $this->getCmd(null, 'frequency');
		if (!is_object($info)) {
			$info = new froniusCmd();
			$info->setName(__('Fréquence', __FILE__));
		}
		$info->setLogicalId('frequency');
		$info->setEqLogic_id($this->getId());
		$info->setType('info');
		$info->setSubType('numeric');
		$info->setConfiguration('minValue', 0);
		$info->setConfiguration('maxValue', 60);
		$info->setIsHistorized(1);
		$info->setUnite('Hz');
		$info->setOrder(3);
		$info->save();

		$info = $this->getCmd(null, 'voltage_AC');
		if (!is_object($info)) {
			$info = new froniusCmd();
			$info->setName(__('Volts AC', __FILE__));
		}
		$info->setLogicalId('voltage_AC');
		$info->setEqLogic_id($this->getId());
		$info->setType('info');
		$info->setSubType('numeric');
		$info->setConfiguration('minValue', 0);
		$info->setConfiguration('maxValue', 250);
		$info->setIsHistorized(1);
		$info->setUnite('V');
		$info->setOrder(4);
		$info->save();

		$info = $this->getCmd(null, 'voltage_DC');
		if (!is_object($info)) {
			$info = new froniusCmd();
			$info->setName(__('Volts DC', __FILE__));
		}
		$info->setLogicalId('voltage_DC');
		$info->setEqLogic_id($this->getId());
		$info->setType('info');
		$info->setSubType('numeric');
		$info->setConfiguration('minValue', 0);
		$info->setConfiguration('maxValue', 500);
		$info->setIsHistorized(1);
		$info->setUnite('V');
		$info->setOrder(5);
		$info->save();

		$info = $this->getCmd(null, 'current_AC');
		if (!is_object($info)) {
			$info = new froniusCmd();
			$info->setName(__('Amps AC', __FILE__));
		}
		$info->setLogicalId('current_AC');
		$info->setEqLogic_id($this->getId());
		$info->setType('info');
		$info->setSubType('numeric');
		$info->setConfiguration('minValue', 0);
		$info->setConfiguration('maxValue', 50);
		$info->setIsHistorized(1);
		$info->setUnite('A');
		$info->setOrder(6);
		$info->save();

		$info = $this->getCmd(null, 'current_DC');
		if (!is_object($info)) {
			$info = new froniusCmd();
			$info->setName(__('Amps DC', __FILE__));
		}
		$info->setLogicalId('current_DC');
		$info->setEqLogic_id($this->getId());
		$info->setType('info');
		$info->setSubType('numeric');
		$info->setConfiguration('minValue', 0);
		$info->setConfiguration('maxValue', 50);
		$info->setIsHistorized(1);
		$info->setUnite('A');
		$info->setOrder(7);
		$info->save();

		$info = $this->getCmd(null, 'pv_day');
		if (!is_object($info)) {
			$info = new froniusCmd();
			$info->setName(__('PV Jour', __FILE__));
		}
		$info->setLogicalId('pv_day');
		$info->setEqLogic_id($this->getId());
		$info->setType('info');
		$info->setSubType('numeric');
		$info->setIsHistorized(1);
		$info->setUnite('Wh');
		$info->setOrder(8);
		$info->save();

		$info = $this->getCmd(null, 'pv_year');
		if (!is_object($info)) {
			$info = new froniusCmd();
			$info->setName(__('PV Année', __FILE__));
		}
		$info->setLogicalId('pv_year');
		$info->setEqLogic_id($this->getId());
		$info->setType('info');
		$info->setSubType('numeric');
		$info->setIsHistorized(1);
		$info->setUnite('Wh');
		$info->setOrder(9);
		$info->save();

		$info = $this->getCmd(null, 'VersionAPI');
		if (!is_object($info)) {
			$info = new froniusCmd();
			$info->setName(__('Version API', __FILE__));
		}
		$info->setLogicalId('VersionAPI');
		$info->setEqLogic_id($this->getId());
		$info->setType('info');
		$info->setSubType('string');
		$info->setIsHistorized(0);
		$info->setIsVisible(0);
		$info->setOrder(10);
		$info->save();

		$info = $this->getCmd(null, 'status');
		if (!is_object($info)) {
			$info = new froniusCmd();
			$info->setName(__('Statut', __FILE__));
		}
		$info->setLogicalId('status');
		$info->setEqLogic_id($this->getId());
		$info->setType('info');
		$info->setSubType('string');
		$info->setIsHistorized(0);
		$info->setIsVisible(1);
		$info->setOrder(11);
		$info->save();

# ==========================================================
# FJMG 2021-04-23 Info command added
# ==========================================================
    $info = $this->getCmd(null, 'consumo');
    if (!is_object($info)) {
      $info = new froniusCmd();
      $info->setName(__('Consumo', __FILE__));
    }
    $info->setLogicalId('consumo');
    $info->setEqLogic_id($this->getId());
    $info->setType('info');
    $info->setSubType('numeric');
    $info->setIsHistorized(1);
    $info->setUnite('W');
    $info->setOrder(12);
    $info->save();


# ==========================================================

		$refresh = $this->getCmd(null, 'refresh');
		if (!is_object($refresh)) {
			$refresh = new froniusCmd();
			$refresh->setName(__('Rafraîchir', __FILE__));
		}
		$refresh->setEqLogic_id($this->getId());
		$refresh->setLogicalId('refresh');
		$refresh->setType('action');
		$refresh->setSubType('other');
		$refresh->setOrder(12);
		$refresh->save();
    }

    public function preUpdate() {

    }

    public function postUpdate() {
		$cmd = $this->getCmd(null, 'refresh'); // On recherche la commande refresh de l’équipement
		if (is_object($cmd)) { //elle existe et on lance la commande
			 $cmd->execCmd();
		}
    }

    public function preRemove() {

    }

    public function postRemove() {

    }

	public function getFroniusData() {
		$Fronius_IP = $this->getConfiguration("IP");
		$Fronius_Port = $this->getConfiguration("Port");
		$VersionAPI = '';
		$Url = '';

		if (strlen($Fronius_IP) == 0) {
			log::add('fronius', 'debug','No IP defined for PV inverter interface ...');
			$this->checkAndUpdateCmd('status', 'IP onduleur manquante ...');
			return;
		}

		if (strlen($Fronius_Port) == 0) {
			$Fronius_Port = 80;
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// READ STORED API VERSION
		try {
			$cmd = $this->getCmd(null, 'VersionAPI'); // On recherche la commande refresh de l’équipement
			if (is_object($cmd)) { //elle existe et on lance la commande
				$VersionAPI = $cmd->execCmd();
			}
		} catch (Exception $e) {
			$VersionAPI = '';
			log::add('fronius', 'error','Error reading API Version: '.$e);
		}

		if ($VersionAPI == '') {
			curl_setopt($ch, CURLOPT_URL, 'http://'.$Fronius_IP.':'.$Fronius_Port.'/solar_api/GetAPIVersion.cgi');
			$data = curl_exec($ch);
			if (curl_errno($ch)) {
				curl_close ($ch);
				log::add('fronius', 'error','Error getting inverter API Version: '.curl_error($ch));
				$this->checkAndUpdateCmd('status', 'Erreur Version API');
				return;
			}
			$json = json_decode($data, true);
			$VersionAPI = $json['APIVersion'];
			$this->checkAndUpdateCmd('VersionAPI', $VersionAPI);
		}

# =================================================================
#  FJMG - 2021-04-23 - id http-get GetInverterRealtimeData
#  $Url = 'http://'.$Fronius_IP.':'.$Fronius_Port.'/solar_api/v1/GetInverterRealtimeData.cgi?Scope=Device&DeviceId=1&DataCollection=CommonInverterData';
# =================================================================


		switch ($VersionAPI) {
			case '0':
				$Url = 'http://'.$Fronius_IP.':'.$Fronius_Port.'/solar_api/GetInverterRealtimeData.cgi?Scope=Device&DeviceId=1&DataCollection=CommonInverterData';
				break;

			case '1';
				$Url = 'http://'.$Fronius_IP.':'.$Fronius_Port.'/solar_api/v1/GetInverterRealtimeData.cgi?Scope=Device&DeviceId=1&DataCollection=CommonInverterData';
				break;

			default:
				log::add('fronius', 'error','Error getting inverter API Version: '.curl_error($ch));
				$this->checkAndUpdateCmd('status', 'Version API non supportée');
				return;
		}

		// COLLECTING VALUES - GetInverterRealtimeData
		curl_setopt($ch, CURLOPT_URL, $Url);
		$data = curl_exec($ch);

		if (curl_errno($ch)) {
			curl_close ($ch);
			log::add('fronius', 'error','Error getting inverter values: '.curl_error($ch));
			$this->checkAndUpdateCmd('status', 'Erreur Données');
			return;
		}

    $json = json_decode($data, true);

		$pv_power = $json['Body']['Data']['PAC']['Value'];
		$pv_total = $json['Body']['Data']['TOTAL_ENERGY']['Value'];
		$frequency = $json['Body']['Data']['FAC']['Value'];
		$voltage_AC = $json['Body']['Data']['UAC']['Value'];
		$voltage_DC = $json['Body']['Data']['UDC']['Value'];
		$current_AC = $json['Body']['Data']['IAC']['Value'];
		$current_DC = $json['Body']['Data']['IDC']['Value'];
		$pv_day = $json['Body']['Data']['DAY_ENERGY']['Value'];
		$pv_year = $json['Body']['Data']['YEAR_ENERGY']['Value'];

#   =============================================================================
#   2021-04-23 FJMG Second call + second DataCollection
#   ============================================================================

switch ($VersionAPI) {
  case '0':
    $Url = 'http://'.$Fronius_IP.':'.$Fronius_Port.'/solar_api/GetMeterRealtimeData.cgi?Scope=Device&DeviceId=1&DataCollection=CommonInverterData';
    break;

  case '1';
    $Url = 'http://'.$Fronius_IP.':'.$Fronius_Port.'/solar_api/v1/GetMeterRealtimeData.cgi?Scope=Device&DeviceId=1&DataCollection=CommonInverterData';
    break;

  default:
    log::add('fronius', 'error','Error getting inverter API Version: '.curl_error($ch));
    $this->checkAndUpdateCmd('status', 'Version API non supportée');
    return;
}


    // COLLECTING VALUES - GetMeterRealtimeData -> $data2 -> $json2
    curl_setopt($ch, CURLOPT_URL, $Url);
    $data2 = curl_exec($ch);

    if (curl_errno($ch)) {
      curl_close ($ch);
      log::add('fronius', 'error','Error getting meter values: '.curl_error($ch));
      $this->checkAndUpdateCmd('status', 'Erreur Données');
      return;
    }

    $json2 = json_decode($data2, true);

    $consumo = $json2['Body']['Data']['0']['PowerReal_P_Sum']['Value'];
    // $pv_total = $json['Body']['Data']['TOTAL_ENERGY']['Value'];
    // $frequency = $json['Body']['Data']['FAC']['Value'];
    // $voltage_AC = $json['Body']['Data']['UAC']['Value'];
    // $voltage_DC = $json['Body']['Data']['UDC']['Value'];
    // $current_AC = $json['Body']['Data']['IAC']['Value'];
    // $current_DC = $json['Body']['Data']['IDC']['Value'];
    // $pv_day = $json['Body']['Data']['DAY_ENERGY']['Value'];
    // $pv_year = $json['Body']['Data']['YEAR_ENERGY']['Value'];


    // {
    //    "Body" : {
    //       "Data" : {
    //          "0" : {
    //             "Current_AC_Phase_1" : 1.9550000000000001,
    //             "Current_AC_Sum" : 1.9550000000000001,
    //             "Details" : {
    //                "Manufacturer" : "Fronius",
    //                "Model" : "Smart Meter TS 100A-1",
    //                "Serial" : "816710109"
    //             },
    //             "Enable" : 1,
    //             "EnergyReactive_VArAC_Sum_Consumed" : 310012,
    //             "EnergyReactive_VArAC_Sum_Produced" : 64667,
    //             "EnergyReal_WAC_Minus_Absolute" : 739014,
    //             "EnergyReal_WAC_Plus_Absolute" : 1739327,
    //             "EnergyReal_WAC_Sum_Consumed" : 1739327,
    //             "EnergyReal_WAC_Sum_Produced" : 739014,
    //             "Frequency_Phase_Average" : 49.899999999999999,
    //             "Meter_Location_Current" : 0,
    //             "PowerApparent_S_Phase_1" : 366.10000000000002,
    //             "PowerApparent_S_Sum" : 366.10000000000002,
    //             "PowerFactor_Phase_1" : -0.97999999999999998,
    //             "PowerFactor




#   =============================================================================

		if ($pv_power == '') {
			$this->checkAndUpdateCmd('pv_power', 0);
			$this->checkAndUpdateCmd('pv_total', 0);
			$this->checkAndUpdateCmd('frequency', 0);
			$this->checkAndUpdateCmd('voltage_AC', 0);
			$this->checkAndUpdateCmd('voltage_DC', 0);
			$this->checkAndUpdateCmd('current_AC', 0);
			$this->checkAndUpdateCmd('current_DC', 0);
			$this->checkAndUpdateCmd('pv_day', 0);
			$this->checkAndUpdateCmd('pv_year', 0);
			$this->checkAndUpdateCmd('consumo', 0);

			$this->checkAndUpdateCmd('status', 'Hors Ligne ...');
			log::add('fronius', 'debug','Inverter is off-line ...');
			return;
		} else {
			curl_close ($ch);
			$this->checkAndUpdateCmd('pv_power', $pv_power);
			$this->checkAndUpdateCmd('pv_total', $pv_total);
			$this->checkAndUpdateCmd('frequency', $frequency);
			$this->checkAndUpdateCmd('voltage_AC', $voltage_AC);
			$this->checkAndUpdateCmd('voltage_DC', $voltage_DC);
			$this->checkAndUpdateCmd('current_AC', $current_AC);
			$this->checkAndUpdateCmd('current_DC', $current_DC);
			$this->checkAndUpdateCmd('pv_day', $pv_day);
			$this->checkAndUpdateCmd('pv_year', $pv_year);
			$this->checkAndUpdateCmd('consumo', $consumo);

			$this->checkAndUpdateCmd('status', 'OK');
      log::add('fronius', 'debug','All good: Data='.$data);
      log::add('fronius', 'debug','All good 2: Data2='.$data2);
			return;
		}

	}

    /*
     * Non obligatoire mais permet de modifier l'affichage du widget si vous en avez besoin
      public function toHtml($_version = 'dashboard') {

      }
     */

    /*
     * Non obligatoire mais ca permet de déclencher une action après modification de variable de configuration
    public static function postConfig_<Variable>() {
    }
     */

    /*
     * Non obligatoire mais ca permet de déclencher une action avant modification de variable de configuration
    public static function preConfig_<Variable>() {
    }
     */

    /*     * **********************Getteur Setteur*************************** */
}

class froniusCmd extends cmd {
    /*     * *************************Attributs****************************** */


    /*     * ***********************Methode static*************************** */


    /*     * *********************Methode d'instance************************* */

    /*
     * Non obligatoire permet de demander de ne pas supprimer les commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
      public function dontRemoveCmd() {
      return true;
      }
     */

    public function execute($_options = array()) {
				$eqlogic = $this->getEqLogic();
				switch ($this->getLogicalId()) {
					case 'refresh':
						$info = $eqlogic->getFroniusData();
						break;
		}
    }
    /*     * **********************Getteur Setteur*************************** */
}
