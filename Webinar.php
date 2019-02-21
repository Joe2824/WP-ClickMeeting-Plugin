<?php
/*
Plugin Name: WP ClickMeeting
Plugin URI: https://joelklein.de
Description: Plugin to show ClickMeeting listings. [clickmeeting]
Author: Joel Klein
Author URI: https://joelklein.de
Version: 1.0

/* Verbiete den direkten Zugriff auf die Plugin-Datei */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


require_once 'includes/ClickMeetingRestClient.php';

// Ausgabe für Webinar Seite

//

function clickmeeting(  $atts, $gh=null ) {

    $client = new ClickMeetingRestClient(array('api_key' => 'xxxxxxxxxxxxxxxx'));

    $conferences = $client->conferences('active');


    // Kein Webinar
    if ( empty($conferences) )
        return "<h3 class=\"no_stripe\">" . __("Aktuell bieten wir keine Webinare an.") . "</h3";
        
    $output.= "<div class=\"vc_row wpb_row vc_row-fluid vc_row-o-equal-height vc_row-o-content-middle vc_row-flex\">";
    // Alle Webinare anzeigen
    foreach( $conferences as $index => $item ) {

    $output.= "<h3>{$item->name}</h3>";
    $output.= "<p>{$item->lobby_description}</p>";
    $output.= date_format(date_create($item->starts_at), "d.m.Y | G:i");
    $output.= " Uhr | Dauer: ca. ";
    
    //Subtrahiere die Endzeit von der Startzeit und Teile durch 60 um den Wert in Minuten zu bekommen
    $dauerInMinuten = (strtotime($item->ends_at) - strtotime($item->starts_at))/60;
    $output.= $dauerInMinuten;
    $output.= " min |";
    $output.= "<form style=\"display:inline;\" method=\"post\" action=\"https://faros-consulting.de/veranstaltungen/webinar-anmeldung\">
               <input type=\"hidden\" name=\"seminar\" value=\"{$item->name}\">
               <input type=\"hidden\" name=\"link_seminar\" value=\"{$item->room_url}\">
               <input type=\"hidden\" name=\"seminar_start\" value=\"{$item->starts_at}\">
               <a href=\"#\" onclick=\"this.parentNode.submit();\">Anmelden</a>
               </form>";
        
    
    $date_day.= date_format(date_create($item->starts_at), "d.m.Y");
    $date_time.= date_format(date_create($item->starts_at), "G:i");
    $output.= "<a href=\"https://URL/?seminar={$item->name}&amp;seminar_day={$date_day}&amp;seminar_time={$date_time}\">Anmelden</a>";
    
    $output.= "</div>
               </div>
               </div>
               </div>
               </div>";


    $output.= "<a href=\"{$item->room_url}\" target=\"_blank\">zum Webinar</a>";

    $output.= "</div>
               </div>
               </div>
               </div>
               ";
    }
    
     return $output;

}
add_shortcode( 'clickmeeting', 'clickmeeting' );

/* Nach dieser Zeile KEINEN Code mehr einfügen*/
?>
