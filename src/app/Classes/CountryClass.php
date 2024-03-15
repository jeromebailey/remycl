<?php 

namespace App\Classes;

class CountryClass {

    public function getCountryList() {
        $country = array(
            "KY" => "Cayman Islands",
            "CA" => "Canada",
            "GB" => "United Kingdom",
            "US" => "USA",
            "00" => "---------------",
            "AF" => "Afghanistan",
            "AX" => "Åland Islands",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua and Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria"
        );
        return $country;
    }
}