<?php
namespace WP_Rocket\Tests\Integration\Subscriber\CDN\RocketCDNSubscriber;

use WP_Rocket\Subscriber\CDN\RocketCDNSubscriber;
use WP_Rocket\Admin\Options;
use WP_Rocket\Admin\Options_Data;

class TestDisable extends \WP_UnitTestCase {
    public function testWPRocketOptionsUpdated() {
        $request = new \WP_Rest_Request( 'PUT', '/wp-rocket/v1/rocketcdn/disable' );

        $options_api = new Options( 'wp_rocket_' );
        $options     = new Options_Data( $options_api->get( 'settings' ) );
        $rocketcdn   = new RocketCDNSubscriber( $options_api, $options );
        $rocketcdn->disable( $request );

        $wp_rocket_settings = get_option( 'wp_rocket_settings' );

        $this->assertSame(
            0,
            $wp_rocket_settings['cdn']
        );

        $this->assertEmpty(
            $wp_rocket_settings['cdn_cnames']
        );

        $this->assertEmpty(
            $wp_rocket_settings['cdn_zone']
        );
    }
}