<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       upentreprise.com/prabch
 * @since      1.0.0
 *
 * @package    Woo_Virtual_Fiton
 * @subpackage Woo_Virtual_Fiton/public/partials
 */
?>

<!-- start of virtual fiton section -->
<div id="<?=$this->plugin_name?>_single_section" class="<?=$this->plugin_name?>_single_section_container">

    <input type="hidden" id="<?=$this->plugin_name?>_product_id" value="<?=$post->ID?>">
    <input type="hidden" id="<?=$this->plugin_name?>_fiton_image" value="<?=$fiton_image?>">
    <button type="button" id="<?=$this->plugin_name?>_trigger_btn"><?=$this->plugin_public_name?><div class="arrow-wrapper"><div class="arrow"></div></div></button>
    <input type="file" id="<?=$this->plugin_name?>_user_image" accept="image/*">
    <button type="button" id="<?=$this->plugin_name?>_save_btn">Save FitOn</button>
    <button type="button" id="<?=$this->plugin_name?>_edit_btn">Edit FitOn</button>

</div>
<!-- end of virtual fiton section -->