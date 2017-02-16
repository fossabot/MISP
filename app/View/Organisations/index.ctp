<div class="organisations index">
<?php
	$texts = array(
			'all' => array(
					'text' => 'All organisations',
					'extra' => ', both local and remote'
			),
			'external' => array(
					'text' => 'Known remote organisations',
					'extra' => ' on other instances'
			),
			'local' => array(
					'text' => 'Local organisations',
					'extra' => ' having a presence on this instance'
			),
	);
	if (!in_array($scope, array_keys($texts))) $scope = 'local';
	$partial = array();
	foreach($named as $key => $value):
		if ($key == 'page' || $key == 'viewall'):
			continue;
		endif;
		$partial[] = h($key) . ':' . h($value);
	endforeach;
	$viewall_button_text = 'Paginate';
	if (!$viewall):
		$viewall_button_text = 'View all';
		$partial[] = 'viewall:1';
	endif;
?>
	<h2><?php echo $texts[$scope]['text'] . $texts[$scope]['extra']; ?></h2>
	<div class="pagination">
		<ul>
			<?php
				$this->Paginator->options(array(
						'update' => '.span12',
						'evalScripts' => true,
						'before' => '$(".progress").show()',
						'complete' => '$(".progress").hide()',
				));
				
				echo $this->Paginator->prev('&laquo; ' . __('previous'), array('tag' => 'li', 'escape' => false), null, array('tag' => 'li', 'class' => 'prev disabled', 'escape' => false, 'disabledTag' => 'span'));
				echo $this->Paginator->numbers(array('modulus' => 20, 'separator' => '', 'tag' => 'li', 'currentClass' => 'active', 'currentTag' => 'span'));
				echo $this->Paginator->next(__('next') . ' &raquo;', array('tag' => 'li', 'escape' => false), null, array('tag' => 'li', 'class' => 'next disabled', 'escape' => false, 'disabledTag' => 'span'));
			?>
			<li class="all">
				<a href="<?php echo $baseurl . '/organisations/index/' . implode('/', $partial); ?>"><?php echo $viewall_button_text; ?></a>
			</li>
        </ul>
    </div>
    <div class="tabMenuFixedContainer" style="display:inline-block;">
    <?php
		foreach (array('local', 'external', 'all') as $scopeChoice):
    ?>
		<span class="tabMenuFixed tabMenuFixedCenter tabMenuSides useCursorPointer <?php if ($scope === $scopeChoice) echo 'tabMenuActive';?>" onClick="window.location='/organisations/index/scope:<?php echo h($scopeChoice);?>'"><?php echo $texts[$scopeChoice]['text'];?></span>
    <?php
		endforeach;
    ?>
		<span id="quickFilterButton" class="tabMenuFilterFieldButton useCursorPointer" onClick="quickFilter(<?php echo  h($passedArgs); ?>, '<?php echo $baseurl . '/organisations/index'; ?>');">Filter</span>
		<input class="tabMenuFilterField" type="text" id="quickFilterField"></input>
    </div>
	<table class="table table-striped table-hover table-condensed">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th>Logo</th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<?php if ($isSiteAdmin): ?>
				<th><?php echo $this->Paginator->sort('uuid');?></th>
			<?php endif; ?>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('nationality');?></th>
			<th><?php echo $this->Paginator->sort('sector');?></th>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th><?php echo $this->Paginator->sort('contacts');?></th>
			<?php if ($isSiteAdmin): ?>
				<th>Added by</th>
			<?php endif; ?>
			<th><?php echo $this->Paginator->sort('local');?></th>
			<th>Users</th>
			<th class="actions">Actions</th>
	</tr>
	<?php
foreach ($orgs as $org): ?>
	<tr>
		<td class="short" ondblclick="document.location.href ='/organisations/view/<?php echo $org['Organisation']['id'];?>'"><?php echo h($org['Organisation']['id']); ?></td>
		<td class="short" ondblclick="document.location.href ='/organisations/view/<?php echo $org['Organisation']['id'];?>'">
			<?php
				$imgRelativePath = 'orgs' . DS . h($org['Organisation']['name']) . '.png';
				$imgAbsolutePath = APP . WEBROOT_DIR . DS . 'img' . DS . $imgRelativePath;
				if (file_exists($imgAbsolutePath)) echo $this->Html->image('orgs/' . h($org['Organisation']['name']) . '.png', array('alt' => h($org['Organisation']['name']), 'title' => h($org['Organisation']['name']), 'style' => 'width:24px; height:24px'));
				else echo $this->Html->tag('span', h($org['Organisation']['name']), array('class' => 'welcome', 'style' => 'float:left;'));
			?>
		</td>
		<td class="short" ondblclick="document.location.href ='/organisations/view/<?php echo $org['Organisation']['id'];?>'"><?php echo h($org['Organisation']['name']); ?></td>
		<?php if ($isSiteAdmin): ?>
			<td class="short" ondblclick="document.location.href ='/organisations/view/<?php echo $org['Organisation']['id'];?>'"><?php echo h($org['Organisation']['uuid']); ?></td>
		<?php endif; ?>
		<td ondblclick="document.location.href ='/organisations/view/<?php echo $org['Organisation']['id'];?>'"><?php echo h($org['Organisation']['description']); ?></td>
		<td class="short" ondblclick="document.location.href ='/organisations/view/<?php echo $org['Organisation']['id'];?>'"><?php echo h($org['Organisation']['nationality']); ?></td>
		<td class="short" ondblclick="document.location.href ='/organisations/view/<?php echo $org['Organisation']['id'];?>'"><?php echo h($org['Organisation']['sector']); ?></td>
		<td class="short" ondblclick="document.location.href ='/organisations/view/<?php echo $org['Organisation']['id'];?>'"><?php echo h($org['Organisation']['type']); ?></td>
		<td><?php echo h($org['Organisation']['contacts']); ?></td>
		<?php if ($isSiteAdmin): ?>
			<td class="short" ondblclick="document.location.href ='/organisations/view/<?php echo $org['Organisation']['id'];?>'">
				<?php echo (isset($org['Organisation']['created_by_email'])) ? h($org['Organisation']['created_by_email']) : '&nbsp;'; ?>
			</td>
		<?php endif; ?>
		<td class="short <?php echo $org['Organisation']['local'] ? 'green' : 'red';?>" ondblclick="document.location.href ='/organisations/view/<?php echo $org['Organisation']['id'];?>'"><?php echo $org['Organisation']['local'] ? 'Yes' : 'No';?></td>
		<td class="short"><?php echo isset($org['Organisation']['user_count']) ? $org['Organisation']['user_count'] : '0';?></td>
		<td class="short action-links">
			<?php if ($isSiteAdmin): ?>
				<a href='/admin/organisations/edit/<?php echo $org['Organisation']['id'];?>' class = "icon-edit" title = "Edit"></a>
				<?php
					echo $this->Form->postLink('', array('admin' => true, 'action' => 'delete', $org['Organisation']['id']), array('class' => 'icon-trash', 'title' => 'Delete'), __('Are you sure you want to delete %s?', $org['Organisation']['name']));
				?>
			<?php endif; ?>
			<a href='/organisations/view/<?php echo $org['Organisation']['id']; ?>' class = "icon-list-alt" title = "View"></a>
		</td>
	</tr>
	<?php
endforeach; ?>
	</table>
	<p>
    <?php
    echo $this->Paginator->counter(array(
    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
    ));
    ?>
    </p>
    <div class="pagination">
        <ul>
        <?php
            echo $this->Paginator->prev('&laquo; ' . __('previous'), array('tag' => 'li', 'escape' => false), null, array('tag' => 'li', 'class' => 'prev disabled', 'escape' => false, 'disabledTag' => 'span'));
            echo $this->Paginator->numbers(array('modulus' => 20, 'separator' => '', 'tag' => 'li', 'currentClass' => 'active', 'currentTag' => 'span'));
            echo $this->Paginator->next(__('next') . ' &raquo;', array('tag' => 'li', 'escape' => false), null, array('tag' => 'li', 'class' => 'next disabled', 'escape' => false, 'disabledTag' => 'span'));
        ?>
        	<li class="all">
				<a href="<?php echo $baseurl . '/organisations/index/' . implode('/', $partial); ?>"><?php echo $viewall_button_text; ?></a>
			</li>
        </ul>
    </div>

</div>
<?php
	if ($isSiteAdmin) echo $this->element('side_menu', array('menuList' => 'admin', 'menuItem' => 'indexOrg'));
	else echo $this->element('side_menu', array('menuList' => 'globalActions', 'menuItem' => 'indexOrg'));
?>
