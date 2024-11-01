<?php
/*
Plugin Name: Un-Official Fiverr Plugin
Plugin URI: http://www.zuberi.me/wordpress-plugins
Description: An un-official <a href="http://fiverr.com">Fiverr</a> plugin which allows you to embed your Fiverr Widget on Wordpress via PHP Function (theme), WordPress Shortcode (post / page) and WordPress Widget (sidebar).
Version: 1.0
Author: Dor Zuberi (DorZki)
Author URI: http://www.zuberi.me
License: GPL2
*/

/*  Copyright (C) 2011 Dor Zuberi (email : dor@zuberi.me)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// A simple function to secure the variable, so there will be no XSS and SQL Injections.
function secureVar( $varValue, $isInteger = false )
{
    if( $isInteger )
    {
        $securedVar = intval( $varValue );
    }else{
        $securedVar = strip_tags( stripslashes( mysql_escape_string( $varValue ) ) );
    }
    
    return $securedVar;
}

// A theme function the user can use in order to embed the Fiverr Widget in the theme. 
function fiverrWidgetTheme( $fiverrUsername = 'guest', $fiverrUserGigs = 5, $fiverrUserLikes = 3, $fiverrWidgetWidth = 300, $fiverrWidgetHeight = 500, $fiverrWidgetPosition = 'none' )
{
    $fiverr['username']        = secureVar( $fiverrUsername           );
    $fiverr['user_gigs']       = secureVar( $fiverrUserGigs    , true );
    $fiverr['user_likes']      = secureVar( $fiverrUserLikes   , true );
    $fiverr['widget_height']   = secureVar( $fiverrWidgetHeight, true );
    $fiverr['widget_width']    = secureVar( $fiverrWidgetWidth , true );
    $fiverr['widget_position'] = secureVar( $fiverrWidgetPosition     );
    
    $widgetStyle = "float: {$fiverr['widget_position']};";
    
    if( $fiverr['widget_height'] > 0 )
    {
        $widgetStyle .= " height: {$fiverr['widget_height']}px;";
    }
    if( $fiverr['widget_width'] > 0 )
    {
        $widgetStyle .= " width: {$fiverr['widget_width']}px;";
    }
    
    echo "<div style='{$widgetStyle}'>";
    echo "  <script type=\"text/javascript\" src=\"http://fiverr.com/widget?username={$fiverr['username']}&type=fv&gigs_count={$fiverr['user_gigs']}&liked_gigs_count={$fiverr['user_likes']}\"></script>";
    echo "</div>";
    echo "<div style='clear: both;'></div>";
}

// Extentions of the plugin.
@include_once( 'fiverr-shortcode.php' );
@include_once( 'fiverr-widget.php'    );
?>