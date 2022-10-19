<!-- start of virtual fiton section -->
<div id="<?=$this->plugin_name?>_shop_page" class="<?=$this->plugin_name?>_container <?=$this->plugin_name?>_shop_container fiton-disabled">

  <input type="hidden" id="<?=$this->plugin_name?>_shop" value="true">

  <div class="toggle-section">
    <label class="toggle-switch">
      <input type="checkbox" id="<?=$this->plugin_name?>_toggle">
      <span class="slider round"></span>
    </label>
    <div><?=$this->plugin_public_name?></div>
    <button type="button" id="<?=$this->plugin_name?>_open_modal" class="small-btn" href="#<?=$this->plugin_name?>_modal"><span class="dashicons dashicons-smiley"></span><?=__( 'Essayer', $this->plugin_name )?></button>
  </div>

  <div id="<?=$this->plugin_name?>_modal" class="modal-window mfp-hide <?=$this->plugin_name?>_container">
    
  <div class="header-block"><?=$this->plugin_public_name?></div>

  <div class="row">

      <div class="column image-block">
        <img id="<?=$this->plugin_name?>_preview_image" src="<?=$this->plugin_config['user_image'];?>">
      </div>

      <div class="column upload-block">

        <div class="column-sub-title"><?=__( 'Votre Photo', $this->plugin_name )?></div>
        <button type="button" id="<?=$this->plugin_name?>_webcam_btn"><span class="dashicons dashicons-camera-alt"></span><span class="caption"><?=__( 'Prendre une photo', $this->plugin_name )?></span></button>
        <button type="button" id="<?=$this->plugin_name?>_upload_btn"><span class="dashicons dashicons-upload"></span><span class="caption"><?=__( 'Prendre une photo', $this->plugin_name )?></span></button>
        <input type="file" id="<?=$this->plugin_name?>_user_image" accept="image/*">
        <br><br>

        <div class="controls-block">
          <div class="column-sub-title"><?=__( 'Votre essayage', $this->plugin_name )?></div>
          <button type="button" id="<?=$this->plugin_name?>_save_btn"><span class="dashicons dashicons-yes-alt"></span><?=__( 'Sauvegarder', $this->plugin_name )?></button>
          <button type="button" id="<?=$this->plugin_name?>_edit_btn"><span class="dashicons dashicons-edit"></span><?=__( 'Repositionner le chapeau', $this->plugin_name )?></button>
          <br><br>
        </div>

        <div class="column-sub-title"><?=__( 'Instructions', $this->plugin_name )?></div>
        <ol>
          <?php
            $instructions = preg_split('/\r\n|\r|\n/', $this->plugin_config['instructions']);
            foreach ($instructions as $instruction) {
              echo '<li>' . $instruction . '</li>';
            }
          ?>
        </ol>
      </div>

    </div>
  </div>

</div>
<!-- end of virtual fiton section -->