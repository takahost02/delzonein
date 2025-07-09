<!-- Content Header -->
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Settings</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Home</a></li>
               <li class="breadcrumb-item active">Settings</li>
            </ol>
         </div>
      </div>
   </div>
</div>

<section class="content">
  <div class="container-fluid">
    <form method="post" id="website_content_form" class="card" enctype="multipart/form-data" action="<?php echo base_url(); ?>settings/frontendcontent_save">
      <div class="card-body">
        <div class="row">
        <?php if(isset($content)) { ?>
                   <input type="hidden" name="id" id="id" value="<?php echo (isset($content)) ? $content['id']:'' ?>" >
                 <?php } ?>
          <div class="col-sm-6 col-md-3">
            <label class="form-label">Phone</label>
            <div class="form-group">
              <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" value="<?php echo (isset($content)) ? $content['phone'] : ''; ?>">
            </div>
          </div>

          <div class="col-sm-6 col-md-3">
            <label class="form-label">Email</label>
            <div class="form-group">
              <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="<?php echo (isset($content)) ? $content['email'] : ''; ?>">
            </div>
          </div>

          <div class="col-sm-6 col-md-3">
            <label class="form-label">Facebook Link</label>
            <div class="form-group">
              <input type="url" name="facebook_link" id="facebook_link" class="form-control" placeholder="Facebook Link" value="<?php echo (isset($content)) ? $content['facebook_link'] : ''; ?>">
            </div>
          </div>

          <div class="col-sm-6 col-md-3">
            <label class="form-label">Twitter Link</label>
            <div class="form-group">
              <input type="url" name="twitter_link" id="twitter_link" class="form-control" placeholder="Twitter Link" value="<?php echo (isset($content)) ? $content['twitter_link'] : ''; ?>">
            </div>
          </div>

          <div class="col-sm-6 col-md-3">
            <label class="form-label">Instagram Link</label>
            <div class="form-group">
              <input type="url" name="instagram_link" id="instagram_link" class="form-control" placeholder="Instagram Link" value="<?php echo (isset($content)) ? $content['instagram_link'] : ''; ?>">
            </div>
          </div>

          <div class="col-sm-6 col-md-3">
            <label class="form-label">LinkedIn Link</label>
            <div class="form-group">
              <input type="url" name="linkedin_link" id="linkedin_link" class="form-control" placeholder="LinkedIn Link" value="<?php echo (isset($content)) ? $content['linkedin_link'] : ''; ?>">
            </div>
          </div>

          <div class="col-sm-6 col-md-3">
            <label class="form-label">YouTube Link</label>
            <div class="form-group">
              <input type="url" name="youtube_link" id="youtube_link" class="form-control" placeholder="YouTube Link" value="<?php echo (isset($content)) ? $content['youtube_link'] : ''; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label">Text 1</label>
            <div class="form-group">
              <textarea name="text1" id="text1" class="form-control" placeholder="Text 1"><?php echo (isset($content)) ? $content['text1'] : ''; ?></textarea>
            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label">Text 2</label>
            <div class="form-group">
              <textarea name="text2" id="text2" class="form-control" placeholder="Text 2"><?php echo (isset($content)) ? $content['text2'] : ''; ?></textarea>
            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label">Text 3</label>
            <div class="form-group">
              <textarea name="text3" id="text3" class="form-control" placeholder="Text 3"><?php echo (isset($content)) ? $content['text3'] : ''; ?></textarea>
            </div>
          </div>

          <!-- <div class="col-md-6">
            <label class="form-label">Scrolling Text</label>
            <div class="form-group">
              <textarea name="scrolling_text" id="scrolling_text" class="form-control" placeholder="Scrolling Text"><?php echo (isset($content)) ? $content['scrolling_text'] : ''; ?></textarea>
            </div>
          </div> -->

          <div class="col-sm-6">
            <label class="form-label">Our Fleet Heading</label>
            <div class="form-group">
              <input type="text" name="our_fleet_heading" id="our_fleet_heading" class="form-control" placeholder="Our Fleet Heading" value="<?php echo (isset($content)) ? $content['our_fleet_heading'] : ''; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label">Our Fleet Sub Text</label>
            <div class="form-group">
              <textarea name="our_fleet_subtext" id="our_fleet_subtext" class="form-control" placeholder="Our Fleet Sub Text"><?php echo (isset($content)) ? $content['our_fleet_subtext'] : ''; ?></textarea>
            </div>
          </div>

          <div class="col-sm-6 col-md-3">
            <label class="form-label">Call to Action Text</label>
            <div class="form-group">
              <input type="text" name="call_to_action_text" id="call_to_action_text" class="form-control" placeholder="Call to Action Text" value="<?php echo (isset($content)) ? $content['call_to_action_text'] : ''; ?>">
            </div>
          </div>

          <div class="col-sm-6 col-md-3">
            <label class="form-label">Call to Action Number</label>
            <div class="form-group">
              <input type="text" name="call_to_action_number" id="call_to_action_number" class="form-control" placeholder="Call to Action Number" value="<?php echo (isset($content)) ? $content['call_to_action_number'] : ''; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label">About Us</label>
            <div class="form-group">
              <textarea name="about_us" id="about_us" class="form-control" placeholder="About Us"><?php echo (isset($content)) ? $content['about_us'] : ''; ?></textarea>
            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label">Contact Address</label>
            <div class="form-group">
              <textarea name="contact_address" id="contact_address" class="form-control" placeholder="Contact Address"><?php echo (isset($content)) ? $content['contact_address'] : ''; ?></textarea>
            </div>
          </div>

          <div class="col-md-12">
            <label class="form-label">Terms</label>
            <div class="form-group">
              <textarea name="terms" id="terms" class="form-control" placeholder="Terms"><?php echo (isset($content)) ? $content['terms'] : ''; ?></textarea>
            </div>
          </div>

          <div class="col-md-12">
            <label class="form-label">Privacy Policy</label>
            <div class="form-group">
              <textarea name="privacy_policy" id="privacy_policy" class="form-control" placeholder="Privacy Policy"><?php echo (isset($content)) ? $content['privacy_policy'] : ''; ?></textarea>
            </div>
          </div>

          <div class="col-sm-6 col-md-3">
            <label class="form-label">Primary Color</label>
            <div class="form-group">
              <input id="add-device-color" name="primary_color" class="jscolor {valueElement:'add-device-color', styleElement:'add-device-color', hash:true, mode:'HSV'} form-control"  value="<?php echo (isset($content['primary_color'])) ? $content['primary_color']:'#78CA5C' ?>" >
            </div>
          </div>

          <div class="col-sm-6 col-md-3">
            <label class="form-label">Secondary Ccolor</label>
            <div class="form-group">
            <input id="add-device-color-sec" name="secondary_color" class="jscolor {valueElement:'add-device-color-sec', styleElement:'add-device-color-sec', hash:true, mode:'HSV'} form-control"  value="<?php echo (isset($content['secondary_color'])) ? $content['secondary_color']:'#199e1c' ?>" >

            </div>
          </div>
          

          <div class="col-sm-6 col-md-4">
            <div class="form-group">
              <label for="exampleInputFile">Main Background Image</label>
              <div class="input-group">
                  <input type="file" class="form-control" id="file" name="file">
              </div>
            </div>
            <?php if($content['mainbg_img']!='') { ?>
              <img src="<?= base_url().'assets/uploads/'.$content['mainbg_img']; ?>" alt="Logo"  width="200px"/>
            <?php } ?>
        </div>


        </div>
      </div>

      <div class="card-footer text-right">
        <button type="submit" class="btn btn-primary">Save Content</button>
      </div>
    </form>
  </div>
</section>