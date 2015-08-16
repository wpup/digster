<?php

namespace Digster\Cache;

use Asm89\Twig\CacheExtension\CacheProviderInterface;

class WordPress_Cache_Adapter implements CacheProviderInterface  {

    /**
     * The group key.
     *
     * @var string
     */
    private $group;

    /**
     * The key prefix.
     *
     * @var string
     */
    private $key_prefix;

    /**
     * Constructor.
     *
     * @param string $key_prefix
     * @param string $group
     */
    public function __construct( $key_prefix = '', $group = '' ) {
        $this->key_prefix = $key_prefix;
        $this->group = $group;

        if ( function_exists( 'wp_cache_add_global_groups' ) ) {
            wp_cache_add_global_groups( [$group] );
        }
    }

    /**
     * Fetch cache data.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function fetch( $key ) {
        $key = $this->get_key( $key );
        return wp_cache_get( $key, $this->group );
    }

    /**
     * Get key with key prefix.
     *
     * @param string
     *
     * @return string
     */
    private function get_key( $key ) {
        return $this->key_prefix . $key;
    }

    /**
     * Save cache data.
     *
     * @param string $key
     * @param mixed $value
     * @param int $expire
     */
    public function save( $key, $value, $expire = 0 ) {
        $key = $this->get_key( $key );
        wp_cache_set( $key, $value, $this->group, $expire );
    }

}
