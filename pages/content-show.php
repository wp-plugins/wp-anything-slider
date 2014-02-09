<?php
// Form submitted, check the data
if (isset($_POST['frm_wpanything_display']) && $_POST['frm_wpanything_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	
	$wpanything_success = '';
	$wpanything_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$sSql = $wpdb->prepare(
		"SELECT COUNT(*) AS `count` FROM ".WP_ANYTHING_CONTENT."
		WHERE `wpanything_cid` = %d",
		array($did)
	);

	$result = '0';
	$result = $wpdb->get_var($sSql);
	
	if ($result != '1')
	{
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', 'wp-anything-slider'); ?></strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('wpanything_form_show');
			
			//	Delete selected record from the table
			$sSql = $wpdb->prepare("DELETE FROM `".WP_ANYTHING_CONTENT."`
					WHERE `wpanything_cid` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			//	Set success message
			$wpanything_success_msg = TRUE;
			$wpanything_success = __('Selected record was successfully deleted ('.$did.').', 'wp-anything-slider');
		}
	}
	
	if ($wpanything_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $wpanything_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e('Wp anything slider', 'wp-anything-slider'); ?></h2>
    <h3><?php _e('Text management', 'wp-anything-slider'); ?><a class="add-new-h2" href="<?php echo WP_wpanything_ADMIN_URL; ?>&amp;ac=add">Add New</a></h3>
	<div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".WP_ANYTHING_CONTENT."` order by wpanything_cid desc";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo WP_wpanything_PLUGIN_URL; ?>/pages/setting.js"></script>
		<form name="frm_wpanything_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="col" style="width:15px;"><input type="checkbox" name="wpanything_group_item[]" /></th>
			<th scope="col"><?php _e('Text', 'wp-anything-slider'); ?></th>
            <th scope="col"><?php _e('Setting', 'wp-anything-slider'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="col" style="height:15px;"><input type="checkbox" name="wpanything_group_item[]" /></th>
			<th scope="col"><?php _e('Text', 'wp-anything-slider'); ?></th>
            <th scope="col"><?php _e('Setting', 'wp-anything-slider'); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td align="left"><input type="checkbox" value="<?php echo $data['wpanything_cid']; ?>" name="wpanything_group_item[]"></td>
						<td><?php echo stripslashes($data['wpanything_ctitle']); ?>
						<div class="row-actions">
							<span class="edit"><a title="Edit" href="<?php echo WP_wpanything_ADMIN_URL; ?>&amp;ac=edit&amp;did=<?php echo $data['wpanything_cid']; ?>"><?php _e('Edit', 'wp-anything-slider'); ?></a> | </span>
							<span class="trash"><a onClick="javascript:wpanything_content_delete('<?php echo $data['wpanything_cid']; ?>')" href="javascript:void(0);"><?php _e('Delete', 'wp-anything-slider'); ?></a></span> 
						</div>
						</td>
						<td><?php echo stripslashes($data['wpanything_csetting']); ?></td>
					</tr>
					<?php 
					$i = $i+1; 
				} 	
			}
			else
			{
				?><tr><td colspan="3" align="center"><?php _e('No records available.', 'wp-anything-slider'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('wpanything_form_show'); ?>
		<input type="hidden" name="frm_wpanything_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <!--<a class="button add-new-h2" href="<?php echo WP_wpanything_ADMIN_URL; ?>&amp;ac=add">Add New</a>-->
	  <a class="button add-new-h2" href="<?php echo WP_wpanything_ADMIN_URL; ?>&amp;ac=show"><?php _e('Text Management', 'wp-anything-slider'); ?></a>
	  <a class="button add-new-h2" href="<?php echo WP_wpanything_ADMIN_URL; ?>&amp;ac=showcycle"><?php _e('Setting', 'wp-anything-slider'); ?></a>
	  <a class="button add-new-h2" href="<?php echo WP_wpanything_ADMIN_URL; ?>&amp;ac=showcycle"><?php _e('View Shortcode', 'wp-anything-slider'); ?></a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo Wp_wpanything_FAV; ?>"><?php _e('Help', 'wp-anything-slider'); ?></a>
	  </h2>
	  </div>
	  <div style="height:5px"></div>
	<h3><?php _e('Plugin configuration option', 'wp-anything-slider'); ?></h3>
	<ol>
		<li><?php _e('Add the plugin in the posts or pages using short code.', 'wp-anything-slider'); ?></li>
		<li><?php _e('Add directly in to the theme using PHP code.', 'wp-anything-slider'); ?></li>
		<li><?php _e('Drag and drop the widget to your sidebar.', 'wp-anything-slider'); ?></li>
	</ol>
	<p class="description">
		<?php _e('Check official website for more information', 'wp-anything-slider'); ?>
		<a target="_blank" href="<?php echo Wp_wpanything_FAV; ?>"><?php _e('click here', 'wp-anything-slider'); ?></a>
	</p>
	</div>
</div>