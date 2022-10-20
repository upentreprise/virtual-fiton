<p class="form-field <?=$this->plugin_name?>_fiton_image_field ">
    <label for="<?=$this->plugin_name?>_fiton_image"><?=__( 'Transparent FitOn Image', $this->plugin_name )?></label>
    <input type="text" class="<?=$this->plugin_name?>-fiton-image" name="<?=$this->plugin_name?>_fiton_image" id="<?=$this->plugin_name?>_fiton_image" value="<?=get_post_meta(get_the_ID(), $this->plugin_name . '_fiton_image', true) ?>">&nbsp;&nbsp;
    <input type='button' class="button-primary" value="<?=__( 'Upload Image', $this->plugin_name )?>" id="<?=$this->plugin_name?>_upload_fiton"/>
    <br><span><?=__( 'This image will be used as the FitOn image for this product', $this->plugin_name )?></span>
    <br><br>
    <img id="<?=$this->plugin_name?>_preview_image" src="<?=get_post_meta(get_the_ID(), $this->plugin_name . '_fiton_image', true) ?>" width="200">
</p>