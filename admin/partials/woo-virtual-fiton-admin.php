<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       upentreprise.com/prabch
 * @since      1.0.0
 *
 * @package    Woo_Virtual_Fiton
 * @subpackage Woo_Virtual_Fiton/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
<h1><?=$this->plugin_public_name?></h1>
<hr>

<form method="post" action="options.php">
    <?php settings_fields( $this->plugin_name ); ?>
    <?php do_settings_sections( $this->plugin_name ); ?>
    <table class="form-table">

        <tr valign="top">
        <th scope="row"><?=__( 'Shortcodes', $this->plugin_name )?></th>
        <td>
            <?php 
            $this->show_setting_input('checkbox', $this->plugin_name . '_shortcodes_active', $this->plugin_name . '_shortcodes_active', [], $this->plugin_config['shortcodes_active']);
            ?>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row"><?=__( 'Shop page integration', $this->plugin_name )?></th>
        <td>
            <?php 
            $this->show_setting_input('checkbox', $this->plugin_name . '_shop_page_active', $this->plugin_name . '_shop_page_active', [], $this->plugin_config['shop_page_active']);
            ?>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row"><?=__( 'Shop loop integration', $this->plugin_name )?></th>
        <td>
            <?php 
            $this->show_setting_input('checkbox', $this->plugin_name . '_shop_loop_active', $this->plugin_name . '_shop_loop_active', [], $this->plugin_config['shop_loop_active']);
            ?>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row"><?=__( 'Single product integration', $this->plugin_name )?></th>
        <td>
            <?php 
            $this->show_setting_input('checkbox', $this->plugin_name . '_single_product_active', $this->plugin_name . '_single_product_active', [], $this->plugin_config['single_product_active']);
            ?>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row"><?=__( 'JS/CSS Caching', $this->plugin_name )?></th>
        <td>
            <?php 
            $this->show_setting_input('checkbox', $this->plugin_name . '_caching_active', $this->plugin_name . '_caching_active', [], $this->plugin_config['caching_active']);
            ?>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row"><?=__( 'Disable single product zoom effect', $this->plugin_name )?></th>
        <td>
            <?php 
            $this->show_setting_input('checkbox', $this->plugin_name . '_disable_single_zoom', $this->plugin_name . '_disable_single_zoom', [], $this->plugin_config['disable_single_zoom']);
            ?>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row"><?=__( 'Instructions', $this->plugin_name )?></th>
        <td>
            <?php 
            $this->show_setting_input('textarea', $this->plugin_name . '_instructions', $this->plugin_name . '_instructions', [], $this->plugin_config['instructions']); 
            ?>
            <p><?=__( 'separate each instruction with a linebreak', $this->plugin_name )?></p>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">
            <h3><?=__( 'Images', $this->plugin_name )?></h3>
        </th>
        </tr>

        <tr valign="top">
        <th scope="row">
            <?=__( 'User image', $this->plugin_name )?>
        </th>
        <td>
            <?php 
            $this->show_setting_input('text', $this->plugin_name . '_user_image', $this->plugin_name . '_user_image', [], $this->plugin_config['user_image']); 
            ?>
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
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">
            <h3><?=__( 'Element selectors', $this->plugin_name )?></h3>
            <!--<span><?=__( 'changing these values might break the functionality', $this->plugin_name )?></span>-->
        </th>
        </tr>

        <tr valign="top">
        <th scope="row">
            <?=__( 'Single product image', $this->plugin_name )?>
        </th>
        <td>
            <?php 
            $this->show_setting_input('text', $this->plugin_name . '_single_pimg_selector', $this->plugin_name . '_single_pimg_selector', [], $this->plugin_config['single_pimg_selector']); 
            ?>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">
            <?=__( 'Shop product loop', $this->plugin_name )?>
        </th>
        <td>
            <?php 
            $this->show_setting_input('text', $this->plugin_name . '_products_loop', $this->plugin_name . '_products_loop', [], $this->plugin_config['products_loop']); 
            ?>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">
            <?=__( 'FitOn prepend', $this->plugin_name )?>
        </th>
        <td>
            <?php 
            $this->show_setting_input('text', $this->plugin_name . '_products_prepend', $this->plugin_name . '_products_prepend', [], $this->plugin_config['products_prepend']); 
            ?>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row"><?=__( 'Push single placement after', $this->plugin_name )?></th>
        <td>
            <?php 
            $this->show_setting_input('text', $this->plugin_name . '_push_single_placement_after', $this->plugin_name . '_push_single_placement_after', [], $this->plugin_config['push_single_placement_after']);
            ?>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">
            <h3><?=__( 'Fallback values', $this->plugin_name )?></h3>
        </th>
        </tr>

        <tr valign="top">
        <th scope="row">
            <?=__( 'Shop image dimentions', $this->plugin_name )?>
        </th>
        <td>
            <?php 
            $this->show_setting_input('text', $this->plugin_name . '_shop_image_dimentions', $this->plugin_name . '_shop_image_dimentions', [], $this->plugin_config['shop_image_dimentions']); 
            ?>
            <p><?=__( 'fallback user image dimentions for the shop archive page', $this->plugin_name )?></p>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">
            <?=__( 'Product image dimentions', $this->plugin_name )?>
        </th>
        <td>
            <?php 
            $this->show_setting_input('text', $this->plugin_name . '_product_image_dimentions', $this->plugin_name . '_product_image_dimentions', [], $this->plugin_config['product_image_dimentions']); 
            ?>
            <p><?=__( 'fallback product image dimentions for the single product page', $this->plugin_name )?></p>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">
            <?=__( 'User image dimentions', $this->plugin_name )?>
        </th>
        <td>
            <?php 
            $this->show_setting_input('text', $this->plugin_name . '_user_image_dimentions', $this->plugin_name . '_user_image_dimentions', [], $this->plugin_config['user_image_dimentions']); 
            ?>
            <p><?=__( 'fallback user image dimentions for the shop archive page', $this->plugin_name )?></p>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">
            <?=__( 'Global fiton position', $this->plugin_name )?>
        </th>
        <td>
            <?php 
            $this->show_setting_input('text', $this->plugin_name . '_fallback_position', $this->plugin_name . '_fallback_position', [], $this->plugin_config['fallback_position']); 
            ?>
            <p><?=__( 'fallback global fiton position', $this->plugin_name )?></p>
        </td>
        </tr>
    </table>
    
    <?php submit_button(); ?>
</form>
<hr>
<p>A plugin by UPEnterprise</p>
</div>
