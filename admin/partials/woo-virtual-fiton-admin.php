<div class="<?=$this->plugin_name?>_container">
<h1><?=$this->plugin_public_name?></h1>
<span class="help-text">Version <?=$this->version?></span>
<hr>

<form method="post" action="options.php">
    <?php settings_fields( $this->plugin_name ); ?>
    <?php do_settings_sections( $this->plugin_name ); ?>
    <table class="form-table">

        <tr valign="top">
            <td>
                <?php 
                $this->show_setting_input('checkbox', $this->plugin_name . '_shop_page_active', $this->plugin_name . '_shop_page_active', [], $this->plugin_config['shop_page_active']);
                ?>
            </td>
            <td>
                <?=__( 'Shop page integration', $this->plugin_name )?><span class="help-text">native WooCommerce based integration on the top of shop archive page. recommended to keep disabled if you use shortcodes in the same template.</span>
            </td>
        </tr>

        <tr valign="top">
            <td>
                <?php 
                $this->show_setting_input('checkbox', $this->plugin_name . '_shop_loop_active', $this->plugin_name . '_shop_loop_active', [], $this->plugin_config['shop_loop_active']);
                ?>
            </td>
            <td>
                <?=__( 'Shop loop integration', $this->plugin_name )?><span class="help-text">native WooCommerce based integration on the shop archive page inside products loop. recommended to keep disabled if you use shortcodes in the same template.</span>
            </td>
        </tr>

        <tr valign="top">
            <td>
                <?php 
                $this->show_setting_input('checkbox', $this->plugin_name . '_single_product_active', $this->plugin_name . '_single_product_active', [], $this->plugin_config['single_product_active']);
                ?>
            </td>
            <td>
                <?=__( 'Single product integration', $this->plugin_name )?><span class="help-text">native WooCommerce based integration on the single product page. recommended to keep disabled if you use shortcodes in the same template.</span>
            </td>
        </tr>

        <tr valign="top">
            <td>
                <?php 
                $this->show_setting_input('checkbox', $this->plugin_name . '_shortcodes_active', $this->plugin_name . '_shortcodes_active', [], $this->plugin_config['shortcodes_active']);
                ?>
            </td>
            <td>
                <?=__( 'Shortcodes', $this->plugin_name )?><span class="help-text">available shortcode : [woo_vfiton_product_page], [woo_vfiton_shop_page], [woo_vfiton_shop_loop]</span>
            </td>
        </tr>

        <tr valign="top">
            <td>
                <?php 
                $this->show_setting_input('checkbox', $this->plugin_name . '_caching_active', $this->plugin_name . '_caching_active', [], $this->plugin_config['caching_active']);
                ?>
            </td>
            <td>
                <?=__( 'JS/CSS Caching', $this->plugin_name )?><span class="help-text">if you are making changes to the plugin css or javasript, disabling caching will help reflect changes rapidly. recommended to keep enabled on production sites.</span>
            </td>
        </tr>

        <tr valign="top">
            <td>
                <?php 
                $this->show_setting_input('checkbox', $this->plugin_name . '_disable_single_zoom', $this->plugin_name . '_disable_single_zoom', [], $this->plugin_config['disable_single_zoom']);
                ?>
            </td>
            <td>
                <?=__( 'Disable single product zoom effect', $this->plugin_name )?><span class="help-text">when enabled, single product image zoom effect will be disabled as some themes are incompatible to render both product image zoom effect and FitOn functionality at the same time.</span>
            </td>
        </tr>

        <tr valign="top">
            <td>
                <?php 
                $this->show_setting_input('checkbox', $this->plugin_name . '_responsive_positioning_in_pages', $this->plugin_name . '_responsive_positioning_in_pages', [], $this->plugin_config['responsive_positioning_in_pages']);
                ?>
            </td>
            <td>
                <?=__( 'Responsive FitOn positioning in pages', $this->plugin_name )?><span class="help-text">when enabled, fiton position in single product & shop pages will try to stay the same even if user resizes the browser window.</span>
            </td>
        </tr>

        <tr valign="top">
            <td>
                <?php 
                $this->show_setting_input('checkbox', $this->plugin_name . '_responsive_positioning_in_modal', $this->plugin_name . '_responsive_positioning_in_modal', [], $this->plugin_config['responsive_positioning_in_modal']);
                ?>
            </td>
            <td>
                <?=__( 'Responsive FitOn positioning in modal', $this->plugin_name )?><span class="help-text">when enabled, fiton position in modal window will try to stay the same even if user resizes the browser window (experimental feature).</span>
            </td>
        </tr>

        <tr valign="top">
            <td>
                <?php 
                $this->show_setting_input('checkbox', $this->plugin_name . '_webcam_active', $this->plugin_name . '_webcam_active', [], $this->plugin_config['webcam_active']);
                ?>
            </td>
            <td>
                <?=__( 'Webcam', $this->plugin_name )?><span class="help-text">when enabled, user will see a capture with webcam option.</span>
            </td>
        </tr>

        <tr valign="top">
            <td>
                <?php 
                $this->show_setting_input('checkbox', $this->plugin_name . '_instructions_active', $this->plugin_name . '_instructions_active', [], $this->plugin_config['instructions_active']);
                ?>
            </td>
            <td>
                <?=__( 'Show instructions', $this->plugin_name )?><span class="help-text">when enabled, user will see an instuctions list in modal window.</span>
            </td>
        </tr>

        <tr valign="top">
        <th scope="row"><?=__( 'Instructions', $this->plugin_name )?></th>
        <td>
            <?php 
            $this->show_setting_input('textarea', $this->plugin_name . '_instructions', $this->plugin_name . '_instructions', [], $this->plugin_config['instructions']); 
            ?>
            <span class="help-text"><?=__( 'separate each instruction with a linebreak', $this->plugin_name )?></span>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">
            <?=__( 'Theme color', $this->plugin_name )?>
        </th>
        <td>
            <?php 
            $this->show_setting_input('text', $this->plugin_name . '_theme_color', $this->plugin_name . '_theme_color', [], $this->plugin_config['theme_color']); 
            ?>
            <span class="help-text"><?=__( 'will be used for buttons, toggles and modal window design', $this->plugin_name )?></span>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">
            <?=__( 'User image', $this->plugin_name )?>
        </th>
        <td>
            <?php 
            $this->show_setting_input('text', $this->plugin_name . '_user_image', $this->plugin_name . '_user_image', [], $this->plugin_config['user_image']); 
            ?>
            <span class="help-text"><?=__( 'will be shown to the user before they upload their first photo', $this->plugin_name )?></span>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">
            <?=__( 'FitOn image', $this->plugin_name )?>
        </th>
        <td>
            <?php 
            $this->show_setting_input('text', $this->plugin_name . '_fiton_image', $this->plugin_name . '_fiton_image', [], $this->plugin_config['fiton_image']); 
            ?>
            <span class="help-text"><?=__( 'will be used as the positioning product image in shop archive page', $this->plugin_name )?></span>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">
            <?=__( 'Webcam guide image', $this->plugin_name )?>
        </th>
        <td>
            <?php 
            $this->show_setting_input('text', $this->plugin_name . '_placeholder_image', $this->plugin_name . '_placeholder_image', [], $this->plugin_config['placeholder_image']); 
            ?>
            <span class="help-text"><?=__( 'will be shown over the webcam stream to help users position themselves', $this->plugin_name )?></span>
        </td>
        </tr>

        <tr valign="top" class="advanced-settings">
            <th scope="row">
                <?=__( 'Advanced settings', $this->plugin_name )?>
            </th>
            <td>
                <a href="#advanced"><?=__( 'show advanced settings', $this->plugin_name )?></a> 
                <span class="help-text">changing these settings might probably break things</span>
            </td>
        </tr>


        <tr valign="top" class="section-header advanced-setting">
            <th scope="row">
                <h3><?=__( 'Element selectors', $this->plugin_name )?></h3>
            </th>
        </tr>

        <tr valign="top" class="advanced-setting">
            <th scope="row">
                <?=__( 'Single product image', $this->plugin_name )?>
            </th>
            <td>
                <?php 
                $this->show_setting_input('text', $this->plugin_name . '_single_pimg_selector', $this->plugin_name . '_single_pimg_selector', [], $this->plugin_config['single_pimg_selector']); 
                ?>
            </td>
        </tr>

        <tr valign="top" class="advanced-setting">
            <th scope="row">
                <?=__( 'Shop product loop', $this->plugin_name )?>
            </th>
            <td>
                <?php 
                $this->show_setting_input('text', $this->plugin_name . '_products_loop', $this->plugin_name . '_products_loop', [], $this->plugin_config['products_loop']); 
                ?>
            </td>
        </tr>

        <tr valign="top" class="advanced-setting">
            <th scope="row">
                <?=__( 'FitOn prepend', $this->plugin_name )?>
            </th>
            <td>
                <?php 
                $this->show_setting_input('text', $this->plugin_name . '_products_prepend', $this->plugin_name . '_products_prepend', [], $this->plugin_config['products_prepend']); 
                ?>
            </td>
        </tr>

        <tr valign="top" class="advanced-setting">
            <th scope="row"><?=__( 'Push single placement after', $this->plugin_name )?></th>
            <td>
                <?php 
                $this->show_setting_input('text', $this->plugin_name . '_push_single_placement_after', $this->plugin_name . '_push_single_placement_after', [], $this->plugin_config['push_single_placement_after']);
                ?>
            </td>
        </tr>

        <tr valign="top" class="section-header advanced-setting">
            <th scope="row">
                <h3><?=__( 'Fallback values', $this->plugin_name )?></h3>
            </th>
        </tr>

        <tr valign="top" class="advanced-setting">
            <th scope="row">
                <?=__( 'Shop image dimentions', $this->plugin_name )?>
            </th>
            <td>
                <?php 
                $this->show_setting_input('text', $this->plugin_name . '_shop_image_dimentions', $this->plugin_name . '_shop_image_dimentions', [], $this->plugin_config['shop_image_dimentions']); 
                ?>
            </td>
        </tr>

        <tr valign="top" class="advanced-setting">
            <th scope="row">
                <?=__( 'Product image dimentions', $this->plugin_name )?>
            </th>
            <td>
                <?php 
                $this->show_setting_input('text', $this->plugin_name . '_product_image_dimentions', $this->plugin_name . '_product_image_dimentions', [], $this->plugin_config['product_image_dimentions']); 
                ?>
            </td>
        </tr>

        <tr valign="top" class="advanced-setting">
            <th scope="row">
                <?=__( 'User image dimentions', $this->plugin_name )?>
            </th>
            <td>
                <?php 
                $this->show_setting_input('text', $this->plugin_name . '_user_image_dimentions', $this->plugin_name . '_user_image_dimentions', [], $this->plugin_config['user_image_dimentions']); 
                ?>
            </td>
        </tr>

        <tr valign="top" class="advanced-setting">
            <th scope="row">
                <?=__( 'Global fiton position', $this->plugin_name )?>
            </th>
            <td>
                <?php 
                $this->show_setting_input('text', $this->plugin_name . '_fallback_position', $this->plugin_name . '_fallback_position', [], $this->plugin_config['fallback_position']); 
                ?>
            </td>
        </tr>
    </table>
    
    <?php submit_button(); ?>
</form>
<hr>
<p>Developed by prabch for <a href="https://upentreprise.com" target="_blank">UPEnterprise</a></p>
<span class="help-text">Libraries used : jquery-free-transform, Magnific-Popup</span>
</div>
