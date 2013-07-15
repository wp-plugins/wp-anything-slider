<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';

// First check if ID exist with requested ID
$sSql = $wpdb->prepare(
	"SELECT COUNT(*) AS `count` FROM ".WP_ANYTHING_SETTINGS."
	WHERE `wpanything_sid` = %d",
	array($did)
);
$result = '0';
$result = $wpdb->get_var($sSql);

if ($result != '1')
{
	?><div class="error fade"><p><strong>Oops, selected details doesn't exist.</strong></p></div><?php
}
else
{
	$wpanything_errors = array();
	$wpanything_success = '';
	$wpanything_error_found = FALSE;
	
	$sSql = $wpdb->prepare("
		SELECT *
		FROM `".WP_ANYTHING_SETTINGS."`
		WHERE `wpanything_sid` = %d
		LIMIT 1
		",
		array($did)
	);
	$data = array();
	$data = $wpdb->get_row($sSql, ARRAY_A);
	
	// Preset the form fields
	$form = array(
		'wpanything_sname' => $data['wpanything_sname'],
		'wpanything_sdirection' => $data['wpanything_sdirection'],
		'wpanything_sspeed' => $data['wpanything_sspeed'],
		'wpanything_stimeout' => $data['wpanything_stimeout'],
		'wpanything_srandom' => $data['wpanything_srandom'],
		'wpanything_sextra' => $data['wpanything_sextra'],
		'wpanything_sid' => $data['wpanything_sid']
	);
}
// Form submitted, check the data
if (isset($_POST['wpanything_form_submit']) && $_POST['wpanything_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('wpanything_form_edit');
	
	$form['wpanything_sname'] = isset($_POST['wpanything_sname']) ? $_POST['wpanything_sname'] : '';
	$form['wpanything_sdirection'] = isset($_POST['wpanything_sdirection']) ? $_POST['wpanything_sdirection'] : '';
	$form['wpanything_sspeed'] = isset($_POST['wpanything_sspeed']) ? $_POST['wpanything_sspeed'] : '';
	$form['wpanything_stimeout'] = isset($_POST['wpanything_stimeout']) ? $_POST['wpanything_stimeout'] : '';

	//	No errors found, we can add this Group to the table
	if ($wpanything_error_found == FALSE)
	{	
		$sSql = $wpdb->prepare(
				"UPDATE `".WP_ANYTHING_SETTINGS."`
				SET `wpanything_sdirection` = %s,
				`wpanything_sspeed` = %s,
				`wpanything_stimeout` = %s
				WHERE wpanything_sid = %d
				LIMIT 1",
				array($form['wpanything_sdirection'], $form['wpanything_sspeed'], $form['wpanything_stimeout'], $did)
			);
		$wpdb->query($sSql);
		
		$wpanything_success = 'Details was successfully updated.';
	}
}

if ($wpanything_error_found == TRUE && isset($wpanything_errors[0]) == TRUE)
{
?>
  <div class="error fade">
    <p><strong><?php echo $wpanything_errors[0]; ?></strong></p>
  </div>
  <?php
}
if ($wpanything_error_found == FALSE && strlen($wpanything_success) > 0)
{
?>
  <div class="updated fade">
    <p><strong><?php echo $wpanything_success; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=wp-anything-slider&ac=showcycle">Click here</a> to view the details</strong></p>
  </div>
  <?php
}
?>
<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/wp-anything-slider/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php echo Wp_wpanything_TITLE; ?></h2>
	<form name="wpanything_setting_form" method="post" action="#" onsubmit="return wpanything_setting_submit()"  >
      <h3>Update details</h3>
	  
	  <label for="tag-title">Setting name</label>
		<select name="wpanything_sname" id="wpanything_sname" disabled="disabled">
			<option value="">Select</option>
            <?php
            for($i=1; $i<=10; $i++)
			{
				if($form['wpanything_sname'] == 'SETTING'.$i) 
				{ 
					$selected = "selected='selected'" ; 
				}
				else
				{
					$selected = '' ; 
				}
				echo "<option value='SETTING".$i."' $selected>SETTING".$i."</option>";
			}
			?>
          </select>
		<p>Select a setting name.</p>
				
		<label for="tag-title">Speed</label>
		<input name="wpanything_sspeed" type="text" id="wpanything_sspeed" value="<?php echo $form['wpanything_sspeed']; ?>" maxlength="5" />
		<p>Enter your speed. Ex: 700</p>
		
		<label for="tag-title">Timeout</label>
		<input name="wpanything_stimeout" type="text" id="wpanything_stimeout" value="<?php echo $form['wpanything_stimeout']; ?>" maxlength="5" />
		<p>Enter your timeout. Ex: 5000</p>
		
		<label for="tag-title">Direction</label>
		<select name="wpanything_sdirection" id="wpanything_sdirection">
            <option value='scrollLeft' <?php if($form['wpanything_sdirection']== 'scrollLeft') { echo 'selected' ; } ?>>scrollLeft</option>
            <option value='scrollRight' <?php if($form['wpanything_sdirection'] == 'scrollRight') { echo 'selected' ; } ?>>scrollRight</option>
            <option value='scrollUp' <?php if($form['wpanything_sdirection'] == 'scrollUp') { echo 'selected' ; } ?>>scrollUp</option>
            <option value='scrollDown' <?php if($form['wpanything_sdirection'] == 'scrollDown') { echo 'selected' ; } ?>>scrollDown</option>
          </select>
		<p>Selct cycle direction.</p>
		
	  
      <input name="wpanything_sid" id="wpanything_sid" type="hidden" value="<?php echo $form['wpanything_sid']; ?>">
      <input type="hidden" name="wpanything_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="Update Details" type="submit" />&nbsp;
        <input name="publish" lang="publish" class="button add-new-h2" onclick="wpanything_setting_redirect()" value="Cancel" type="button" />&nbsp;
        <input name="Help" lang="publish" class="button add-new-h2" onclick="wpanything_help()" value="Help" type="button" />
      </p>
	  <?php wp_nonce_field('wpanything_form_edit'); ?>
    </form>
</div>
<p class="description"><?php echo Wp_wpanything_LINK; ?></p>
</div>