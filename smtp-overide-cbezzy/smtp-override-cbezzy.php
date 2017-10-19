<?php 
 /*
   Plugin Name: SMTP Overide 
   Auther: Craig Bezuidenhout
   Github: https://github.com/cbezzy
   Description: Override default wp_mail and use basic SMTP settings , when active look in your settings for a new "SMTP Options" option Use wp_mail() as normal once this is set up and it will use you new settings.
  
   Version: 1.1.1 
 
    overwrite the default phpmailer
    hook into the wp_mail init method
    this allows us to use SMTP authorization
 */
add_action( 'admin_menu', 'smtp_override_cbezzy_menu_1507709700' );
/*
 * @function smtp_override_cbezzy_menu_1507709700
 * 
 * add an item to the admin menu
 */
function smtp_override_cbezzy_menu_1507709700() {
	add_options_page( 
		'SMTP Options',
		'SMTP Options',
		'manage_options',
		'smtp-override-cbezzy.php',
		'settings_view_cbezzy_1507709700'
	);
}


/*
 * @function settings_view_cbezzy_1507709700
 * 
 * settingsForm.php contains the form that is displayed in the admin screen 
 */
function settings_view_cbezzy_1507709700(){ 
    if( isset( $_POST ) ){ smtp_override_cbezzy_save_setttings_1507709700(); }  
    require_once( 'settingsForm.php' );
}

add_action( 'phpmailer_init', 'smtp_override_cbezzy_1507709700' );
/*
 * @function smtp_override_cbezzy_1507709700
 * @param phpmailer Object $phpmailer
 * 
 * Override the default settings based on the settings that have been saved
 * 
 * @return phpmailer
 */
function smtp_override_cbezzy_1507709700( $phpmailer ){
    $phpmailer->isSMTP();
    $phpmailer->SMTPDebug   = 0;
    $phpmailer->Host        = get_option( 'smtp_override_cbezzy_server' , '' );
    $phpmailer->SMTPAuth    = true;
    $phpmailer->Username    = smtp_clean_fetch_option_cbezzy_1507709700( 'smtp_override_cbezzy_username' , '' );
    
    // purely visual , so that we don't store this in clean text ( this is not for security )
    // this should use encryption later 
    $phpmailer->Password    = base64_decode( get_option( 'smtp_override_cbezzy_password' , '' ) );
    $phpmailer->SMTPSecure  = smtp_clean_fetch_option_cbezzy_1507709700( 'smtp_override_cbezzy_security' , 'none' ) ;
    $phpmailer->Port        = smtp_clean_fetch_option_cbezzy_1507709700( 'smtp_override_cbezzy_port' , '' );
    $phpmailer->setFrom(      smtp_clean_fetch_option_cbezzy_1507709700( 'smtp_override_cbezzy_from_address' , '' )
                            , smtp_clean_fetch_option_cbezzy_1507709700( 'smtp_override_cbezzy_from_name', '')
                            , false );  
    if( (int) get_option( 'smtp_override_cbezzy_bypass_ssl_verify' ) === 1 ){
        $phpmailer->SMTPOptions = [ 'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]];
    } 
    $phpmailer->isHTML( true );
    return $phpmailer;
}


/*
 * @function smtp_override_cbezzy_save_new_setttings_1507709700
 * 
 * this saves the smtp settings to the wordpress database 
 */
function smtp_override_cbezzy_save_setttings_1507709700(){
    if( isset( $_POST ) && sizeof( $_POST ) > 0 ){ 
        foreach( $_POST as $name=>$value ) {
            $name   = trim( sanitize_text_field( $name  ) );
            $value  = trim( sanitize_text_field( $value ) ); 
            if( substr( $name , 0 , 22 ) === 'smtp_override_cbezzy' ){  
                if( $name === 'smtp_override_cbezzy_password' ){
                    // purely visual , so that we don't store this in clean text ( this is not for security )
                    // this should use encryption later
                    update_option( $name, base64_encode( $value ) ); 
                }else{
                    update_option( $name , $value );
                }
            } 
            if( !isset( $_POST[ 'smtp_override_bypass_ssl_verify_cbezzy' ] ) ){
                update_option( 'smtp_override_bypass_ssl_verify_cbezzy' , 0 );
            }
        }
        if( isset( $_POST[ 'saveAndSendTest' ] ) && isset( $_POST[ 'smtp_override_cbezzy_default_test_email' ] ) ){
            echo smtp_override_cbezzy_send_test_email_1507709700( filter_var( trim( $_POST[ 'smtp_override_cbezzy_default_test_email' ] ) ) );
        }
    }
}

/*
 * @function smtp_override_cbezzy_send_test_email_1507709700
 * 
 * this saves the smtp settings to the wordpress database 
 * @return string = text for output
 */
function smtp_override_cbezzy_send_test_email_1507709700( $to ){  
        $return = '<h3>SENDING A TEST EMAIL TO : '.$to.'</h3>'; 
        if ( filter_var( $to , FILTER_VALIDATE_EMAIL ) !== false ) {
               $subject = "SMTP Settings test email";
               $body = ' <h3>THIS IS A TEST EMAIL SENT FROM WORDPRESS USING THE NEW SMTP SETTINGS</h3> <b>If you received this, the email settings are correct</b>';
               ini_set( 'display_errors'  , 1 );
               $result = wp_mail( $to, $subject, $body ) ;
               if (!$result) {
                    global $ts_mail_errors;
                    global $phpmailer;
                    if (!isset($ts_mail_errors)){
                          $ts_mail_errors = array();
                    }
                    if (isset($phpmailer)) {
                          $ts_mail_errors[] = $phpmailer->ErrorInfo;
                    } 
                    $return .= '<h3>Error sending test email, the error report is below</h3><blockquote><ul>';
                    foreach($ts_mail_errors as $errorMsg){
                          $return .= '<li>'.$errorMsg.'</li>';
                    }
                    $return .= '</ul></blockquote>';
              }else{
                    $return .= '<h3>Test email sent</h3>';
              }
        } else {
              $return .= '<h1>' . $to . ' is NOT a valid email address</h1>';
        } 
        return $return;
}

/*
 * @function smtp_clean_fetch_option_cbezzy_1507709700
 * @param String option to fetch
 * 
 * cleans and returns an option from wordpress
 * 
 * @return String
 */
function smtp_clean_fetch_option_cbezzy_1507709700( $option , $default = '' ){
    $cleanOption = trim( sanitize_text_field( $option ) );
    if( $cleanOption === '' ) return '';
    return sanitize_text_field( get_option( $cleanOption , $default ) );
}