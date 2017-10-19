    <form id="smtp_override_cbezzy_form" method="post"> 
        <h2>SMTP SERVER SETTINGS :</h2>
        <blockquote>
            <table style="width:100%" cellpadding="10">
                <tr>
                    <td width="100"><b>Server</b></td>
                    <td><input style="width:95%" type="text" name="smtp_override_cbezzy_server" value="<?= smtp_clean_fetch_option_cbezzy_1507709700( 'smtp_override_cbezzy_server' , '' ) ?>" /></td>
                    <td width="150" align="right" ><b>Port</b></td>
                    <td><input style="width:95%" type="text" name="smtp_override_cbezzy_port"   value="<?= smtp_clean_fetch_option_cbezzy_1507709700( 'smtp_override_cbezzy_port'   , '' ) ?>" /></td>

                </tr>
                <tr>
                    <td><b>SSL/TLS</b></td>
                    <td>
                        <?php $smtp_override_cbezzy_security = smtp_clean_fetch_option_cbezzy_1507709700( 'smtp_override_cbezzy_security' , 'none' ) ?>
                        <label><input type="radio" name="smtp_override_cbezzy_security" value="none" <?= $smtp_override_cbezzy_security === 'none' ? 'checked' : '' ?> /> None</label></a>
                        <label><input type="radio" name="smtp_override_cbezzy_security" value="ssl"  <?= $smtp_override_cbezzy_security === 'ssl'  ? 'checked' : '' ?> /> SSL</label></a>
                        <label><input type="radio" name="smtp_override_cbezzy_security" value="tls"  <?= $smtp_override_cbezzy_security === 'tls'  ? 'checked' : '' ?> /> TLS</label></a>
                    </td>
                    <td align="right">
                        <label for="bypassSSL"><b>Allow self signed SSL:</b></label>
                    </td>
                    <td>
                        <input id="bypassSSL" type="checkbox" <?= ( smtp_clean_fetch_option_cbezzy_1507709700( 'smtp_override_cbezzy_bypass_ssl_verify' , '' ) == '1' ? 'checked' : '' ) ?> name="smtp_override_cbezzy_bypass_ssl_verify" value="1" />
                    </td>
                </tr>
                <tr><td colspan="4"><hr /></td></tr>
                <tr>
                    <td><b>Username</b></td>
                    <td><input style="width:95%" type="text"     name="smtp_override_cbezzy_username" value="<?= smtp_clean_fetch_option_cbezzy_1507709700( 'smtp_override_cbezzy_username' , '' ) ?>" /></td>
                    <td align="right"><b>Password</b></td>
                    <td><input style="width:95%" type="password" name="smtp_override_cbezzy_password" value="<?= base64_decode( get_option( 'smtp_override_cbezzy_password' , '' ) ) ?>" /></td>

                </tr>
                <tr><td colspan="4"><hr /></td></tr>
                <tr>
                    <td><b>From address</b></td>
                    <td><input style="width:95%" type="text" name="smtp_override_cbezzy_from_address"  value="<?= smtp_clean_fetch_option_cbezzy_1507709700('smtp_override_cbezzy_from_address', '') ?>" /></td>
                    <td align="right"><b>From name</b></td>
                    <td><input style="width:95%" type="text" name="smtp_override_cbezzy_from_name"     value="<?= smtp_clean_fetch_option_cbezzy_1507709700('smtp_override_cbezzy_from_name'   , '') ?>" /></td>

                </tr>
                <tr>
                    <td><b>Reply to</b></td>
                    <td><input style="width:95%" type="text" name="smtp_override_cbezzy_reply_to"      value="<?= smtp_clean_fetch_option_cbezzy_1507709700('smtp_override_cbezzy_reply_to'    , '') ?>" /></td>
                </tr>
                <tr>
                    <td><b>Test Email Address</b></td>
                    <td><input type="email" name="smtp_override_cbezzy_default_test_email" value="<?= get_option('smtp_override_cbezzy_default_test_email', '') ?>" style="width:95%" /></td>
                    <td colspan="2"><input style="width:100%" type="submit" name="saveAndSendTest" value="Save and send a test email" class="button button-primary" /></td>
                </tr>
                <tr> 
                    <td colspan="4">
                        <br /><br />
                        <input type="submit" value="Save Without sending a test email" class="button button-primary" style="height:100px; width:100%" />
                    </td>
                </tr>
            </table>
        </blockquote>
    </form>
<script>
    jQuery("#smtp_override_cbezzy_form").submit( function(){
       jQuery("body").append("<div style='position: absolute; top:0; left:0; width:100%; height:100%; background-color: rgba( 32,36,40, 0.95')>&nspb;</div>");
       jQuery("body").append("<div style='position: absolute; top:49%; left:0; width:100%; text-align:center; color: white; font-weight: bold; font-size:3em;')>Saving...</div>");
    });
</script>