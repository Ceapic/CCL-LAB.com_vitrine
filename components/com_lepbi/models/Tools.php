<?php

class Tools {

    static function getUserJoomla($id_user) {
        $db = $GLOBALS['DB_JML'];
        $query = "SELECT * FROM 
			jml_users
			WHERE id = " . $id_user;

        $db->setQuery($query);
        return $db->loadObject();
    }

    static function getAgenceUser($id_user) {
        $user = self::getUserJoomla($id_user);
        return $user->agence;
    }

    /**
     * Function qui permet de transformer un chiffre en lettre
     * Meme fonctionnement que EXCEL 0=>A 26=>AA 27=>AB 
     *
     * @param [type] $number 0 26 27
     * @return String => lettre A AA AB
     */
    static function convertToExcelColumn($number) {
        $column = '';
        $base = ord('A');
        $range = 26; // Nombre de lettres de l'alphabet

        while ($number >= 0) {
            $remainder = $number % $range;
            $column = chr($base + $remainder) . $column;
            $number = floor(($number - $remainder) / $range) - 1;
        }

        return $column;
    }

    static function recursiveUrlDecode(&$array) {
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                Tools::recursiveUrlDecode($value);
            } else {
                $array[$key] = urldecode($value);
            }
        }
    }

    static function troncature($nombre, $nombreChiffreApresVirgule) {
        $chiffreApresVirgule = "1";
        if ($nombreChiffreApresVirgule > 1) {
            for ($i = 0; $i < $nombreChiffreApresVirgule; $i++) {
                $chiffreApresVirgule .= "0";
            }
        }
        $multi = intval($chiffreApresVirgule);
        $nombre = intval($nombre * $multi) / $multi;
        return $nombre;
    }

    /**
     * Fonction qui transforme une date string au format yyyy/mm/dd hh:mm:ss au format d'affichage utilisateur dd/mm/yyyy hh:mm
     *
     * @param [type] $dateStr
     * @return void
     */
    static function formatageDatePourAffichage($dateString) {
        $dateTime = new DateTime($dateString);

        // Formater la date dans le format "dd/mm/yyyy hh:mm"
        $formattedDate = $dateTime->format('d/m/Y H:i');
        return $formattedDate;
    }

    /**
     * Fonction qui transforme une date string au format dd/mm/yyyy hh:mm en string au format yyyy-mm-dd hh:mm
     * Permet de créer une date avec la méthode php strtotime de cette valeur retourné
     *
     * @param [type] $dateInit string au format dd/mm/yyyy hh:mm
     * @return String Date au format yyyy-mm-dd hh:mm
     */
    static function formatageDatePourBase($dateInit) {
        $res = "";
        // Divisez la chaîne en composants
        $composants = explode(' ', $dateInit);
        $dateComponents = explode('/', $composants[0]);
        $timeComponents = explode(':', $composants[1]);

        if (count($dateComponents) === 3 && count($timeComponents) === 2) {
            list($jour, $mois, $annee) = $dateComponents;
            list($heure, $minute) = $timeComponents;

            $res = "$annee-$mois-$jour $heure:$minute";
        }
        return $res;
    }

    /**
     * Methode qui retourne une fraction
     *
     * @param [float] $decimal La décimal à convertir
     */
    static function decimalToFraction($decimal) {
        $precision = 1000000; // Augmente la précision si nécessaire
        $numerator = $decimal * $precision;
        $gcd = self::findGCD($numerator, $precision);
        $numerator /= $gcd;
        $denominator = $precision / $gcd;

        return $numerator . "/" . $denominator;
    }

    // Methode qui retourne le PGCD (Plus Grand Commun Diviseur)
    static function findGCD($a, $b) {
        while ($b != 0) {
            $temp = $b;
            $b = $a % $b;
            $a = $temp;
        }
        return abs($a);
    }

    static function snakeToCamel($input) {
        $words = explode('_', $input);
        $camelCase = $words[0];

        for ($i = 1; $i < count($words); $i++) {
            $camelCase .= ucfirst($words[$i]);
        }

        return $camelCase;
    }

    static function encode($texte) {
        return htmlspecialchars(utf8_encode($texte));
    }

    static function replaceCaracteres($texte) {

        // é => {e_aigu}
        // è => {e_grave}
        // ê => {e_circonflexe}
        // à => {a_grave}
        // â => {a_circonflexe}
        // î => {i_circonflexe}
        // ô => {o_circonflexe}
        // û => {u_circonflexe}
        // ç => {c_cedille}
        // ë => {e_tréma}
        // ï => {i_tréma}
        // ü => {u_tréma}
        // ÿ => {y_tréma}
        // œ => {oe_ligature}
        // >= => {gt}

        $texte = str_replace("é", "{e_aigu}", $texte);
        $texte = str_replace("è", "{e_grave}", $texte);
        $texte = str_replace("ê", "{e_circonflexe}", $texte);
        $texte = str_replace("à", "{a_grave}", $texte);
        $texte = str_replace("â", "{a_circonflexe}", $texte);
        $texte = str_replace("î", "{i_circonflexe}", $texte);
        $texte = str_replace("ô", "{o_circonflexe}", $texte);
        $texte = str_replace("û", "{u_circonflexe}", $texte);
        $texte = str_replace("ç", "{c_cedille}", $texte);
        $texte = str_replace("ë", "{e_trema}", $texte);
        $texte = str_replace("ï", "{i_trema}", $texte);
        $texte = str_replace("ü", "{u_trema}", $texte);
        $texte = str_replace("ÿ", "{y_trema}", $texte);
        $texte = str_replace("œ", "{oe_ligature}", $texte);

        return $texte;
    }


    static function decodeCaracteres($texte) {
        $texte = str_replace("{e_aigu}", "é", $texte);
        $texte = str_replace("{e_grave}", "è", $texte);
        $texte = str_replace("{e_circonflexe}", "ê", $texte);
        $texte = str_replace("{a_grave}", "à", $texte);
        $texte = str_replace("{a_circonflexe}", "â", $texte);
        $texte = str_replace("{i_circonflexe}", "î", $texte);
        $texte = str_replace("{o_circonflexe}", "ô", $texte);
        $texte = str_replace("{u_circonflexe}", "û", $texte);
        $texte = str_replace("{c_cedille}", "ç", $texte);
        $texte = str_replace("{e_trema}", "ë", $texte);
        $texte = str_replace("{i_trema}", "ï", $texte);
        $texte = str_replace("{u_trema}", "ü", $texte);
        $texte = str_replace("{y_trema}", "ÿ", $texte);
        $texte = str_replace("{oe_ligature}", "œ", $texte);

        return $texte;
    }


    static function tableauToStringBase($tab) {
        $res = "";
        foreach ($tab as $key => $value) {
            $res .= $key . " : " . $value . "\n";
        }
        return $res;
    }
}
