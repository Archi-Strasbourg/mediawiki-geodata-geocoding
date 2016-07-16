<?php
namespace GeoData;

use Opendi\Nominatim\Nominatim;

class GeoCoding
{

    public static function geocode($parser, $address, $city, $country)
    {
        global $wgTitle;
        $nominatim = Nominatim::newInstance('https://nominatim.openstreetmap.org/');
        $search = $nominatim->newSearch();
        $address = str_replace("l' ", "l'", $address);
        $address = str_replace("d' ", "d'", $address);
        $search->street($address)->city($city)->country($country);
        $results = $nominatim->find($search);
        return $parser->internalParse('{{#coordinates:'.$results[0]['lat'].'|'.$results[0]['lon'].'}}');
    }

    public static function onParserSetup(&$parser)
    {
        $parser->setFunctionHook('geocoding', 'GeoData\GeoCoding::geocode');
    }
}
