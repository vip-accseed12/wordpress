<?php
/**
 * Plugin Name: My Popup
 * Description: Adds a responsive popup button that opens a WPForms contact form.
 * Version: 1.0.0
 * Author: Custom
 * Text Domain: my-popup
 */

if (! defined('ABSPATH')) {
    exit;
}

final class DT_SS_Popup_Plugin
{
    private static $instance = null;

    public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_shortcode('dt_ss_popup', array($this, 'render_popup_shortcode'));
    }

    public function enqueue_assets()
    {
        $version = '1.0.0';

        wp_register_style(
            'dt-ss-popup-style',
            plugin_dir_url(__FILE__) . 'assets/css/dt-ss-popup.css',
            array(),
            $version
        );

        wp_register_script(
            'dt-ss-popup-script',
            plugin_dir_url(__FILE__) . 'assets/js/dt-ss-popup.js',
            array(),
            $version,
            true
        );
    }

    public function render_popup_shortcode($atts)
    {
        $atts = shortcode_atts(
            array(
                'button_text' => __('Open Contact Form', 'my-popup'),
                'title'       => __('Contact Us', 'my-popup'),
            ),
            $atts,
            'dt_ss_popup'
        );

        wp_enqueue_style('dt-ss-popup-style');
        wp_enqueue_script('dt-ss-popup-script');

        $instance_id = wp_unique_id('dt-ss-popup-');

        ob_start();
        ?>
        <div class="dt-ss-popup-wrap" id="<?php echo esc_attr($instance_id); ?>">
            <button type="button" class="dt-ss-popup-open" data-dt-ss-popup-open>
                <?php echo esc_html($atts['button_text']); ?>
            </button>

            <div class="dt-ss-popup-overlay" data-dt-ss-popup-overlay hidden>
                <div class="dt-ss-popup-modal" role="dialog" aria-modal="true" aria-labelledby="<?php echo esc_attr($instance_id); ?>-title">
                    <button type="button" class="dt-ss-popup-close" aria-label="<?php esc_attr_e('Close popup', 'my-popup'); ?>" data-dt-ss-popup-close>
                        &times;
                    </button>
                    <h3 class="dt-ss-popup-title" id="<?php echo esc_attr($instance_id); ?>-title"><?php echo esc_html($atts['title']); ?></h3>
                    <div class="dt-ss-popup-form">
                        <?php echo do_shortcode('[wpforms id="3989"]'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                </div>
            </div>
        </div>
        <?php

        return ob_get_clean();
    }
}

DT_SS_Popup_Plugin::instance();
