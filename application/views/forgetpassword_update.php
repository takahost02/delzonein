<?php 
      $siteinfo =array();
      $CI =& get_instance();
      $CI->db->from('settings');
      $query = $CI->db->get();
      if($query !== FALSE && $query->num_rows() > 0){
        $siteinfo = $query->result_array();
      }
      
     ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= output($siteinfo[0]['s_companyname'] ?? 'Vehicle Management System'); ?> | Update Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    
    <style>
        body {
            margin: 0;
            display: flex;
            height: 100vh;
        }
        .login-container {
            display: flex;
            flex: 1;
        }
        .login-box {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 500px; /* Adjust the width of the login box */
            padding: 20px;
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        .background-image {
            flex: 1;
            background: url('<?= base_url(); ?>assets/dist/login_bg.jpg') no-repeat center center;
            background-size: contain;
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="background-image"></div>
    <div class="login-box">
        <div class="card">
       



   <div class="card" style="max-width: 400px; margin: auto; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
    <div class="card-body login-card-body">
        <p class="login-box-msg"><?= output($siteinfo[0]['s_companyname'] ?? 'Vehicle Management System'); ?></p>
        
        


        <form action="<?= base_url('login/changepassword/' . $token); ?>" method="post">

            <div class="input-group mb-3">
                <input type="password" name="password" required class="form-control" placeholder="New Password" aria-label="Username" style="border-radius: 5px;">
                <div class="input-group-append">
                    <div class="input-group-text" style="border-radius: 5px;">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>

            <div class="input-group mb-3">
                <input type="password" name="confirm_password" required class="form-control" placeholder="Confirm Password" aria-label="Username" style="border-radius: 5px;">
                <div class="input-group-append">
                    <div class="input-group-text" style="border-radius: 5px;">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>


           
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>

    </div>



            <?php 
$successMessage = $this->session->flashdata('successmessage');  
$warningMessage = $this->session->flashdata('warningmessage');                    

if (isset($successMessage)) { 
    echo '<div id="alertmessage" class="col-md-12">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> ' . output($successMessage) . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>'; 
} 

if (isset($warningMessage)) { 
    echo '<div id="alertmessage" class="col-md-12">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> ' . output($warningMessage) . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>'; 
}    
?></div>
        </div>
    </div>
</div>

<script src="<?= base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
