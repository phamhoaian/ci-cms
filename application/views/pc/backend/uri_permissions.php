<br><br><br><br>

<a href="<?php echo site_url("auth/backend");?>"><button class="btn">戻る</button></a>
<br>


	<?php  				
		// Build drop down menu
		foreach ($roles as $role)
		{
			$options[$role->id] = $role->name;
		}
		
		// Change allowed uri to string to be inserted in text area
		if ( ! empty($allowed_uris))
		{
			$allowed_uris = implode("\n", $allowed_uris);
		}
		
		// Build form
		echo form_open($this->uri->uri_string());
		
		echo form_label('ロール（権限）', 'role_name_label');
		echo form_dropdown('role', $options); 
		echo form_submit('show', '状態を見る'); 
		
		echo form_label('', 'uri_label');
				
		echo '<hr/>';
				
		echo '許可されたURI:<br/><br/>';
		
		echo "ロールを選択し、「状態を見る」をクリックすれば、そのロールのアクセス一覧が表示されます。<br/>";
		echo "許可したいURLがある場合は<br/>";
		echo "入力は '/' からはじめてください。<br/>";
		echo "'/モジュール名/関数名/' といれてください。モジュール名だけを入れればそのモジュール全体にアクセスできるようになります。<br/><br/>";
		echo 'これらを有効にするには$this->chk_permission();をモジュールに入れる必要があります。<br/><br/>.';
		
		echo form_textarea('allowed_uris', $allowed_uris); 
				
		echo '<br/>';
		echo form_submit('save', '変更・保存');
		
		echo form_close();
	?>


