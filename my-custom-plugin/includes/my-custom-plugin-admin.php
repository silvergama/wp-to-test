<?php

if ( ! class_exists( 'MyCustomPluginAdmin' ) ) {

    class MyCustomPluginAdmin
    {
        private $options;
        private $plugin_basename;
        private $plugin_slug;
        private $json_filename;
        private $plugin_version;

        public function __construct($basename, $slug, $json_filename, $version) 
        {
            $this->options = get_option( 'mcp' );
            $this->plugin_basename = $basename;
            $this->plugin_slug = $slug;
            $this->json_filename = $json_filename;
            $this->plugin_version = $version;

            add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
            add_action( 'admin_init', array( $this, 'page_init' ) );
            add_action( 'admin_footer_text', array( $this, 'page_footer' ) );
            add_action( 'admin_notices', array( $this, 'show_notices' ) );
            add_filter( 'plugin_action_links_' . $this->plugin_basename, array( $this, 'add_settings_link' ) );
        }

        public function add_plugin_page ()
        {
            add_options_page(
                __('Settings', 'my-custom-plugin'),
                __('My Custom Plugin', 'my-custom-plugin'),
                'manage_options',
                $this->plugin_slug,
                [
                    $this, 
                    'create_admin_page'
                ]
            );
         }

        public function create_admin_page ()
        {
            ?>
                <div class="wrap">
                <h1><?php echo __( 'My Custom Plugin', 'my-custom-plugin' ); ?> </h1>
                    <form method="post" action="options.php">
                    <?php
                        settings_fields( 'mcp_options' );
                        do_settings_sections( 'mcp_admin' );
                        submit_button();
                    ?>
                    </form>
                </div>
            <?php
        }
       
        public function page_footer()
        {
            return __( 'Plugin Version', 'my-custom-plugin' ) .' '. $this->plugin_version;
        }

        public function show_notices ()
        {
            echo 'show notices';
        }

        public function add_settings_link ( $links )
        {
            $settings_link = '<a href="options-general.php?page='. $this->plugin_slug .'">' . __( 'Settings', 'my-custom-plugin') . '</a>';
            array_unshift( $links, $settings_link);
            return $links;
        } 

        public function page_init()
        {
            register_setting(
                'mcp_options', // option group
                'mcp', // option name
                [
                    $this, 
                    'sanitize'
                ] // sanitize
            );

            add_settings_section (
                'settings_section_id_1', // ID
                __( 'General Settings', 'my-custom-plugin' ), // Title
                null, // Callback
                'mcp_admin' // Page
            );

            add_settings_field (
                'channel_id', // ID
                __( 'Channel ID', 'my-custom-plugin' ), // Title
                array( $this, 'channel_id_callback' ), // Callback
                'mcp_admin', // Page
                'settings_section_id_1', // Section
                [
                    'label_for' => 'channel_id',
                ] // Arguments
            );

            add_settings_field (
                'cache_expiration', // ID
                __( 'Cache Expiration', 'my-custom-plugin' ), // Title
                array( $this, 'cache_expiration_callback' ), // Callback
                'mcp_admin', // Page
                'settings_section_id_1', // Section
                [
                    'label_for' => 'cache_id'
                ] // Arguments
            );
        }

        public function channel_id_callback ($args)
        {
            $value = isset( $this->options['channel_id'] ) ? esc_attr( $this->options['channel_id'] ) : '';
            $label_for = esc_attr( $args['label_for'] );
            ?>
                <input 
                    type="text" 
                    id="<?php echo $label_for ?>" 
                    name="mcp[<?php echo $label_for ?>]" 
                    value="<?php echo $value ?>" 
                    class="regular-text"
                />
                <p class="description"><?php echo __('sample', 'my-custom-plugin') ?>: IAUSDFIAUasdjhbf oaisgdoiu</p>
            <?php 
        }

        public function cache_expiration_callback ( $args )
        {
            echo "jasdfo iuahds ofiuhasd";
        }

        public function sanitize ( $input )
        {
            return $input;
        }

    }

}
