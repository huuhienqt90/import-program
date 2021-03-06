<?php ob_start(); ?>
<div class="hh_notice">
    <img src="<?php echo __IZIPURL__; ?>assets/front-end/images/mt_alert_banner.gif">
    Be the first to know when a new drug for this condition is available
</div>
<?php
$condition = get_query_var('advanced_search');
$country = get_query_var('country');
if ($condition == 'hh_search' || $condition == '0') {
    $condition = '';
}
$condition = trim(str_replace("-", " ", $condition));
$country = trim(str_replace("-", " ", @$country));
?>
<!--END .hh_notice -->
<div class="hh_notification">
    <?php
    global $wpdb;
    $sidebar_noti_mess = '';
    if( isset( $_POST['send_mail_sidebar']) ){
        $izw_notification = $wpdb->prefix."subscription";
        $noti_ID = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT `ID` FROM `{$izw_notification}`
                                WHERE `search_condition` = '%s'
                                AND `search_country` = '%s'
                                AND `email` = '%s'",
                $_POST['sidebar_noti_condition'],
                $_POST['sidebar_noti_country'],
                $_POST['sidebar_noti_email']
            )
        );
        if( empty( $noti_ID ) ){
            $data = array(
                'search_condition' => $_POST['sidebar_noti_condition'],
                'search_country' => $_POST['sidebar_noti_country'],
                'date' => date("Y-m-d H:i:s"),
                'email' => $_POST['sidebar_noti_email'],
            );
            $wpdb->insert( $izw_notification, $data );
            $sidebar_noti_mess = "Notification Received.";
        }
    }
    ?>
    <p style="color: green;font-size: 1.4em;"><?php echo $sidebar_noti_mess; ?></p>
    <form name="notification" action="" method="post" id="notification">
        <p>
            <label for="noti_condition">Condition:</label>
            <input type="text" name="sidebar_noti_condition" id="sidebar_noti_condition"
                   value="<?php print str_replace("\'", "'", $condition ); ?>"/>
        </p>

        <p>
            <label for="noti_country">Country:</label>
            <input type="text" name="noti_country" id="sidebar_noti_country"
                   value="<?php print str_replace("\'", "'", $country); ?>"/>
        </p>

        <p>
            <label for="noti_email">Email:</label>
            <input type="text" name="noti_email" id="sidebar_noti_email" value=""/>
        </p>

        <p>
            <input type="submit" name="send_mail_sidebar" value="Sign-up"/>
        </p>
    </form>
</div>
<!-- END .hh_notification -->
<div class="hh_counter">
    <?php echo do_shortcode( '[milestone symbol_position="after" color="Accent-Color" terms="exclude-clinical-trials" counter_type="eap" subject="Ongoing Early Access Programs" symbol=""]'); ?>

    <?php echo do_shortcode( '[milestone symbol_position="after" color="Extra-Color-1" terms="include-clinical-trials" counter_type="c" subject="Ongoing Clinical Trials" symbol=""]');?>
    <?php dynamic_sidebar('izw-result-sidebar'); ?>
</div>
<!-- END .hh_counter -->
<?php return ob_get_clean(); ?>