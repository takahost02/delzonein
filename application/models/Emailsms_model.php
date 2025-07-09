<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emailsms_model extends CI_Model{
	
	public function sendemail($email,$subject,$body)
	{
       $this->load->helper('url');
       $data = sitedata(); 
	   $this->load->library('phpmailer_lib');
       $emailconfig = $this->db->select('*')->from('settings_smtp')->get()->result_array();
       if(!empty($emailconfig)) {
           $mail = $this->phpmailer_lib->load();
           $mail->isSMTP();
           $mail->Host = $emailconfig[0]['smtp_host'];
           $mail->SMTPAuth = $emailconfig[0]['smtp_auth'];
           $mail->Username = $emailconfig[0]['smtp_uname'];
           $mail->Password = $emailconfig[0]['smtp_pwd'];
           $mail->SMTPSecure = $emailconfig[0]['smtp_issecure'];
           $mail->Port = $emailconfig[0]['smtp_port'];
           $mail->setFrom($emailconfig[0]['smtp_emailfrom']);
           $mail->addReplyTo($emailconfig[0]['smtp_replyto']);
           $mail->addAddress($email); 
           $mail->Subject = $subject;
           $mail->isHTML(true);
           $mail->Body = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Booking Confirmation</title>
                <style>
                  body {font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9;} .email-container {max-width: 600px; margin: 20px auto; background: #ffffff; border: 1px solid #dddddd; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);} .email-header {background-color: #0e6980; color: white; padding: 20px; text-align: center;} .email-header img {max-width: 150px; margin-bottom: 10px;} .email-body {padding: 20px; color: #333333;} .email-body h2 {color: #007BFF;} .email-footer {text-align: center; padding: 10px; font-size: 12px; color: #777777; background: #f1f1f1;}
                </style>
            </head>
            <body>
                <div class="email-container">
                    <!-- Header -->
                    <div class="email-header">
                        <img src="'.base_url().'assets/uploads/'.$data['s_logo'].'" alt="VMS Logo">
                    </div>
                    
                    <!-- Body -->
                    <div class="email-body">
                        '.$body.'

                    <br>
                    Warm regards,<br>
                     '.$data['s_companyname'].'<br>
                     '.$data['s_address'].'<br>
                    </div>
                    
                    <!-- Footer -->
                    <div class="email-footer">
                        &copy; '.date('Y').' '.$data['s_companyname'].'. All Rights Reserved.
                    </div>
                </div>
            </body>
            </html>
            ';
           if($mail->send())
              return 'true';
           else
              return $mail->ErrorInfo;
        } else {
              return 'Please add smtp configurations';
        }
	}
} 