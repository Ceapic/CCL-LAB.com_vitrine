/**
 * Classe Tools - Fonctions et méthodes utilitaires accessibles partout dans le projet
 */
class Tools {


}

function genereUrl(urlBack, option, nomTache, params, token, format) {

    let url = urlBack + "/index.php?option=" + option + "&task=" + nomTache + "&token=" + token + "&format=" + format;

    return url;
}