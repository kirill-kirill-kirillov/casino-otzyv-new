<?php

class SiteOptions {
    private $logo;
    private $menu;
    private $paged;

    public function __construct() {
        $this->set_fields();
    }

    public function get_field( $field_name ) {
        return $this->$field_name;
    }

    private function set_fields() {
        $this->logo = get_field( 'logo', 'option' ) ? esc_url( get_field( 'logo', 'option' ) ) : '';
        $this->menu = get_field( 'menu', 'option' ) ? get_field( 'menu', 'option' ) : '';

        if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); }
        elseif ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); }
        else { $paged = 1; }
        $this->paged = $paged;
    }

    public function get_current_url_without_page_num() {
        $request_url = preg_replace( '/\/page\/\d/i', '', $_SERVER["REQUEST_URI"] );

        return $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["HTTP_HOST"] . $request_url;
    }
}