<?php
/**
 * @package wao.io
 * @author  Avenga Germany GmbH
 * @version 1.0.2
 *
 * @wordpress-plugin
 * Plugin Name: wao.io
 * Text Domain: wao-io
 * Plugin URI: https://wao.io
 * Description: wao.io is a cloud service that optimizes your website's speed and security automatically.
 * Author: Avenga Germany GmbH
 * Version: 1.0.2
 * Author URI: https://avenga.com
 * Requires at least: 4.6
 * Requires PHP: 5.6
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// das root-verzeichnis des plugins global festlegen
define( 'WAO__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
// der pfad zur index.html
define( 'WAO__INDEX_PATH', 'index.php');

// das grundsaetzliche setup, plain alle "meta" daten fuer den plugin-content
function wao_menu_setup() {
  // titel im tab oben
  $WAO_page_title = 'wao.io Plugin';
  // titel im menu links
  $WAO_menu_title = 'wao.io';
  // zugriff nur wenn man die optionen managt?
  $WAO_capability = 'manage_options';
  // der slug ist zu finden in der adressleiste, ?page=wao.io
  $WAO_slug = 'wao.io';
  // funktion die aufgerufen wird sobald die seite geöffnet wird
  $WAO_opening_callback = 'wao_init';
  // unser icon als base64 input
  $WAO_icon = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI0LjAuMiwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkViZW5lXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCA3OS42IDQ2LjMiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDc5LjYgNDYuMzsiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8c3R5bGUgdHlwZT0idGV4dC9jc3MiPgoJLnN0MHtmaWxsLXJ1bGU6ZXZlbm9kZDtjbGlwLXJ1bGU6ZXZlbm9kZDtmaWxsOiMwMEE1QjY7fQoJLnN0MXtmaWxsLXJ1bGU6ZXZlbm9kZDtjbGlwLXJ1bGU6ZXZlbm9kZDtmaWxsOiMwMERBQzY7fQoJLnN0MntmaWxsLXJ1bGU6ZXZlbm9kZDtjbGlwLXJ1bGU6ZXZlbm9kZDtmaWxsOiMwMEMzQzM7fQoJLnN0M3tmaWxsLXJ1bGU6ZXZlbm9kZDtjbGlwLXJ1bGU6ZXZlbm9kZDtmaWxsOiM0REVERDg7fQoJLnN0NHtmaWxsLXJ1bGU6ZXZlbm9kZDtjbGlwLXJ1bGU6ZXZlbm9kZDtmaWxsOiMwMDk2QUY7fQoJLnN0NXtmaWxsLXJ1bGU6ZXZlbm9kZDtjbGlwLXJ1bGU6ZXZlbm9kZDtmaWxsOiMwMENGQzU7fQoJLnN0NntmaWxsLXJ1bGU6ZXZlbm9kZDtjbGlwLXJ1bGU6ZXZlbm9kZDtmaWxsOiMwMEI0QkM7fQoJLnN0N3tmaWxsLXJ1bGU6ZXZlbm9kZDtjbGlwLXJ1bGU6ZXZlbm9kZDtmaWxsOiMwMEU2Qzg7fQo8L3N0eWxlPgo8dGl0bGU+d2FvLmlvIGxvZ28gaW4gY29sb3I8L3RpdGxlPgo8Zz4KCTxnPgoJCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0xOS45LDQ2LjNWMjMuMkwwLDM0LjhMMTkuOSw0Ni4zeiIvPgoJCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik01OS43LDQ2LjNWMjMuMkwzOS44LDM0LjhMNTkuNyw0Ni4zeiIvPgoJCTxwYXRoIGNsYXNzPSJzdDIiIGQ9Ik0zOS44LDM0LjhWMTEuN0wxOS45LDIzLjJMMzkuOCwzNC44eiIvPgoJCTxwYXRoIGNsYXNzPSJzdDMiIGQ9Ik03OS41LDM0LjhWMTEuN0w1OS43LDIzLjJMNzkuNSwzNC44eiIvPgoJCTxwYXRoIGNsYXNzPSJzdDQiIGQ9Ik0wLDExLjd2MjMuMWwxOS45LTExLjVMMCwxMS43eiIvPgoJCTxwYXRoIGNsYXNzPSJzdDUiIGQ9Ik0zOS44LDExLjd2MjMuMWwxOS45LTExLjVMMzkuOCwxMS43eiIvPgoJCTxwYXRoIGNsYXNzPSJzdDYiIGQ9Ik0xOS45LDIzLjJ2MjMuMWwxOS45LTExLjVMMTkuOSwyMy4yeiIvPgoJCTxwYXRoIGNsYXNzPSJzdDciIGQ9Ik01OS43LDIzLjJ2MjMuMWwxOS45LTExLjVMNTkuNywyMy4yeiIvPgoJCTxwYXRoIGNsYXNzPSJzdDQiIGQ9Ik01OS43LDB2NC42bDQtMi4zTDU5LjcsMHoiLz4KCQk8cGF0aCBjbGFzcz0ic3QyIiBkPSJNNTkuNyw3LjR2OC4zbDcuMS00LjFMNTkuNyw3LjR6Ii8+CgkJPHBhdGggY2xhc3M9InN0NSIgZD0iTTY4LjgsNS4zdjEyLjVsMTAuOC02LjNMNjguOCw1LjN6Ii8+Cgk8L2c+CjwvZz4KPC9zdmc+Cg==';

  // hinzufuegen der seite mit den soeben festgelegten konfigurationen
  add_menu_page(
    $WAO_page_title,
    $WAO_menu_title,
    $WAO_capability,
    $WAO_slug,
    $WAO_opening_callback,
    $WAO_icon
  );
}

// init funktion
function wao_init() {
  // die seite wird geladen beim öffnen des plugins
  require_once(WAO__PLUGIN_DIR . WAO__INDEX_PATH);
}

// für den activated-hook registrieren
add_action('admin_menu', 'wao_menu_setup');