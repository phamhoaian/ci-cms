<br><br><br><br>

<a href="<?php echo site_url("auth/backend");?>"><button class="btn">戻る</button></a>
<br>

大変重要な画面なので、決して誤った操作をしないでください。<br /><br />
	<?php
		// Show error
		echo validation_errors();
		
		// Build drop down menu
		$options[0] = 'None';
		foreach ($roles as $role)
		{
			$options[$role->id] = $role->name;
		}
	
		// Build table
		$this->table->set_heading('', 'ID', 'ロール名', '親ID');
		
		foreach ($roles as $role)
		{			
			$this->table->add_row(form_checkbox('checkbox_'.$role->id, $role->id), $role->id, $role->name, $role->parent_id);
		}
		
		// Build form
		
		$attributes = array('onSubmit' => "return confirm('本当によろしいですか？')");
		echo form_open($this->uri->uri_string(), $attributes);
		
		echo form_label('親ロール', 'role_parent_label');
		echo form_dropdown('role_parent', $options); 
				
		echo form_label('ロール名', 'role_name_label');
		echo form_input('role_name', ''); 
		
		echo form_submit('add', 'ロールの追加'); 
		echo form_submit('delete', '選択したロールを削除');
				
		echo '<hr/>';
		
		// Show table
		echo '<DIV class="color3" style="width: 100%">';
		
		
		$tmpl = array (
			'table_open'          => '<table cellSpacing="1" cellPadding="5" width="100%" border="0">',

			'heading_row_start'   => '<tr>',
			'heading_row_end'     => '</tr>',
			'heading_cell_start'  => '<td align="center" class="color1"><small>',
			'heading_cell_end'    => '</small></td>',

			'row_start'           => '<tr bgcolor="#FFFFFF">',
			'row_end'             => '</tr>',
			'cell_start'          => '<td class="kiji_text">',
			'cell_end'            => '</td>',

			'row_alt_start'       => '<tr bgcolor="#EEEEEE">',
			'row_alt_end'         => '</tr>',
			'cell_alt_start'      => '<td class="kiji_text">',
			'cell_alt_end'        => '</td>',

			'table_close'         => '</table>'
		);
		$this->table->set_template($tmpl);
		
		
		echo $this->table->generate(); 
		
		echo form_close();
			
	?>
	
</div>

