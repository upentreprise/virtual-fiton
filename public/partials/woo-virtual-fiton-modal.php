<!-- start of virtual fiton section -->
<div id="<?=$this->plugin_name?>_<?=$page?>_modal" class="<?=$this->plugin_name?>_container <?=$this->plugin_name?>_<?=$page?>_container fiton-disabled" style="--primary-color: <?=$this->plugin_config['theme_color']?>;">

  <?php if ($page == 'single') : ?>
    <input type="hidden" id="<?=$this->plugin_name?>_product_id" value="<?=$post->ID?>">
    <input type="hidden" id="<?=$this->plugin_name?>_fiton_image" value="<?=$fiton_image?>">
  <?php elseif ($page == 'shop') : ?>
    <input type="hidden" id="<?=$this->plugin_name?>_shop" value="true">
  <?php endif; ?>

  <div class="toggle-section">
    <label class="toggle-switch">
      <input type="checkbox" id="<?=$this->plugin_name?>_toggle">
      <span class="slider round"></span>
    </label>
    <div class="toggle-label"><?=$this->plugin_public_name?></div>
    <button type="button" id="<?=$this->plugin_name?>_open_modal" class="small-btn" href="#<?=$this->plugin_name?>_modal"><span class="caption"><?=__( 'Essayer', $this->plugin_name )?></span><div class="arrow-wrapper"><div class="arrow"></div></div></button>
  </div>

  <div id="<?=$this->plugin_name?>_modal" class="modal-window mfp-hide <?=$this->plugin_name?>_container">
    <div class="header-block"><?=$this->plugin_public_name?></div>
    <div class="row">
        <div class="column image-block">
            <video id="<?=$this->plugin_name?>_camera" autoplay muted playsinline><?=__( 'Webcam not available', $this->plugin_name )?></video>
            <canvas id="<?=$this->plugin_name?>_canvas"></canvas>  
            <img id="<?=$this->plugin_name?>_preview_image" class="preview-image" src="<?=$preview_image;?>">
        </div>
        <div class="column upload-block">

            <div class="column-sub-title"><?=__( 'Votre Photo', $this->plugin_name )?></div>
            <?php if ($this->plugin_config['webcam_active']): ?>
              <button type="button" id="<?=$this->plugin_name?>_webcam_btn"><span class="dashicons dashicons-camera-alt"></span><span class="caption"><?=__( 'Prendre une photo', $this->plugin_name )?></span></button>
            <?php endif; ?>
            <button type="button" id="<?=$this->plugin_name?>_upload_btn"><span class="dashicons dashicons-upload"></span><span class="caption"><?=__( 'Prendre une photo', $this->plugin_name )?></span></button>
            <input type="file" id="<?=$this->plugin_name?>_user_image" accept="image/*">
            <br><br>

            <div class="webcam-block">
            <div class="column-sub-title"><?=__( 'Capture', $this->plugin_name )?></div>
            <button id="<?=$this->plugin_name?>_webcam_switch_btn"><span class="dashicons dashicons-update"></span><?=__( 'Autre caméra', $this->plugin_name )?></button>
            <button id="<?=$this->plugin_name?>_webcam_shoot_btn"><span class="dashicons dashicons-camera"></span><?=__( 'Prendre la photo', $this->plugin_name )?></button>
            <br><br>
            </div>

            <div class="controls-block">
            <div class="column-sub-title"><?=__( 'Votre essayage', $this->plugin_name )?></div>
            <button type="button" id="<?=$this->plugin_name?>_save_btn"><span class="dashicons dashicons-yes-alt"></span><?=__( 'Sauvegarder', $this->plugin_name )?></button>
            <button type="button" id="<?=$this->plugin_name?>_edit_btn"><span class="dashicons dashicons-edit"></span><?=__( 'Repositionner le chapeau', $this->plugin_name )?></button>
            <br><br>
            </div>

            <?php if ($this->plugin_config['instructions_active']): ?>
              <div class="column-sub-title"><?=__( 'Instructions', $this->plugin_name )?></div>
              <ol>
              <?php
                  $instructions = preg_split('/\r\n|\r|\n/', $this->plugin_config['instructions']);
                  foreach ($instructions as $instruction) {
                  echo '<li>' . $instruction . '</li>';
                  }
              ?>
              </ol>
            <?php endif; ?>
        </div>
    </div>
  </div>

</div>
<!-- end of virtual fiton section -->