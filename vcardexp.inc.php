<?php
	class vcardexp
	/* Bibliothek zur Genegierung von digitalen Visitenkarten */
	{
	
		//Deklarationen
		var $fields = array();
		
		var $allowed = array(
			"language",
			"firstName", "additionalName", "lastName", "title", "addon", "organisation", "note",
			"tel_work", "tel_home", "tel_cell", "tel_car", "tel_isdn", "tel_pref", "fax_work", "fax_home",
			"street_work", "city_work", "postal_work", "country_work", "street_home", "city_home", "postal_home", "country_home",
			"url", "email_internet", "email_pref", "picture"
		);
		
		
		
		function setValue($setting, $value)
		/* Wert eintragen */
		{
		
			//Ist die Einstellung in der Liste erlaubter Einstellungen?
			if(in_array($setting, $this->allowed))
			{
				//Ja, setze Einstellung und Wert
				$this->fields[$setting] = $value;
				return true;
			}
			else
			{
				//Nein
				return false;
			}
		
		}
		
		
		
		function copyPicture($path)
		/* Foto-Import */
		{
			//Ist die Datei vorhanden?
			if(is_file($path))
			{
				//Ja, beziehe die Bildgroesse
				$temp = getimagesize($path);
				
				//Ist das Bild nicht groesser als 185x185?
				if($temp[0] <= 150000 && $temp[1] <= 200000)
				{
					//Ja, berechne base64-Code und setze
					$this->fields["picture"] = base64_encode(file_get_contents ($path));
					return true;
				}
				else
				{
					//Nein, es ist zu gross
					return false;
				}
			}
			else
			{
				//Nein, Datei ist nicht vorhanden
				return false;
			}
		}
		
		
		
		function setPicture($value)
		/* Bild direkt als BASE64-Code setzen, NOT RECOMMENDED */
		{
			$this->fields["picture"] = $value;
			return true;
		}
		
		
		
		function dump()
		/* Dump ausgeben */
		{
		
			echo "<pre>";
			print_r($this->fields);
			echo "</pre>";
			return true;
		
		}
		
		
		
		function getCard()
		/* Visitenkarte generieren */
		{
		
			//Header ausgeben
			header('Content-Type: text/x-vcard');
			
			$card  = "BEGIN:VCARD\n";
			$card .= "VERSION:2.1\n";
			
			//Sprache und Vor- und Nachname setzen
			if($this->fields["language"] == "") { $this->fields["language"] = "de"; }
			$card .= "N;LANGUAGE=".$this->fields["language"].":".$this->fields["lastName"].";".$this->fields["firstName"]."\n";
			
			//Anzeigenamen setzen
			$card .= "FN:".$this->fields["firstName"]." ".$this->fields["lastName"]."\n";
			
			//Firma und Titel setzen, falls vorhanden
			if(isset($this->fields["organisation"]))
			{
				$card .= "ORG:".$this->fields["organisation"]."\n";
			}
			if(isset($this->fields["title"]))
			{
				$card .= "TITLE:".$this->fields["title"]."\n";
			}
			
			//zw  vn nicht gesetzt
			//zusatz nicht gesetzt
			//note nicht gesetzt
			//nur eine home tel
			//nur zwei mails
			//bug isset ==> array mit erlaubten feldern
			//Check fields
			
			//Telefon- und Faxnummern setzen
			
				if(isset($this->fields["tel_work"])) { $card .= "TEL;WORK;VOICE:".$this->fields["tel_work"]."\n"; }	//Arbeit
				if(isset($this->fields["tel_home"])) { $card .= "TEL;HOME;VOICE:".$this->fields["tel_home"]."\n"; }	//Privat
				if(isset($this->fields["tel_cell"])) { $card .= "TEL;CELL;VOICE:".$this->fields["tel_cell"]."\n"; }		//Handy
				if(isset($this->fields["tel_car"])) { $card .= "TEL;CAR;VOICE:".$this->fields["tel_car"]."\n"; }		//Autotelefon
				if(isset($this->fields["fax_work"])) { $card .= "TEL;WORK;FAX:".$this->fields["fax_work"]."\n"; }	//Fax-Arbeit
				if(isset($this->fields["fax_home"])) { $card .= "TEL;HOME;FAX:".$this->fields["fax_home"]."\n"; }	//Fax-Privat
				if(isset($this->fields["tel_home"])) { $card .= "TEL;HOME:".$this->fields["tel_home"]."\n"; }		//Privat, Kopie von obriger Angabe
				if(isset($this->fields["tel_isdn"])) { $card .= "TEL;ISDN:".$this->fields["tel_isdn"]."\n"; }			//ISDN
				if(isset($this->fields["tel_pref"])) { $card .= "TEL;PREF:".$this->fields["tel_pref"]."\n"; }			//Standard-Nummer
			
			
			
			//Adressen setzen
			
				//Arbeit
				if(isset($this->fields["street_work"]) && isset($this->fields["city_work"]) && isset($this->fields["postal_work"]) && isset($this->fields["country_work"]))
				{
					$card .= "ADR;WORK;PREF:;;".$this->fields["street_work"].";".$this->fields["city_work"].";;".$this->fields["postal_work"].";".$this->fields["country_work"]."\n";
					$card .= "LABEL;WORK;PREF;ENCODING=QUOTED-PRINTABLE:".$this->fields["street_work"]."=0D=0A=\n";
					$card .= "=0D=0A=\n";
					$card .= $this->fields["postal_work"]." ".$this->fields["city_work"]."\n";
				}
				
				//Privat
				if(isset($this->fields["street_home"]) && isset($this->fields["city_home"]) && isset($this->fields["postal_home"]) && isset($this->fields["country_home"]))
				{
					$card .= "ADR;HOME;PREF:;;".$this->fields["street_home"].";".$this->fields["city_home"].";;".$this->fields["postal_home"].";".$this->fields["country_home"]."\n";
					$card .= "LABEL;HOME;PREF;ENCODING=QUOTED-PRINTABLE:".$this->fields["street_home"]."=0D=0A=\n";
					$card .= "=0D=0A=\n";
					$card .= $this->fields["postal_home"]." ".$this->fields["city_home"]."\n";
				}
			
			
			
			//URL und E-Mails setzen
			
				if(isset($this->fields["url"])) { $card .= "URL;WORK:".$this->fields["url"]."\n"; }						//Homepage setzen
				if(isset($this->fields["email_pref"])) { $card .= "EMAIL;PREF;INTERNET:".$this->fields["email_pref"]."\n"; }		//Standard-Mail
				if(isset($this->fields["email_internet"])) { $card .= "EMAIL;INTERNET:".$this->fields["email_internet"]."\n"; }		//Zusatz-Mail
			
			
			
			//Foto hinzufuegen, falls vorhanden
			if(isset($this->fields["picture"]))
			{
				$card .= "PHOTO;TYPE=JPEG;ENCODING=BASE64:\n";
				$card .= $this->fields["picture"];
				$card .= "\n\n\n";
			}
			
			//TODO: REV?
			
			//Ende setzen
			$card .= "END:VCARD";
			
			//Karte ausgeben und String loeschen
			echo $card;
			$card = "";
		
		}
	
	}

?>