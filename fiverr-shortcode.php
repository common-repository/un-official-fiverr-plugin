<?php
// A function which allows you to embed the Fiverr Widget on post or page.
function fiverrWidgetShortcode( $fiverrWidgetOptions )
{
    $fiverrWidgetDefaults = array(
        'username'        => 'guest',
        'user_gigs'       => 5,
        'user_likes'      => 3,
        'widget_height'   => 300,
        'widget_width'    => 500,
        'widget_position' => 'none'
    );
    $finalString = "";
    
    extract( shortcode_atts( $fiverrWidgetDefaults, $fiverrWidgetOptions ) );

    $username        = secureVar( $username            );
    $user_gigs       = secureVar( $user_gigs    , true );
    $user_likes      = secureVar( $user_likes   , true );
    $widget_height   = secureVar( $widget_height, true );
    $widget_width    = secureVar( $widget_width , true );
    $widget_position = secureVar( $widget_position     );
    
    $widget_style = "float: {$widget_position};";
    
    if( $widget_height > 0 )
    {
        $widget_style .= " height: {$widget_height}px;";
    }
    if( $widget_width > 0 )
    {
        $widget_style .= " width: {$widget_width}px;";
    }
    
    $finalString  = "<div style='{$widget_style}'>";
    $finalString .= "  <script type=\"text/javascript\" src=\"http://fiverr.com/widget?username={$username}&type=fv&gigs_count={$user_gigs}&liked_gigs_count={$user_likes}\"></script>";
    $finalString .= "</div>";
    $finalString .= "<div style='clear: both;'></div>";
    
    return $finalString;    
}

// Adding an API call for WordPress to recognaize the shortcode.
add_shortcode( 'fiverr-widget', 'fiverrWidgetShortcode' );
?>